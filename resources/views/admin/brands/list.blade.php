@extends('layouts.admin')

@section('title')
Brands
@endsection

@section('content')
    
<div class="card-body">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Brands</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
              <a href="{{route('dashboard.brands.add')}}" class="btn btn-primary">Add Brand</a>
            </div>
          </div>
        </div>
      </section>
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
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Brand Name</th>
            <th>Logo</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($brands as $brand)
            <tr>
              <td>
                @foreach($brand->translations as $translation)
                    <p>{{ $translation->name }}</p>
                @endforeach
            </td>
              <td><img src="{{ $brand->photo }}" alt="{{ $translation->name }}" style="width: 50px; height: 50px;"></td>
              <td>{{ $brand->is_active == 1? 'Active' : 'Inactive' }}</td>
              <td>
                <a href="{{ route('dashboard.brands.edit', ['id' => $brand->id]) }}" class="btn btn-sm btn-primary">edit</a>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $brand->id }}">
                    delete
                </button>
              </td>
              <div class="modal fade" id="confirmDeleteModal{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $brand->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirmDeleteModalLabel{{ $brand->id }}"> delete </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete {{$brand->name}} This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                      <form action="{{ route('dashboard.brands.destroy', ['id' => $brand->id]) }}" method="POST" style="display: inline;">
                          @csrf
                          <button type="submit" class="btn btn-danger">delete</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection