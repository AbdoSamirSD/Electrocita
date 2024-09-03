<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\Vendor;
use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VendorCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
class VendorController extends Controller
{
    public function list(){
        $vendors = Vendor::paginate(10);
        return view('admin.vendors.list', compact('vendors'));
    }
    
    public function create(){
        $categories = Category::where('translation_lang', Config::get('app.locale'))->where('active', '1')->get();
        return view('admin.vendors.create', compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            'vend_name' => 'required|max:50|string',
            'vend_email' => 'required|email|unique:vendors,email',
            'vend_phone' => 'required|max:20|unique:vendors,phone',
            'vend_addr' => 'required|string|max:200',
            'category' => 'required|exists:categories,id',
            'status' => 'required|in:0,1',
            'img' =>'required|image|mimes:jpg,jpeg,png,svg,heic'
        ],[
            'vend_name.required' => 'Vendor name is required',
            'vend_name.max' => 'Vendor name should not be more than 50 characters',
            'vend_name.string' => 'Vendor name should be a string',
            'vend_email.required' => 'Vendor email is required',
            'vend_email.email' => 'Vendor email should be a valid email',
            'vend_email.unique' => 'Vendor email already exists',
            'vend_phone.required' => 'Vendor phone is required',
            'vend_phone.max' => 'Vendor phone should not be more than 20 characters',
            'vend_phone.unique' => 'Vendor phone already exists',
            'vend_addr.required' => 'Vendor address is required',
            'vend_addr.string' => 'Vendor address should be a string',
            'vend_addr.max' => 'Vendor address should not be more than 200 characters',
            'category.required' => 'Category is required',
            'category.exists' => 'Category does not exist',
            'status.required' => 'Status is required',
            'status.in' => 'This status value does not correct',
            'img.required_without' => 'Image is required',
            'img.image' => 'Image should be an image',
            'img.mimes' => 'Image should be in jpg, jpeg, png, svg, heic format'
        ]);
        try{
            DB::beginTransaction();
            $vendor = new Vendor();
            if($request->hasFile('img')){
                $file = $request->file('img');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $path = '/uploads/vendors/';
                if (!File::exists(public_path($path))) {
                    File::makeDirectory(public_path($path), 0755, true);
                }
                $file->move(public_path($path), $filename);
                $vendor->name = $request->vend_name;
                $vendor->email = $request->vend_email;
                $vendor->phone = $request->vend_phone;
                $vendor->address = $request->vend_addr;
                $vendor->category_id = $request->category;
                $vendor->status = $request->status;
                $vendor->image = $path.$filename;
                Notification::send($vendor,  new VendorCreated($vendor));
                $vendor->save();
                DB::commit();
                return redirect()->route('dashboard.vendors.add')->with('success', 'Vendor created successfully');
                
            }else{
                DB::rollback();
                return redirect()->route('dashboard.vendors.add')->with('error', 'Failed to upload vendor image. Please try again.');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Error while creating vendor');
        }        
    }

    public function edit($id){
        $vendor = Vendor::find($id);
        $categories = Category::where('translation_lang', Config::get('app.locale'))->where('active', '1')->get();
        if(!$vendor){
            return redirect()->route('dashboard.vendors.list')->with('error', 'Vendor not found');
        }
        return view('admin.vendors.edit', compact(['vendor', 'categories']));
    }

    public function update($id, Request $request){
        $request->validate([
            'vend_name' => 'required_without:id|string|max:50',
            'vend_email' => 'required_without:id|email|unique:vendors,email,'.$id,
            'vend_phone' => 'required_without:id|max:20',
            'vend_addr' => 'required_without:id|string|max:200',
            'category' => 'required_without:id|integer|exists:categories,id',
            'status' => 'required_without:id|integer|in:0,1',
            'img' => 'image|mimes:jpeg,png,jpg,heic,svg',
        ],[
            'vend_name.required_without' => 'Vendor name is required',
            'vend_name.string' =>' vendor name must be string',
            'vend_name.max' =>'Vendor name must be less than 50 characters',
            'vend_email.required_without' => 'Vendor email is required',
            'vend_email.email' =>'Vendor email must be valid email',
            'vend_email.unique' =>'Vendor email already exists',
            'vend_phone.required_without' => 'Vendor phone is required',
            'vend_phone.max' =>'Vendor phone must be less than 20 characters',
            'vend_addr.required_without' => 'Vendor address is required',
            'vend_addr.string' =>'Vendor address must be string',
            'vend_addr.max' =>'Vendor address must be less than 200 characters',
            'category.required_without' => 'Category is required',
            'category.integer' =>'Category must be integer',
            'category.exists' =>'Category does not exist',
            'status.required_without' => 'Status is required',
            'status.integer' =>'Status must be integer',
            'status.in' =>'Status must be either 0 or 1',
            'img.image' =>'Vendor image must be image',
            'img.mimes' =>'Vendor image must be in jpeg, png, jpg, heic, svg format',
        ]);
        try{
            DB::beginTransaction();
            $vendor = Vendor::find($id);
            if(!$vendor){
                return redirect()->back()->with('error', 'Vendor not found');
            }
            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $img_name = time() . '.' . $img->getClientOriginalExtension();
                $path = 'uploads/vendors/';
                $fullPath = public_path($path);
    
                $old_img = $vendor->image;
            
                if (File::exists(public_path($old_img))) {
                    File::delete(public_path($old_img));
                }
    
                $img->move($fullPath, $img_name);
                $vendor->image = $path . $img_name;
                $vendor->save();
            }
            $vendor->name = $request->input('vend_name');
            $vendor->email = $request->input('vend_email');
            $vendor->phone = $request->input('vend_phone');
            $vendor->address = $request->input('vend_addr');
            $vendor->category_id = $request->input('category');
            $vendor->status = $request->input('status');
            $vendor->save();
            DB::commit();
            return redirect()->route('dashboard.vendors.list')->with('success','Vendor updated successfully');
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update vendor');
        }
    }

    public function destroy($id){
        try {
            $vendor = Vendor::find($id);
            
            if (!$vendor) {
                return redirect()->back()->with('error', 'Vendor not found');
            }
            
            $old_img = $vendor->image;
            
            if (File::exists(public_path($old_img))) {
                File::delete(public_path($old_img));
            }
            
            $vendor->delete();
            return redirect()->route('dashboard.vendors.list')->with('success', 'Vendor deleted successfully');
        } catch (Exception $e) {
            Log::error('Failed to delete vendor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete vendor: ' . $e->getMessage());
        }
    }
}
