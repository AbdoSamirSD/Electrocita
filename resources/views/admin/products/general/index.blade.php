@extends('layouts.admin')

@section('title')
Products
@endsection

@section('content')

<div class="card-body">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="color: #007bff;">General Info</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('dashboard.products.general.create')}}" class="btn btn-primary">Add Product</a>
                </div>
            </div>
        </div>
    </section>

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

    <div class="table-responsive">
        <table class="table table-hover table-bordered" id="products-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Product Slug</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Options</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index=>$product)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->slug }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @foreach($product->options as $option)
                                <span class="badge badge-primary">{{ $option->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $product->is_active == 1 ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('dashboard.products.general.edit', $product->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                <a href="{{ route('dashboard.products.getprice', $product->id) }}" class="btn btn-outline-primary btn-sm">Price</a>
                                <a href="{{ route('dashboard.products.getimage', $product->id) }}" class="btn btn-outline-primary btn-sm">Images</a>
                                <a href="{{ route('dashboard.products.getstock', ['id'=>$product->id]) }}" class="btn btn-outline-primary btn-sm">Stock</a>
                                
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@push('styles')
<style>
    th, td {
        text-align: left;
        padding: 10px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    th {
        background-color: #383838;
        color: #212529;
    }

    .btn-group .btn {
        margin-right: 5px;
    }

    .simple-pagination {
        display: flex;
        list-style-type: none;
        padding: 0;
        justify-content: center;
    }

    .simple-pagination li {
        margin: 0 5px;
    }

    .simple-pagination a {
        color: #007bff;
        padding: 5px 10px;
        text-decoration: none;
    }

    .simple-pagination .active a {
        font-weight: bold;
        text-decoration: underline;
    }
</style>
@endpush
