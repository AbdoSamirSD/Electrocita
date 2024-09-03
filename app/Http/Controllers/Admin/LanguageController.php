<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Exception;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function list(){
        $languages = Language::paginate(10);
        return view('admin.languages.list', compact('languages'));
    }

    public function create(){
        return view('admin.languages.create');
    }

    public function store(Request $request){
        $request->validate([
            'abbr' => ['required', 'max:10','alpha', 'unique:languages,abbr'],
            'name' => ['required', 'alpha', 'max:20', 'unique:languages,name'],
            'locale' => ['required', 'max:20', 'unique:languages,locale'],
            'direction' => ['required', 'in:rtl,ltr'],
            'status' => 'required|in:0,1',
            'native'=> 'max:20|unique:languages,native'
        ],[
            'abbr.required' => 'The abbreviation field is required',
            'abbr.max' => 'The abbreviation must be a maximum of 10 characters',
            'abbr.unique' => 'The abbreviation has already been taken',
            'name.required' => 'The name field is required',
            'name.max' => 'The name must be a maximum of 20 characters',
            'locale.required' => 'The locale field is required',
            'locale.max' => 'The locale must be a maximum of 20 characters',
            'locale.unique' => 'The locale has already been taken',
            'direction.required' => 'The direction field is required',
            'status.required' => 'The status field is required',
            'status.in' => 'values entered are not correct',
            'direction.in' => 'values entered are not correct',
            'name.alpha' => 'The name field must contain only alphabetical characters',
            'abbr.alpha' => 'The abbreviation field must contain only alphabetical characters',
            'native.max' => 'The native name must be a maximum of 20 characters',
            'native.unique' => 'The native name has already been taken',
            
        ]);
        try{
            $lang = new Language();
            $lang->abbr = $request->input('abbr');
            $lang->name = $request->input('name');
            $lang->native = $request->input('native');
            $lang->locale = $request->input('locale');
            $lang->direction = $request->input('direction');
            $lang->active = $request->input('status');
            $saved = $lang->save();
            if($saved){
                return redirect()->route('dashboard.languages.add')->with('success', 'Language added successfully');
            }
            return redirect()->route('dashboard.languages.add')->with('error', 'Failed to add language');
        }
        catch(Exception $e){
            return redirect()->route('dashboard.languages.add')->with('error', $e);
        }
    }

    public function edit($id){
        $language = Language::find($id);
        if(!$language){
            return redirect()->route('dashboard.languages.list')->with('error', 'Language not found');
        }
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'abbr' => ['required','max:10','alpha', 'unique:languages,abbr,'.$id],
            'name' => ['required', 'alpha', 'max:20'],
            'locale' => ['required','max:20', 'unique:languages,locale,'.$id],
            'direction' => ['required', 'in:rtl,ltr'],
            'status' => 'required|in:0,1',
            'native'=> 'max:20|unique:languages,native,'.$id
        ],[
            'abbr.required' => 'The abbreviation field is required',
            'abbr.max' => 'The abbreviation must be a maximum of 10 characters',
            'abbr.unique' => 'The abbreviation has already been taken',
            'name.required' => 'The name field is required',
            'name.max' => 'The name must be a maximum  of 20 characters',
            'locale.required' => 'The locale field is required',
            'locale.max' => 'The locale must be a maximum of 20 characters',
            'locale.unique' => 'The locale has already been taken',
            'direction.required' => 'The direction field is required',
            'status.required' => 'The status field is required',
            'status.in' => 'values entered are not correct',
            'direction.in' => 'values entered are not correct',
            'name.alpha' => 'The name field must contain only alphabetical characters',
            'abbr.alpha' => 'The abbreviation field must contain only alphabetical characters',
            'native.max' => 'The native name must be a maximum of 20 characters',
            'native.unique' => 'The native name has already been taken',
        ]);

        try{
            $language = Language::find($id);
            if(!$language){
                return redirect()->route('dashboard.languages.edit')->with('error', 'Language not found');
            }

            $updated = $language->update([
                'abbr' => $request->input('abbr'),
                'name' => $request->input('name'),
                'native' => $request->input('native'),
                'locale' => $request->input('locale'),
                'direction' => $request->input('direction'),
                'active' => $request->input('status'),
            ]);

            if($updated){
                return redirect()->route('dashboard.languages.list')->with('success', 'Language updated successfully');
            }

            return redirect()->route('dashboard.languages.edit', $id)->with('error', 'Failed to update language');
            
        }
        catch(Exception $e){
            return redirect()->route('dashboard.languages.edit', $id)->with('error', $e);
        }
    }

    public function destroy($id){
        $language = Language::find($id);
        if(!$language){
            return redirect()->route('dashboard.languages.list')->with('error', 'Language not found');
        }

        try{
            $deleted = $language->delete();
            if($deleted){
                return redirect()->route('dashboard.languages.list')->with('success', 'Language deleted successfully');
            }
            return redirect()->route('dashboard.languages.list')->with('error', 'Failed to delete language');
        }
        catch(Exception $e){
            return redirect()->route('dashboard.languages.list')->with('error', $e);
        }
    }
}
