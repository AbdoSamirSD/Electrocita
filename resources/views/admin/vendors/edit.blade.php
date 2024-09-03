@extends('layouts.admin')

@section('title')
Edit Vendor {{$vendor->name}}
@endsection

@section('content')
<form action="{{ route('dashboard.vendors.update', ['id' => $vendor->id]) }}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$vendor->id}}">
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

    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-6">
            <div class="form-group">
                <label for="vend_name">Vendor Name</label>
                <input type="text" value="{{$vendor->name}}" class="form-control" name="vend_name">
                @error('vend_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="vend_email">Vendor Email</label>
                <input type="text" value="{{$vendor->email}}" class="form-control" name="vend_email">
                @error('vend_email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="vend_phone">Vendor Phone</label>
                <input type="text" value="{{$vendor->phone}}" class="form-control" name="vend_phone">
                @error('vend_phone')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="vend_addr">Vendor Address</label>
                <input type="text" value="{{$vendor->address}}" class="form-control" name="vend_addr">
                @error('vend_addr')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" name="category">
                    <option value="">--- Select Category ---</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{ $category->id == $vendor->category_id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status">
                    <option value="">--- Select Status ---</option>
                    <option value="1" {{$vendor->status == 1? 'selected' : ''}}>Active</option>
                    <option value="0" {{$vendor->status == 0? 'selected' : ''}}>Inactive</option>
                </select>
                @error('status')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="img">Vendor Logo</label>
                <input type="file" class="form-control" name="img">
                @error('img')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    
    <div class="row" style="padding-top: 10px; margin-top: 20px;">
        <div class="col">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        <div class="col text-right">
            <a href="{{route('dashboard.vendors.list')}}" class="btn btn-danger">Cancel</a>
        </div>
    </div>

    <div id="logo" class="row justify-content-center" style="margin-top: 50px">
        <label for="">Vendor Logo</label>
        <div class="col-12 text-center">
            <img src="{{$vendor->image}}" class="img-fluid rounded-circle" alt="logo" style="max-height: 400px;">
        </div>
    </div>
</form>

@endsection