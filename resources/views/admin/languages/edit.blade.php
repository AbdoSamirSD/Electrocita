@extends('layouts.admin')

@section('title')
Edit {{$language->name}}
@endsection

@section('content')

<form action="{{ route('dashboard.languages.update', ['id' => $language->id]) }}" method="post">
    @csrf
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="form-group row">
        <label for="abbr" class="col-sm-2 col-form-label">Abbreviation</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="abbr" name="abbr" value="{{$language->abbr}}" placeholder="e.g., EN">
            @error('abbr')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Language Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{$language->name}}" placeholder="e.g., English">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="native" class="col-sm-2 col-form-label">Native Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="native" name="native" value="{{$language->native}}" placeholder="e.g., English">
            @error('native')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="locale" class="col-sm-2 col-form-label">Locale</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="locale" name="locale" value="{{$language->locale}}" placeholder="e.g., en_US">
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
                <option value="ltr" {{$language->direction=='ltr'? 'selected' : ''}}>Left to Right</option>
                <option value="rtl" {{$language->direction=='rtl'? 'selected' : ''}}>Right to Left</option>
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
                <option value="1" {{ old('active', $language->active) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('active', $language->active) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-12 offset-sm-2 justify-content-between">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('dashboard.languages.list') }}" class="btn btn-danger text-left">Cancel</a>
        </div>
    </div>
</form>

@endsection
