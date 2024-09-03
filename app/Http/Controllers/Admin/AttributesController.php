<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributesController extends Controller
{
    public function list(){
        $attributes = Attribute::get();
        return view('admin.attributes.list', compact('attributes'));
    }

    public function create(){
        return view('admin.attributes.create');
    }

    public function store(Request $request){
        $request->validate([
            'attr' => 'required|string|max:80|unique:attribute_translations,name',
        ],[
            'attr.required' => 'Attribute name is required',
            'attr.string' => 'Attribute name must be a string',
            'attr.max' => 'Attribute name must not be more than 80 characters',
            'attr.unique' => 'Attribute name already exists',
        ]);
        try{
            $attribute = new Attribute();
            $attribute->name = $request->attr;
            $attribute->save();

            return redirect()->route('dashboard.attributes.add')->with('success', 'Attribute created successfully');
        }catch(\Exception $e){
            return redirect()->route('dashboard.attributes.add')->with('error', 'An error occurred. Please try again later');
        }
    }

    public function edit($id){
        $attribute = Attribute::find($id);
        if(!$attribute){
            return redirect()->route('dashboard.attributes.list')->with('error', 'Attribute not found');
        }
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'attr' => 'required|string|max:80|unique:attribute_translations,name,'.$id,
        ],[
            'attr.required' => 'Attribute name is required',
            'attr.string' => 'Attribute name must be a string',
            'attr.max' => 'Attribute name must not be more than 80 characters',
            'attr.unique' => 'Attribute name already exists',
        ]);
        try{
            $attribute = Attribute::find($id);
            $attribute->name = $request->attr;
            $attribute->save();

            return redirect()->route('dashboard.attributes.list', $id)->with('success', 'Attribute updated successfully');
        }catch(\Exception $e){
            return redirect()->route('dashboard.attributes.edit', $id)->with('error', 'An error occurred. Please try again later');
        }
    }

    public function destroy($id){
        $attribute = Attribute::find($id);
        if(!$attribute){
            return redirect()->route('dashboard.attributes.list')->with('error', 'Attribute not found');
        }
        $attribute->delete();
        return redirect()->route('dashboard.attributes.list')->with('success', 'Attribute deleted successfully');
    }


    public function getValues($id){
        $attribute = Attribute::find($id);
        if(!$attribute){
            return redirect()->route('dashboard.attributes.list')->with('error', 'Attribute not found');
        }
        return view('admin.attributes.values', compact('attribute'));
    }

    

}
