@extends('layouts.admin')

@section('title')
Languages
@endsection

@section('content')
    
<div class="card-body">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Languages</h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
              <a href="{{route('dashboard.languages.add')}}" class="btn btn-primary">Add Language</a>
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
            <th>Abbreviation</th>
            <th>Language Name</th>
            <th>Native Name</th>
            <th>Locale</th>
            <th>Direction</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach($languages as $language)
            <tr>
                <td>{{ $language->abbr }}</td>
                <td>{{ $language->name }}</td>
                <td>{{ $language->native }}</td>
                <td>{{ $language->locale }}</td>  
                <td>{{ $language->direction }}</td>
                <td>{{ $language->active == 1? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{route('dashboard.languages.edit', ['id' => $language->id])}}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{route('dashboard.languages.destroy', ['id' => $language->id])}}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection