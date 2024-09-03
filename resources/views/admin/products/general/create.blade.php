@extends('layouts.admin')

@section('title')
Add New Product
@endsection

@section('content')

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

<div class="card">
    <div class="card-header bg-dark text-white">
        <h4 class="card-title text-primary">Add New Product</h4>
    </div>

    <form action="{{ route('dashboard.products.general.store') }}" method="POST" enctype="multipart/form-data" class="p-3">
        @csrf
        <div class="form-body">
            <h4 class="form-section text-primary"><i class="ft-info"></i> General Info</h4>
            <div class="row">
                <!-- Product Name -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" id="name" class="form-control" value="{{ old('name') }}" name="name" placeholder="Enter product name">
                        @error("name")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Slug -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" value="{{ old('slug') }}" name="slug" placeholder="Enter product slug">
                        @error("slug")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Description -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter product description">{{ old('description') }}</textarea>
                        @error("description")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Short Description -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="short-description">Short Description</label>
                        <textarea name="short_description" id="short-description" class="form-control" placeholder="Enter short description">{{ old('short_description') }}</textarea>
                        @error("short_description")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categories">Category</label>
                        <div class="categories-container">
                            @if($categories && $categories->count() > 0)
                                @foreach($categories as $category)
                                    @if ($category->translation_lang == Config::get('app.locale'))
                                        <label class="badge" style="background-color: #004085; color: #fff; padding: 10px; border-radius: 20px; margin: 5px;">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" style="margin-right: 5px;"> 
                                            {{ $category->name }}
                                        </label>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        @error('categories')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <div class="tags-container">
                            @if($tags && $tags->count() > 0)
                                @foreach($tags as $tag)
                                    <label class="badge" style="background-color: #004085; color: #fff; padding: 10px; border-radius: 20px; margin: 5px;">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" style="margin-right: 5px;"> 
                                        {{ $tag->name }}
                                    </label>
                                @endforeach
                            @endif
                        </div>
                        @error('tags')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="attrs">Attributes</label>
                        <div class="tags-container">
                            @if($attributes && $attributes->count() > 0)
                                @foreach($attributes as $attr)
                                    <label class="badge" style="background-color: #004085; color: #fff; padding: 10px; border-radius: 20px; margin: 5px;">
                                        <input type="checkbox" name="attrs[]" value="{{ $attr->id }}" style="margin-right: 5px;"> 
                                        {{ $attr->name }}
                                    </label>
                                @endforeach
                            @endif
                        </div>
                        @error('attrs')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Brand Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="brand_id">Brand</label>
                        <select name="brand_id" class="select2 form-control">
                            <option value="" selected>--- Select Brand ---</option>
                                @if($brands && $brands->count() > 0)
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                @endif
                            </optgroup>
                        </select>
                        @error('brand_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            
                <!-- Status Selection -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status">
                            <option value="" selected>--- Select Status ---</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            
            
        </div>

        <!-- Form Buttons -->
        <div class="row">
            <div class="col text-left">
                <button type="submit" class="btn btn-success"><i class="ft-save"></i> Save</button>
            </div>
            <div class="col text-right">
                <a href="{{ route('dashboard.products.list') }}" class="btn btn-danger"><i class="ft-x"></i> Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

