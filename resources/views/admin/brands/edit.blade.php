@extends('layouts.admin')

@section('title')
Edit {{$name}} Brand
@endsection


@section('content')

<div class="container mt-5">
    <div class="container mt-5">
        <form action="{{ route('dashboard.brands.update', $brand->id) }}" enctype="multipart/form-data" method="post">
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
            
            <input type="hidden" name="id" value="{{ $brand->id }}">
            <div class="row">
                <div class="col-md-4 form-section" style="border:3px solid black;">
                    <img src="{{$brand->photo}}" alt="Brand Image" class="img-fluid img-thumbnail">
                    <div class="form-group mt-2">
                        <label for="img">Brand Image</label>
                        <input type="file" class="form-control-file" id="img" name="img">
                        @error('img')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8 form-section" style="border:3px solid black;">
                    <div class="form-group">
                        <label for="name" class="col-form-label font-weight-bold">Brand Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" id="name" value="{{$name}}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="status" class="col-form-label font-weight-bold">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" 
                                name="status" id="status">
                            <option value="">--- Select Status ---</option>
                            <option value="1" {{$brand->is_active == 1? 'selected' : ''}}>Active</option>
                            <option value="0" {{$brand->is_active == 0? 'selected' : ''}}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
    
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-primary btn-custom">Save Changes</button>
                        <a href="{{ route('dashboard.brands.list') }}" class="btn btn-danger btn-custom">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
{{-- <a class="nav-item nav-link disabled" href="#">Disabled</a> --}}
