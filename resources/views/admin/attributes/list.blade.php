@extends('layouts.admin')

@section('title')
Attributes
@endsection

@section('content')
    
<div class="card-body">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Attributes</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
              <a href="{{route('dashboard.attributes.add')}}" class="btn btn-primary">Add Attribute</a>
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
            <th>Attribute</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($attributes as $attribute)
            <tr>
              <td>
                @foreach($attribute->translations as $translation)
                    <p>{{ $translation->name }}</p>
                @endforeach
            </td>
            <td>
                <a href="{{ route('dashboard.attributes.edit', ['id' => $attribute->id]) }}" class="btn btn-sm btn-primary">edit</a>
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $attribute->id }}">
                    delete
                </button>
              </td>
              <div class="modal fade" id="confirmDeleteModal{{ $attribute->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $attribute->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="confirmDeleteModalLabel{{ $attribute->id }}"> delete </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete {{$attribute->name}}? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                      <form action="{{ route('dashboard.attributes.destroy', ['id' => $attribute->id]) }}" method="POST" style="display: inline;">
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