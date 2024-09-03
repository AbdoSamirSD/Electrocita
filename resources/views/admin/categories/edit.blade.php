@extends('layouts.admin')

@section('title')
Edit {{$category->name}} Category
@endsection


@php
    $language = getActivatedLanguages()->where('abbr', $category->translation_lang)->first();
@endphp


@section('content')

<div class="container mt-5">
    <form action="{{ route('dashboard.categories.update', $category->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $category->id }}">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4 form-section" style="border:3px solid black; padding: 15px;">
                <img src="{{ asset('/' . $category->photo) }}" alt="Category Image" class="img-fluid img-thumbnail">
                <div class="form-group mt-2">
                    <label for="img">Category Image</label>
                    <input type="file" class="form-control-file" id="img" name="img">
                    @error('img')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>            
            <div class="col-md-8 form-section" style="border:3px solid black; padding: 15px;">
                <div class="form-group">
                    <label for="cat_name" class="text-white">Category Name ({{ $category->translation_lang }})</label>
                    <input value="{{ old('category.'.$category->id.'.cat_name', $category->name) }}" type="text" class="form-control" id="cat_name" name="category[{{$category->id}}][cat_name]">
                    @error("category.$category->id.cat_name")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="text-white">Status</label>
                    <select class="form-control" id="status" name="category[{{ $category->id }}][status]">
                        <option value="">--- Select Status ---</option>
                        <option value="1" {{ old('category.'.$category->id.'.status', $category->active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('category.'.$category->id.'.status', $category->active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error("category.{$category->id}.status")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('dashboard.categories.list') }}" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
    </form>

    <div class="mt-5">
        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            @foreach ($category->categoriesrel as $index => $trans_of)
                <li class="nav-item">
                    <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="pills-{{ $trans_of->translation_lang }}-tab" data-toggle="pill" href="#pills-{{ $trans_of->translation_lang }}" role="tab" aria-controls="pills-{{ $trans_of->translation_lang }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                        {{ $trans_of->translation_lang }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="pills-tabContent">
            @foreach ($category->categoriesrel as $index => $trans_of)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="pills-{{ $trans_of->translation_lang }}" role="tabpanel" aria-labelledby="pills-{{ $trans_of->translation_lang }}-tab">
                    <form action="{{ route('dashboard.categories.update', $trans_of->id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $trans_of->id }}">
                        <div class="form-group">
                            <label for="cat_name_{{ $trans_of->id }}" class="text-white">Category Name</label>
                            <input value="{{ old('category.'.$trans_of->id.'.cat_name', $trans_of->name) }}" type="text" class="form-control" id="cat_name_{{ $trans_of->id }}" name="category[{{ $trans_of->id }}][cat_name]">
                            @error('category.'.$trans_of->id.'.cat_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status_{{ $trans_of->id }}" class="text-white">Status</label>
                            <select class="form-control" id="status_{{ $trans_of->id }}" name="category[{{ $trans_of->id }}][status]">
                                <option value="">--- Select Status ---</option>
                                <option value="1" {{ old('category.'.$trans_of->id.'.status', $trans_of->active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('category.'.$trans_of->id.'.status', $trans_of->active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('category.'.$trans_of->id.'.status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('dashboard.categories.list') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
{{-- <a class="nav-item nav-link disabled" href="#">Disabled</a> --}}
