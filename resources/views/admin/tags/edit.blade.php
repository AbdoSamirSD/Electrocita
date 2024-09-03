@extends('layouts.admin')

@section('title')
Edit {{$tag->name}} Tag
@endsection

@section('content')

<form action="{{ route('dashboard.tags.update', ['id'=>$tag->id]) }}" enctype="multipart/form-data" method="post">
    @csrf
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
                <label for="name">Tag Name</label>
                <input value="{{ $tag->name }}" type="text" class="form-control" name="name">
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="link">Tag Link</label>
                <input value="{{ $tag->slug }}" type="text" class="form-control" name="link">
                @error('link')
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
            <a href="{{route('dashboard.tags.list')}}" class="btn btn-danger">Cancel</a>
        </div>
    </div> 
    
    <input type="hidden" name="id" value="{{ $tag->id }}">
</form>

@endsection