<?php

namespace App\Http\Controllers\Admin;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function list(){
        $default_lang = Config::get('app.locale');
        $subcategories = SubCategory::where('translation_lang', $default_lang)->get();
        return view('admin.subcategories.list', compact('subcategories'));
    }
    public function create()
    {
        $categories = Category::all();
        $languages = Category::select('translation_lang')->distinct()->get();

        return view('admin.subcategories.create', compact('categories', 'languages'));
    }
    public function store(Request $request){
        $request->validate([
            'subcategory' => 'required|array|min:1',
            'subcategory.*' => 'required|array|min:1',
            'subcategory.*.subcat_name' => 'required|string|max:50',
            'subcategory.*.subcat_description' => 'string|max:255',
            'subcategory.*.category_id' => 'exists:categories,id',
            'subcategory.*.translation_lang' => 'required|max:10|string|distinct',
            'img' => 'required|image|mimes:jpeg,png,jpg,svg,heic',
            'subcategory.*.status' => 'required|in:0,1',
        ], [
            'subcategory.array' => 'The data should be an array.',
            'subcategory.min' => 'At least one language is required.',
            'subcategory.*.subcat_name.required' => 'The subcategory name is required.',
            'subcategory.*.subcat_name.string' => 'The subcategory name must be a string.',
            'subcategory.*.subcat_name.max' => 'The subcategory name may not be greater than 50 characters.',
            'subcategory.*.subcat_name.distinct' => 'Each subcategory name must be unique.',
            'subcategory.*.subcat_description.string' => 'The subcategory description must be a string.',
            'subcategory.*.subcat_description.max' => 'The subcategory description may not be greater than 255 characters.',
            'subcategory.*.category_id.required' => 'The category is required.',
            'subcategory.*.category_id.integer' => 'The category ID must be an integer.',
            'subcategory.*.category_id.exists' => 'The selected category does not exist.',
            'subcategory.*.translation_lang.required' => 'The translation language is required.',
            'subcategory.*.translation_lang.max' => 'The translation language may not be greater than 10 characters.',
            'subcategory.*.translation_lang.string' => 'The translation language must be a string.',
            'subcategory.*.translation_lang.distinct' => 'Each translation language must be unique.',
            'img.required' => 'The subcategory image is required.',
            'img.image' => 'The file must be an image.',
            'img.mimes' => 'The image must be of type: jpeg, png, jpg, svg, heic.',
            'subcategory.*.status.required' => 'The status field is required.',
            'subcategory.*.status.in' => 'The status must be either active (1) or inactive (0).',
        ]);
        try {
            $subcat = collect($request->subcategory);
            $filter = $subcat->filter(function($value) {
                return $value['translation_lang'] == Config::get('app.locale');
            });
        
            $default_subcat_lang = $filter->first();
        
            $imagePath = null;
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = 'uploads/subcategories';
        
                if (!File::exists(public_path($path))) {
                    File::makeDirectory(public_path($path), 0755, true);
                }
        
                $image->move(public_path($path), $imageName);
                $imagePath = $path . '/' . $imageName;
            }
        
            $default_subcat = SubCategory::create([
                'name' => $default_subcat_lang['subcat_name'],
                'description' => $default_subcat_lang['subcat_description'],
                'category_id' => $default_subcat_lang['category_id'],
                'translation_lang' => Config::get('app.locale'),
                'translation_of' => 0,
                'active' => $default_subcat_lang['status'],
                'photo' => $imagePath,
            ]);
        
            $subcat_arr = [];
            foreach ($subcat as $value) {
                if ($value['translation_lang'] != Config::get('app.locale')) {
                    $subcat_arr[] = [
                        'name' => $value['subcat_name'],
                        'description' => $value['subcat_description'],
                        'category_id' => $value['category_id'],
                        'translation_lang' => $value['translation_lang'],
                        'translation_of' => $default_subcat->id,
                        'active' => $value['status'],
                        'photo' => $imagePath,
                    ];
                }
            }
        
            if (!empty($subcat_arr)) {
                SubCategory::insert($subcat_arr);
            }
            return redirect()->route('dashboard.subcategories.list')->with('success', 'subcategories created successfully.');
        } catch (Exception $e) {
            return redirect()->route('dashboard.subcategories.add')->with('error', $e->getMessage());
        }
    }

    public function edit($id){
        $categories = Category::all();
        $subcategory = SubCategory::find($id);
        if(!$subcategory){
            return redirect()->route('dashboard.subcategories.list')->with('error', 'Subcategory not found');
        }
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update($id, Request $request){
        $request->validate([
            'subcategory' => 'required_without:id|array|min:1',
            'subcategory.*' => 'required_without:id|array|min:1',
            'subcategory.*.subcat_name' => 'required_without:id|string|max:50',
            'subcategory.*.subcat_description' => 'string|max:255',
            'subcategory.*.category_id' => 'exists:categories,id',
            'subcategory.*.translation_lang' => 'required_without:id|max:10|string|distinct',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,svg,heic',
            'subcategory.*.status' => 'required_without:id|in:0,1',
        ],[
            'subcategory.array' => 'The data should be an array.',
            'subcategory.min' => 'At least one language is required.',
            'subcategory.*.subcat_name.required' => 'The subcategory name is required.',
            'subcategory.*.subcat_name.string' => 'The subcategory name must be a string.',
            'subcategory.*.subcat_name.max' => 'The subcategory name may not be greater than 50 characters.',
            'subcategory.*.subcat_name.distinct' => 'Each subcategory name must be unique.',
            'subcategory.*.subcat_description.string' => 'The subcategory description must be a string.',
            'subcategory.*.subcat_description.max' => 'The subcategory description may not be greater than 255 characters.',
            'subcategory.*.category_id.exists' => 'The selected category does not exist.',
            'subcategory.*.translation_lang.required' => 'The translation language is required.',
            'subcategory.*.translation_lang.max' => 'The translation language may not be greater than 10 characters.',
            'subcategory.*.translation_lang.string' => 'The translation language must be a string.',
            'subcategory.*.translation_lang.distinct' => 'Each translation language must be unique.',
            'img.image' => 'The file must be an image.',
            'img.mimes' => 'The image must be of type: jpeg, png, jpg, svg, heic.',
            'subcategory.*.status.required' => 'The status field is required.',
            'subcategory.*.status.in' => 'The status must be either active (1) or inactive (0).',
        ]);
        try {
            $subcategory = SubCategory::findOrFail($id);

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $path = 'uploads/subcategories';

                $old_subcat_img = $subcategory->photo;
                if (File::exists(public_path('/'.$old_subcat_img))) {
                    File::delete(public_path('/'.$old_subcat_img));
                }

                $image->move(public_path($path), $filename);
                $subcategory->photo = $path.'/'.$filename;
                $subcategory->save();
            }

            $subcategories = $request->input('subcategory', []);
            foreach ($subcategories as $key => $subcategoryData) {
                $existingSubcategory = SubCategory::where('id', $key)
                    ->where('translation_lang', $subcategoryData['translation_lang'])
                    ->first();

                if ($existingSubcategory) {
                    $existingSubcategory->update([
                        'name' => $subcategoryData['subcat_name'] ?? $existingSubcategory->name,
                        'description' => $subcategoryData['subcat_description'] ?? $existingSubcategory->description,
                        'translation_lang' => $subcategoryData['translation_lang'] ?? $existingSubcategory->translation_lang,
                        'active' => $subcategoryData['status'] ?? $existingSubcategory->active,
                        'category_id' => $subcategoryData['category_id'] ?? $existingSubcategory->category_id,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'SubCategory updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error updating subcategory. - '. $e->getMessage());
        }
    }


    public function destroy($id){
        DB::beginTransaction();

        try {
            $subcategory = SubCategory::findOrFail($id);

            if (File::exists(public_path($subcategory->photo))) {
                File::delete(public_path($subcategory->photo));
            }

            $subcategory->delete();
            subCategory::where('translation_of', $id)->delete();

            DB::commit();
            return redirect()->back()->with('success', 'subCategory deleted successfully.');
        }catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in deleting subcategory: ' . $e->getMessage());
            return redirect()->route('dashboard.subcategories.list')->with('error', 'Error in deleting subcategory.');
        }
    }
}
