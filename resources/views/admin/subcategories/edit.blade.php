@extends('layouts.admin')

@section('title')
Edit {{$subcategory->name}} subcategory
@endsection

@section('content')

<div class="container mt-5">
    <form action="{{ route('dashboard.subcategories.update', $subcategory->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        
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
        
        <input type="hidden" name="id" value="{{ $subcategory->id }}">
        <div class="row">
            <div class="col-md-4 form-section" style="border:3px solid black;">
                <img src="/{{$subcategory->photo}}" alt="subcategory Image" class="img-fluid img-thumbnail">
                <div class="form-group mt-2">
                    <label for="img">Subcategory Image</label>
                    <input type="file" class="form-control-file" id="img" name="img">
                    @error('img')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-8 form-section" style="border:3px solid black;">
                <div class="form-group">
                    <label for="subcat_name">Subcategory Name</label>
                    <input value="{{ old('subcategory.'.$subcategory->id.'.subcat_name', $subcategory->name) }}" type="text" class="form-control" id="subcat_name" name="subcategory[{{$subcategory->id}}][subcat_name]">
                    @error("subcategory.{$subcategory->id}.subcat_name")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="subcat_description">Subcategory Description</label>
                    <input value="{{ old('subcategory.'.$subcategory->id.'.subcat_description', $subcategory->description) }}" type="text" class="form-control" id="subcat_description" name="subcategory[{{$subcategory->id}}][subcat_description]">
                    @error("subcategory.{$subcategory->id}.subcat_description")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="subcategory[{{ $subcategory->id }}][category_id]">
                        <option value="">--- Select Category ---</option>
                        @foreach ($categories as $category)
                            @if ($category->translation_lang == $subcategory->translation_lang)
                                <option value="{{ $category->id }}" 
                                    {{ old('subcategory.'.$subcategory->id.'.category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('subcategory.'.$subcategory->id.'.category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <input type="hidden" name="subcategory[{{$subcategory->id}}][translation_lang]" value="{{ $subcategory->translation_lang }}">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="subcategory[{{ $subcategory->id }}][status]">
                        <option value="">--- Select Status ---</option>
                        <option value="1" {{ old('subcategory.'.$subcategory->id.'.status', $subcategory->active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('subcategory.'.$subcategory->id.'.status', $subcategory->active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error("subcategory.{$subcategory->id}.status")
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary btn-custom">Save Changes</button>
                    <a href="{{ route('dashboard.subcategories.list') }}" class="btn btn-danger btn-custom">Cancel</a>
                </div>
            </div>
        </div>
    </form>

    <div class="mt-5">
        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            @foreach ($subcategory->subcategoriesrel as $index => $trans_of)
                <li class="nav-item">
                    <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="pills-{{ $trans_of->translation_lang }}-tab" data-toggle="pill" href="#pills-{{ $trans_of->translation_lang }}" role="tab" aria-controls="pills-{{ $trans_of->translation_lang }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                        {{ $trans_of->translation_lang }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="pills-tabContent">
            @foreach ($subcategory->subcategoriesrel as $index => $trans_of)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="pills-{{ $trans_of->translation_lang }}" role="tabpanel" aria-labelledby="pills-{{ $trans_of->translation_lang }}-tab">
                    <form action="{{ route('dashboard.subcategories.update', $trans_of->id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $trans_of->id }}">
                        <div class="form-group">
                            <label for="subcat_name_{{ $trans_of->id }}">Subcategory Name</label>
                            <input value="{{ $trans_of->name }}" type="text" class="form-control" id="subcat_name_{{ $trans_of->id }}" name="subcategory[{{ $trans_of->id }}][subcat_name]">
                            @error('subcategory.'.$trans_of->id.'.subcat_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subcat_description_{{ $trans_of->id }}">Subcategory Description</label>
                            <input value="{{ $trans_of->description }}" type="text" class="form-control" id="subcat_description_{{ $trans_of->id }}" name="subcategory[{{ $trans_of->id }}][subcat_description]">
                            @error('subcategory.'.$trans_of->id.'.subcat_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id_{{ $trans_of->id }}">Category</label>
                            <select class="form-control" id="category_id_{{ $trans_of->id }}" name="subcategory[{{ $trans_of->id }}][category_id]">
                                <option value="">--- Select Category ---</option>
                                @foreach ($categories as $category)
                                    @if ($category->translation_lang == $trans_of->translation_lang)
                                        <option value="{{ $category->id }}" {{ old('subcategory.'.$trans_of->id.'.category_id', $trans_of->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('subcategory.'.$trans_of->id.'.category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <input type="hidden" name="subcategory[{{ $trans_of->id }}][translation_lang]" value="{{ $trans_of->translation_lang }}">
                        <div class="form-group">
                            <label for="status_{{ $trans_of->id }}">Status</label>
                            <select class="form-control" id="status_{{ $trans_of->id }}" name="subcategory[{{ $trans_of->id }}][status]">
                                <option value="">--- Select Status ---</option>
                                <option value="1" {{ old('subcategory.'.$trans_of->id.'.status', $trans_of->active) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('subcategory.'.$trans_of->id.'.status', $trans_of->active) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error("subcategory.{$trans_of->id}.status")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary btn-custom">Save Changes</button>
                            <a href="{{ route('dashboard.subcategories.list') }}" class="btn btn-danger btn-custom">Cancel</a>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
