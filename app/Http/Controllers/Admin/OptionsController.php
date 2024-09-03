<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\Attribute;
use App\Models\Product;

class OptionsController extends Controller
{
    //
    public function list(){
        $options = Option::all();
        return view('admin.options.list', compact('options'));
    }

    public function create(){
        $attributes = Attribute::all();
        return view('admin.options.create', compact('attributes'));
    }

    public function store(Request $request){
        $request->validate([
            'option' => 'required|string|max:50|unique:option_translations,name',
            'attribute_id' => 'required|exists:attributes,id',
        ],[
            'option.required' => 'The option field is required',
            'option.string' => 'The option must be a string',
            'option.unique' => 'The option already exists',
            'option.max' => 'The option may not be greater than 50 characters',
            'attribute_id.required' => 'The attribute field is required',
            'attribute_id.exists' => 'The attribute does not exist',
        ]);
        try{
            $option = new Option();
            $option->attribute_id = $request->attribute_id;
            $option->save();
            $option->name = $request->option;
            $option->save();
            return redirect()->route('dashboard.options.add')->with('success', 'Option created successfully');

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'There was an error creating the option');
        }
    }

    public function edit($id){
        $option = Option::find($id);
        $attributes = Attribute::all();
        return view('admin.options.edit', compact('option', 'attributes'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'option' => 'required|string|max:50|unique:option_translations,name,'.$id,
            'attribute_id' => 'required|exists:attributes,id',
        ],[
            'option.required' => 'The option field is required',
            'option.string' => 'The option must be a string',
            'option.unique' => 'The option already exists',
            'option.max' => 'The option may not be greater than 50 characters',
            'attribute_id.required' => 'The attribute field is required',
            'attribute_id.exists' => 'The attribute does not exist',
        ]);
        try{
            $option = Option::find($id);
            if(!$option){
                return redirect()->back()->with('error', 'Option not found');
            }
            $option->attribute_id = $request->attribute_id;
            $option->save();
            $option->name = $request->option;
            $option->save();
            return redirect()->route('dashboard.options.edit', $id)->with('success', 'Option updated successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'There was an error updating the option');
        }
    }

    public function destroy($id){
        try{
            $option = Option::find($id);
            if(!$option){
                return redirect()->back()->with('error', 'Option not found');
            }
            $products = Product::where('option_id', $id)->get();
            if(count($products) > 0){
                return redirect()->back()->with('error', 'The option is associated with a product');
            }
            $option->delete();
            return redirect()->route('dashboard.options.list')->with('success', 'Option deleted successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'There was an error deleting the option');
        }
    }

    
    
}
