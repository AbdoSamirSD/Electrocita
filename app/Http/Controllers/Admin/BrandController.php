<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function list(){
        $brands = Brand::with('translations')->get();
        return view('admin.brands.list', compact('brands'));
    }

    public function create(){
        return view('admin.brands.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=> 'required|string|max:50',
            'img'=> 'required|image|mimes:jpeg,png,jpg,heic,svg',
            'status'=> 'required|in:0,1',
        ],[
            'name.required'=> 'Name is required',
            'name.string'=> 'Name must be string',
            'name.max'=> 'Name must not be greater than 50 characters',
            'img.required'=> 'Image is required',
            'img.image'=> 'Image must be image',
            'img.mimes'=> 'Image must be jpeg,png,jpg,heic,svg',
            'status.required'=> 'Status is required',
            'status.in'=> 'This status is invalid',
        ]);

        try{
            $brand = new Brand();
            if($request->hasFile('img')){
                $image = $request->file('img');
                $name = time().'.'.$image->getClientOriginalExtension();
                if (!file_exists(public_path('/uploads/brands'))) {
                    mkdir(public_path('/uploads/brands'), 0755, true);
                }
                $destinationPath = '/uploads/brands';
                $image->move(public_path($destinationPath), $name);
                $brand->photo = $destinationPath.'/'.$name;
                $brand->is_active = $request->status;
                $brand->save();
            }
            else{
                return redirect()->route('dashboard.brands.create')->with('error', 'error in uploading image. please try again later');
            }

            $brandTranslation = new BrandTranslation();
            $brandTranslation->name = $request->name;
            $brandTranslation->locale = 'en';
            $brandTranslation->brand_id = $brand->id;
            $brandTranslation->save();
            return redirect()->route('dashboard.brands.list')->with('success', 'Brand added successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'There is an error. '.$e->getMessage());
        }
    }

    public function edit($id){
        $brand = Brand::with('translations')->find($id);
        $name = $brand->translations->where('brand_id', $id)->first()->name;
        return view('admin.brands.edit', compact('brand', 'name'));
    }

    public function update($id, Request $request){
        $request->validate([
            'name'=> 'required|string|max:50',
            'img'=> 'required_without:id|image|mimes:jpeg,png,jpg,heic,svg',
            'status'=> 'required|in:0,1',
        ],[
            'name.required'=> 'Name is required',
            'name.string'=> 'Name must be string',
            'name.max'=> 'Name must not be greater than 50 characters',
            'img.required_without:id'=> 'Image is required',
            'img.image'=> 'Image must be image',
            'img.mimes'=> 'Image must be jpeg,png,jpg,heic,svg',
            'status.required'=> 'Status is required',
            'status.in'=> 'This status is invalid',
        ]);

        try{
            $brand = Brand::findOrFail($id);
            if($request->hasFile('img')){
                if (File::exists(public_path($brand->photo))) {
                    File::delete(public_path($brand->photo));
                }
                $image = $request->file('img');
                $name = time().'.'.$image->getClientOriginalExtension();
                if (!file_exists(public_path('/uploads/brands'))) {
                    mkdir(public_path('/uploads/brands'), 0755, true);
                }
                $destinationPath = '/uploads/brands';
                $image->move(public_path($destinationPath), $name);
                $brand->photo = $destinationPath.'/'.$name;
                $brand->is_active = $request->status;
                $brand->save();
            }
            else{
                $brand->is_active = $request->status;
                $brand->save();
            }

            $brandTranslation = BrandTranslation::where('brand_id', $id)->where('locale', 'en')->first();
            $brandTranslation->name = $request->name;
            $brandTranslation->save();
            return redirect()->route('dashboard.brands.list')->with('success', 'Brand updated successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'There is an error. '.$e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $brand = Brand::findOrFail($id);

            if (File::exists(public_path($brand->photo))) {
                File::delete(public_path($brand->photo));
            }     
            $brand->delete();
            return redirect()->back()->with('success', 'Brand deleted successfully.');
        }catch (\Exception $e) {
            return redirect()->route('dashboard.brands.list')->with('error', 'Error in deleting Brand: '.$e->getMessage());
        }
    }
}