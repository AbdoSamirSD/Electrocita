@extends('layouts.admin')

@section('title')
Edit option
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
                <h4 class="card-title text-primary">Edit Option</h4>
            </div>
        
            <form action="{{ route('dashboard.options.update', ['id'=>$option->id]) }}" method="POST" enctype="multipart/form-data" class="p-3">
                @csrf
                <div class="form-body">
                    <h4 class="form-section text-primary"><i class="ft-info"></i>Options</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="option">option Name</label>
                                <input type="text" id="option" class="form-control" value="{{ $option->name }}" name="option">
                                @error("option")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="attribute_id">Attribute</label>
                                <select name="attribute_id" id="attribute_id" class="form-control">
                                    <option value="">Select Attribute</option>
                                    @foreach($attributes as $attribute)
                                        <option value="{{ $attribute->id }}" {{($option->attribute_id == $attribute->id)?'selected' : ''}}>{{ $attribute->name }}</option>
                                    @endforeach
                                </select>
                                @error("attribute_id")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col text-left">
                            <button type="submit" class="btn btn-success"><i class="ft-save"></i> Save</button>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('dashboard.options.list') }}" class="btn btn-danger"><i class="ft-x"></i> Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection