@extends('layouts.admin')

@section('title')
Add New Product
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
        <h4 class="card-title text-primary">Add New Product</h4>
    </div>

    <form action="{{ route('dashboard.products.updateimage') }}" method="POST" enctype="multipart/form-data" class="p-3">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="form-body">
            <h4 class="form-section text-primary"><i class="ft-info"></i> General Info</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" value="{{ old('image') }}" name="image">
                        @error("image")
                            <span class="text-danger">{{ $message }}</span>
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
    {{-- to show photoes --}}
    <div class="row">
        @isset($images)
            @foreach ($images as $image)
                <div class="col-md-3 text-center">
                    <img src="{{$image->path}}" alt="" class="img-thumbnail">
                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $image->id }}">
                        delete
                    </button>
                    <div class="modal fade" id="confirmDeleteModal{{ $image->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $image->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="confirmDeleteModalLabel{{ $image->id }}"> delete </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              Are you sure you want to delete this image? This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                              <form action="{{ route('dashboard.products.destroyimage', ['id' => $image->id]) }}" method="POST" style="display: inline;">
                                  @csrf
                                  <button type="submit" class="btn btn-danger">delete</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            @endforeach
        @endisset
    </div>
</div>
@endsection
