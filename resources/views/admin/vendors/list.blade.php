@extends('layouts.admin')

@section('title')
Vendors
@endsection

@section('content')
    
<div class="card-body">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Vendors</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
              <a href="{{route('dashboard.vendors.add')}}" class="btn btn-primary">Add Vendor</a>
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
            <th>Vendor Name</th>
            <th>Vendor Email</th>
            <th>Vendor Phone</th>
            <th>Vendor Address</th>
            <th>category</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($vendors as $vendor)
            <tr>
                <td>{{ $vendor->name }}</td>
                <td>{{ $vendor->email }}</td>
                <td>{{ $vendor->phone }}</td>
                <td>{{ $vendor->address }}</td>
                <td>{{ $vendor->category->name}}</td>
                <td>{{ $vendor->status == 1? 'Active' : 'Inactive' }}</td>
                <td>
                  <a href="{{ route('dashboard.vendors.edit', ['id' => $vendor->id]) }}" class="btn btn-sm btn-primary">edit</a>
                  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $vendor->id }}">
                      delete
                  </button>
                </td>
                <div class="modal fade" id="confirmDeleteModal{{ $vendor->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $vendor->id }}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel{{ $vendor->id }}"> delete </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to delete {{$vendor->name}} This action cannot be undone.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                        <form action="{{ route('dashboard.vendors.destroy', ['id' => $vendor->id]) }}" method="POST" style="display: inline;">
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

@push('scripts')
<script>
  
</script>
@endpush