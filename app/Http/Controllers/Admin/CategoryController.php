<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function list(){
        $default_lang = Config::get('app.locale');
        $categories = Category::where('translation_lang', $default_lang)->get();
        return view('admin.categories.list', compact('categories'));
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function store(Request $request){
        $request->validate([
            'category' => 'required|array|min:1',
            'category.*' => 'required|array|min:1',
            'category.*.cat_name' => 'required|string|max:20|distinct',
            'category.*.translation_lang' => 'required|max:10|string|distinct',
            'img' => 'required|image|mimes:jpeg,png,jpg,svg,heic',
            'category.*.status' => 'required|in:0,1',
        ],[
            'category.array' => 'Error in inserted data',
            'category.min' => 'You should insert at least 1 language',
            'category.*.cat_name.required' => 'The category name is required',
            'category.*.cat_name.string' => 'The category name must contain only letters',
            'category.*.cat_name.max' => 'The category name must be at most 20 characters long',
            'category.*.cat_name.distinct' => 'Each category name must be unique',
            'category.*.translation_lang.required' => 'The translation language is required',
            'category.*.translation_lang.max' => 'The translation language must be at most 10 characters long',
            'category.*.translation_lang.string' => 'The translation language must contain only letters',
            'category.*.translation_lang.distinct' => 'Each translation language must be unique',
            'img.required' => 'The category image is required',
            'img.image' => 'The uploaded file must be an image.',
            'img.mimes' => 'Allowed image types are jpg, png, heic, svg, jpeg, and gif',
            'category.*.status.required' => 'The status field is required',
            'category.*.status.in' => 'The status must be either active or inactive'
        ]);
        
        try{
            $cat = collect($request->category);
            $filter = $cat->filter(function($value) {
                return $value['translation_lang'] == Config::get('app.locale');
            });
        
            $default_cat_lang = $filter->first();
        
            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = 'uploads/categories';
                
                if (!File::exists(public_path($path))) {
                    File::makeDirectory(public_path($path), 0755, true);
                }
        
                $image->move(public_path($path), $imageName);
        
                $default_cat_id = Category::create([
                    'name' => $default_cat_lang['cat_name'],
                    'translation_lang' => Config::get('app.locale'),
                    'translation_of' => 0,
                    'active' => $default_cat_lang['status'],
                    'photo' => $path . '/' . $imageName
                ])->id;
        
                $cat_arr = [];
                foreach ($cat as $value) {
                    if ($value['translation_lang'] != Config::get('app.locale')) {
                        $cat_arr[] = [
                            'name' => $value['cat_name'],
                            'translation_lang' => $value['translation_lang'],
                            'translation_of' => $default_cat_id,
                            'active' => $value['status'],
                            'photo' => $path . '/' . $imageName,
                        ];
                    }
                }
        
                if (!empty($cat_arr)) {
                    Category::insert($cat_arr);
                }
        
                return redirect()->route('dashboard.categories.add')->with('success', 'Categories created successfully.');
            }else{
                return redirect()->route('dashboard.categories.add')->with('error', 'Failed to upload category image. Please try again.');
            }
        }catch(Exception $e){
            return redirect()->route('dashboard.categories.add')->with('error', 'error on creating category: ' . $e->getMessage());
        }
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        $langsrel = Language::where('abbr', '!=', 'en')->get();

        $langsArray = [];
        foreach ($langsrel as $lang) {
            $langsArray[] = $lang->abbr;
        }

        $categoriesrel = Category::whereIn('translation_lang', $langsArray)->get();
        // return [$category, $langsrel, $categoriesrel];
        return view('admin.categories.edit', compact('category', 'langsrel', 'categoriesrel'));
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'category.*.cat_name' => 'required_without:id|string|max:20|distinct',
            'category.*.translation_lang' => 'required_without:id|max:10|string|distinct',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,svg,heic',
            'category.*.status' => 'required_without:id|in:0,1',
        ],[
            'category.*.cat_name.required_without:id' => 'Category name is required.',
            'category.*.cat_name.string' => 'Category name must be string',
            'category.*.cat_name.max' => 'Category name should not be more than 20 characters.',
            'category.*.cat_name.distinct' => 'Category name should be unique.',
            'category.*.translation_lang.required_without:id' => 'Translation language is required.',
            'category.*.translation_lang.max' => 'Translation language should not be more than 10 characters.',
            'category.*.translation_lang.string' => 'Translation language must be string',
            'category.*.translation_lang.distinct' => 'Translation language should be unique.',
            'img.image' => 'Invalid image format.',
            'img.mimes' => 'Invalid image format.',
            'category.*.status.required_without:id' => 'Status is required.',
            'category.*.status.in' => 'Invalid status.',
        ]);
        try {
            $category = Category::findOrFail($id);

            if($request->hasFile('img')) {
                $image = $request->file('img');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $path = 'uploads/categories';

                if(File::exists(public_path('/'.$category->photo))){
                    File::delete(public_path('/'.$category->photo));
                }

                $image->move(public_path($path), $filename);
                $category->photo = $path.'/'.$filename;
            }

            $category->update([
                'name' => $request->input('category')[$id]['cat_name'],
                'active' => $request->input('category')[$id]['status'],
            ]);

            foreach ($request->input('category') as $catId => $catData) {
                if ($catId != $id) {
                    Category::updateOrCreate(
                        ['translation_lang' => $catData['translation_lang'], 'parent_id' => $id],
                        ['name' => $catData['cat_name'], 'active' => $catData['status']]
                    );
                }
            }

            return redirect()->back()->with('success', 'Category updated successfully.');
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Error updating category.');
        }
    }


    public function destroy($id){
        DB::beginTransaction();
        
        try {
            $category = Category::findOrFail($id);

            if ($category->vendors()->count() > 0) {
                return redirect()->route('dashboard.categories.list')->with('error', 'Category has vendors, cannot be deleted.');
            }

            if (File::exists(public_path($category->photo))) {
                File::delete(public_path($category->photo));
            }

            $category->delete();
            Category::where('translation_of', $id)->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Category deleted successfully.');
        }catch (Exception $e){
            DB::rollBack();
            Log::error('Error in deleting category: ' . $e->getMessage());
            return redirect()->route('dashboard.categories.list')->with('error', 'Error in deleting category.');
        }
    }
}


