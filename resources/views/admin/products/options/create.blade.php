@extends('layouts.admin')

@section('title')
Add Options to {{$product->name}}
@endsection

@section('content')

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

<div class="card">
    <div class="card-header bg-dark text-white">
        <h4 class="card-title text-primary">Add Options to {{$product->name}}</h4>
    </div>

    <form action="{{ route('dashboard.products.updateoptions') }}" method="POST" enctype="multipart/form-data" class="p-3">
        @csrf
        <div class="form-body">
            <h4 class="form-section text-primary"><i class="ft-info"></i>Options Validated</h4>
            <div class="row">
                <!-- Product Name -->
                <div class="col-md-12">
                    <div class="form-group @error("options") has-error @enderror">
                        <label for="options">Options</label>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <br><br>
                        @if ($options->count() > 0)
                            @foreach($options as $option)
                                <label class="badge" style="background-color: #004085; color: #fff; padding: 10px; border-radius: 20px; margin: 5px;">
                                    <input type="checkbox" {{ in_array($option->id, $product->options->pluck('id')->toArray()) ? 'checked' : '' }} name="options[]" value="{{ $option->id }}" style="margin-right: 5px;"> 
                                    {{ $option->name }}
                                </label>
                            @endforeach
                        @else
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            No options available. Please add options first.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    @error('options')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col text-left">
                    <button type="submit" class="btn btn-success"><i class="ft-save"></i>Save</button>
                </div>
                <div class="col text-right">
                    <a href="{{ route('dashboard.products.list') }}" class="btn btn-danger"><i class="ft-x"></i>Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection