<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function list()
    {
        $tags = Tag::all();
        return view('admin.tags.list', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'link' => 'required|string|unique:tags,slug|',
        ],[
            'name.required' => 'name is required',
            'name.string' => 'name must be string',
            'name.max' => 'name must be less than 50 characters',
            'link.required' => 'link is required',
            'link.string' => 'link must be string',
            'link.unique' => 'link must be unique',
        ]);

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = $request->link;
        $tag->save();

        return redirect()->route('dashboard.tags.add')->with('success', 'Tag created successfully');
    }

    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'link' => 'required|string|unique:tags,slug,'.$id,
        ],[
            'name.required' => 'name is required',
            'name.string' => 'name must be string',
            'name.max' => 'name must be less than 50 characters',
            'link.required' => 'link is required',
            'link.string' => 'link must be string',
            'link.unique' => 'link must be unique',
        ]);

        $tag = Tag::find($id);
        $tag->name = $request->name;
        $tag->slug = $request->link;
        $tag->save();

        return redirect()->route('dashboard.tags.list', $id)->with('success', 'Tag updated successfully');
    }
}
