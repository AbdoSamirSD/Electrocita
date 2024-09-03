@extends('layouts.admin')

@section('title')
SubCategories
@endsection

@section('content')
    
<div class="card-body">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>SubCategories</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
              <a href="{{route('dashboard.subcategories.add')}}" class="btn btn-primary">Add SubCategory</a>
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
            <th>SubCategory Name</th>
            <th>Category Name</th>
            <th>Translation Language</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $subcategory)
            <tr>
                <td>{{ $subcategory->name }}</td>
                <td>{{ $subcategory->category->name }}</td>
                <td>{{ $subcategory->translation_lang }}</td>
                <td>{{ $subcategory->active == 1? 'Active' : 'Inactive' }}</td>
                <td>
                  <a href="{{ route('dashboard.subcategories.edit', ['id' => $subcategory->id]) }}" class="btn btn-sm btn-primary">edit</a>
                  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $subcategory->id }}">
                      delete
                  </button>
                </td>
                <div class="modal fade" id="confirmDeleteModal{{ $subcategory->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $subcategory->id }}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel{{ $subcategory->id }}"> delete </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to delete {{$subcategory->name}} This action cannot be undone.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                        <form action="{{ route('dashboard.subcategories.destroy', ['id' => $subcategory->id]) }}" method="POST" style="display: inline;">
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