@extends('layouts.admin')

@section('title')
Add New Category
@endsection

@section('content')

<form action="{{ route('dashboard.categories.store') }}" enctype="multipart/form-data" method="post">
    @csrf
    @if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px;">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger" style="margin-bottom: 20px;">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="form-group row" style="border-bottom: 1px solid #ccc; margin-bottom: 20px; padding-bottom: 10px;">
        <label for="img" class="col-sm-2 col-form-label">Category Image</label>
        <div class="col-md-6">
            <input type="file" class="form-control" id="img" name="img" value="{{ old('photo') }}">
            @error('img')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row" style="margin-bottom: 20px;">
        @foreach (getActivatedLanguages() as $index=>$activeLang)
        <div class="col-md-6" style="border-right: 1px solid #ccc; padding-right: 10px; border-bottom: 1px solid #ccc; margin-bottom: 20px;">
            <div class="form-group">
                <label for="cat_name">Category Name ({{ $activeLang->name }})</label>
                <input placeholder="ex. Electronics" type="text" class="form-control" id="cat_name" name="category[{{$index}}][cat_name]" value="{{ old('cat_name.'.$activeLang->abbr) }}">
                @error('category.*.cat_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group" hidden>
                <label for="trans_lang">Translation Language ({{$activeLang->abbr}})</label>
                <input value="{{$activeLang->abbr}}" type="text" class="form-control" id="trans_lang_" name="category[{{$index}}][translation_lang]" value="{{ old('trans_lang.'.$activeLang->abbr) }}">
                @error('category.*.translation_lang')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="category[{{$index}}][status]">
                    <option value="">--- Select Status ---</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @error('category.*.status')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        @endforeach
    </div>

    <div class="row" style="border-top: 1px solid #ccc; padding-top: 10px; margin-top: 20px;">
        <div class="col">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        <div class="col text-right">
            <a href="{{route('dashboard.categories.list')}}" class="btn btn-danger">Cancel</a>
        </div>
    </div>
    
</form>


@endsection
