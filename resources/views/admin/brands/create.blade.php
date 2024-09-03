@extends('layouts.admin')

@section('title')
Add New Brand
@endsection

@section('content')

<form action="{{ route('dashboard.brands.store') }}" enctype="multipart/form-data" method="post">
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
        <label for="img" class="col-sm-2 col-form-label">Brand Logo</label>
        <div class="col-md-6">
            <input type="file" class="form-control @error('img') is-invalid @enderror" name="img" id="img" value="{{old('img')}}">
            @error('img')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name" class="col-form-label font-weight-bold">Brand Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       name="name" id="name" value="{{ old('name') }}" 
                       placeholder="e.g., Apple">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="form-group">
                <label for="status" class="col-form-label font-weight-bold">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" 
                        name="status" id="status">
                    <option value="">--- Select Status ---</option>
                    <option value="1" >Active</option>
                    <option value="0" >Inactive</option>
                </select>
                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col text-left">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        <div class="col text-right">
            <a href="{{route('dashboard.brands.list')}}" class="btn btn-danger">Cancel</a>
        </div>
    </div>
</form>


@endsection
