@extends('layouts.admin')

@section('title')
Add New SubCategory
@endsection

@section('content')

<form action="{{ route('dashboard.subcategories.store') }}" enctype="multipart/form-data" method="post">
    @csrf

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="form-group row" style="border-bottom: 1px solid #ddd; margin-bottom: 20px; padding-bottom: 10px;">
        <label for="img" class="col-sm-2 col-form-label">SubCategory Image</label>
        <div class="col-md-6">
            <input type="file" class="form-control @error('img') is-invalid @enderror" name="img" id="img" value="{{old('img')}}">
            @error('img')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row">
        @foreach ($languages as $index => $lang)
        <div class="col-md-6 mb-4" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
            <h5 class="text-muted">Language: {{ $lang->translation_lang }}</h5>
    
            <div class="form-group">
                <label for="subcat_name_{{ $index }}">SubCategory Name</label>
                <input type="text" class="form-control" id="subcat_name_{{ $index }}" name="subcategory[{{ $index }}][subcat_name]" value="{{ old('subcategory.'.$index.'.subcat_name') }}" placeholder="e.g., Electronics">
                @error('subcategory.'.$index.'.subcat_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="subcat_description_{{ $index }}">SubCategory Description</label>
                <textarea class="form-control" id="subcat_description_{{ $index }}" name="subcategory[{{ $index }}][subcat_description]" rows="4">{{ old('subcategory.'.$index.'.subcat_description') }}</textarea>
                @error('subcategory.'.$index.'.subcat_description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
    
            <!-- Category Selection -->
            <div class="form-group">
                <label for="category_id_{{ $index }}">Category</label>
                <select class="form-control" id="category_id_{{ $index }}" name="subcategory[{{ $index }}][category_id]">
                    <option value="">--- Select Category ---</option>
                    @foreach ($categories as $category)
                        @if ($category->translation_lang == $lang->translation_lang)
                            <option value="{{ $category->id }}" {{ old('subcategory.'.$index.'.category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('subcategory.'.$index.'.category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
    
            <!-- Hidden Field for Translation Language -->
            <input type="hidden" id="trans_lang_{{ $index }}" name="subcategory[{{ $index }}][translation_lang]" value="{{ $lang->translation_lang }}">
    
            <!-- Status Selection -->
            <div class="form-group">
                <label for="status_{{ $index }}">Status</label>
                <select class="form-control" id="status_{{ $index }}" name="subcategory[{{ $index }}][status]">
                    <option value="">--- Select Status ---</option>
                    <option value="1" {{ old('subcategory.'.$index.'.status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('subcategory.'.$index.'.status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('subcategory.'.$index.'.status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="row mt-4">
        <div class="col text-left">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        <div class="col text-right">
            <a href="{{route('dashboard.subcategories.list')}}" class="btn btn-danger">Cancel</a>
        </div>
    </div>
</form>

@endsection
