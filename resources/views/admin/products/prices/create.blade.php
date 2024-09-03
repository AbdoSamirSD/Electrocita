@extends('layouts.admin')

@section('title')
Add Price
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
        <h4 class="card-title text-primary">Add price for {{$product->name}}</h4>
    </div>

    <form action="{{ route('dashboard.products.updateprice') }}" method="POST" enctype="multipart/form-data" class="p-3">
        @csrf
        <input type="number" name="product_id" value="{{$product->id}}" hidden>
        <div class="form-body">
            <h4 class="form-section text-primary"><i class="ft-info"></i>Price</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Product Price</label>
                        <input type="text" id="price" class="form-control" value="{{ $product->price }}" name="price">
                        @error("price")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="special_price">Special Price</label>
                        <input type="text" class="form-control" value="{{ $product->special_price }}" name="special_price">
                        @error("special_price")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="special_price_type">Special Price Type</label>
                        <select class="form-control" name="special_price_type">
                            <option value="" selected>--- Select Type ---</option>
                            <option value="fixed" {{$product->special_price_type == 'fixed'? 'selected' : ''}}>Fixed</option>
                            <option value="percentage" {{$product->special_price_type == 'percentage'? 'selected' : ''}}>Percentage</option>
                        </select>
                        @error('special_price_type')
                            <span class="text-danger"> {{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="special_price_start">Start Date</label>
                        <input type="date" id="special_price_start" class="form-control" value="{{$product->special_price_start}}" name="special_price_start">
                        @error('special_price_start')
                            <span class="text-danger"> {{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="special_price_end"> End Date
                        </label>
                        <input type="date" id="special_price_end" class="form-control" value="{{$product->special_price_end}}" name="special_price_end">
                        @error('special_price_end')
                            <span class="text-danger"> {{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            
        </div>

        <!-- Form Buttons -->
        <div class="row">
            <div class="col text-left">
                <button type="submit" class="btn btn-success"><i class="ft-save"></i> Save</button>
            </div>
            <div class="col text-right">
                <a href="{{ route('dashboard.products.list') }}" class="btn btn-danger"><i class="ft-x"></i> Cancel</a>
            </div>
        </div>
    </form>
    
</div>
@endsection
