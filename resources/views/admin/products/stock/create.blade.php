@extends('layouts.admin')

@section('title')
Edit Stock
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
        <h4 class="card-title text-primary">Edit Stock for {{$product->name}}</h4>
    </div>

    <form action="{{ route('dashboard.products.updatestock') }}" method="POST" enctype="multipart/form-data" class="p-3">
        @csrf
        <input type="number" name="product_id" value="{{$product->id}}" hidden>
        <div class="form-body">
            <h4 class="form-section text-primary"><i class="ft-info"></i>Price</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sku">Product code (SKU)</label>
                        <input type="text" id="sku" class="form-control" value="{{ old('sku') }}" name="sku">
                        @error("sku")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="track_stock">Track Stock</label>
                        <select class="form-control" name="track_stock" id="track_stock">
                            <option value="" selected>--- Select Type ---</option>
                            <option value="1">Track</option>
                            <option value="0">Not track</option>
                        </select>
                        @error('track_stock')
                            <span class="text-danger"> {{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Product Status</label>
                        <select class="form-control" name="status" id="qty">
                            <option value="" selected>--- Select Type ---</option>
                            <option value="1">In stock</option>
                            <option value="0">Out of stock</option>
                        </select>
                        @error('status')
                            <span class="text-danger"> {{$message}}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6" style="display: none;" id="qtydiv">
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" id="qty" class="form-control" value="{{ old('qty') }}" name="qty">
                        @error('qty')
                            <span class="text-danger"> {{$message}}</span>
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
                <a href="{{ route('dashboard.products.list') }}" class="btn btn-danger"><i class="ft-x"></i> Cancel</a>
            </div>
        </div>
    </form>
    
</div>
@endsection

  
@push('scripts')
<script>
    $(document).on('change', '#track_stock', function(){
        var track_stock = $(this).val();
        if(track_stock == 1){
            $('#qtydiv').show();
        }else{
            $('#qtydiv').hide();
        }
    });
</script>
@endpush
