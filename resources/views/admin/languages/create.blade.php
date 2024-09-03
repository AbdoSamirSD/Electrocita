@extends('layouts.admin')

@section('title')
Add language
@endsection

@section('content')

<form action="{{ route('dashboard.languages.store') }}" method="post">
    @csrf
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

    <div class="form-group row">
        <label for="abbr" class="col-sm-2 col-form-label">Abbreviation</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="abbr" name="abbr" value="{{ old('abbr') }}" placeholder="e.g., EN">
            @error('abbr')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Language Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="e.g., English">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="native" class="col-sm-2 col-form-label">Native Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="native" name="native" value="{{ old('native') }}" placeholder="e.g., English">
            @error('native')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="locale" class="col-sm-2 col-form-label">Locale</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="locale" name="locale" value="{{ old('locale') }}" placeholder="e.g., en_US">
            @error('locale')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="direction" class="col-sm-2 col-form-label">Direction</label>
        <div class="col-sm-10">
            <select class="form-control" id="direction" name="direction">
                <option value="">--- Select Direction ---</option>
                <option value="ltr" >Left to Right</option>
                <option value="rtl" >Right to Left</option>
            </select>
            @error('direction')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
            <select class="form-control" id="status" name="status">
                <option value="">--- Select Status ---</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            @error('status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>

@endsection
