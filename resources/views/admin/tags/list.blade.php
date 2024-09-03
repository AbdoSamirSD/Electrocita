@extends('layouts.admin')

@section('title')
Tags
@endsection

@section('content')
    
<div class="card-body">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Tags</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
              <a href="{{route('dashboard.tags.add')}}" class="btn btn-primary">Add Tag</a>
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
            <th>Tag Name</th>
            <th>Tag Link</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @isset($tags)
            @foreach($tags as $tag)
            <tr>
                <td>{{ $tag->name }}</td>
                <td>{{ $tag->slug }}</td>
                <td>
                  <a href="{{ route('dashboard.tags.edit', ['id' => $tag->id]) }}" class="btn btn-sm btn-primary">edit</a>
                  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $tag->id }}">
                      delete
                  </button>
                </td>
                <div class="modal fade" id="confirmDeleteModal{{ $tag->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $tag->id }}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel{{ $tag->id }}"> delete </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to delete {{$tag->name}} This action cannot be undone.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                        <form action="{{ route('dashboard.tags.destroy', ['id' => $tag->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </tr>
            @endforeach
            @endisset
        </tbody>
      </table>
    </div>
  </div>
  
@endsection

@push('scripts')
<script>
  
</script>
@endpush