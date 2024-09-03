@extends('layouts.admin')

@section('title')
Edit Attribute {{$attribute->name}}
@endsection

@section('content')
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="card-title text-primary">Edit Attribute</h4>
            </div>
        
            <form action="{{ route('dashboard.attributes.update', ['id'=>$attribute->id]) }}" method="POST" enctype="multipart/form-data" class="p-3">
                @csrf
                <div class="form-body">
                    <h4 class="form-section text-primary"><i class="ft-info"></i>Edit Attribute {{$attribute->name}}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="attr">Attribute Name</label>
                                <input type="text" id="attr" class="form-control" value="{{ $attribute->name }}" name="attr">
                                @error("attr")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col text-left">
                        <button type="submit" class="btn btn-success"><i class="ft-save"></i> Save</button>
                    </div>
                    <div class="col text-right">
                        <a href="{{ route('dashboard.attributes.list') }}" class="btn btn-danger"><i class="ft-x"></i> Cancel</a>
                    </div>
                </div>
            </form>
        </div>
  </div>
@endsection