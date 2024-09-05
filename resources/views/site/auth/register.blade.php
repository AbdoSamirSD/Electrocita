@extends('layouts.site')

@section('content')
<div class="container mt-5">
    @if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px;">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger" style="margin-bottom: 20px;">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="box p-4 shadow-sm rounded bg-white">
                <h1 class="mb-4">New Account</h1>
                <p class="lead">Not our registered customer yet?</p>
                <p>With registration with us, a new world of fashion, fantastic discounts, and much more opens to you! The whole process will not take you more than a minute!</p>
                <p class="text-muted">If you have any questions, please feel free to <a href="">contact us</a>, our customer service center is working for you 24/7.</p>
                <hr>
                <form action="{{route('post.register')}}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input value="{{old('name')}}" id="name" name="name" type="text" class="form-control">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input value="{{old('email')}}" id="email" name="email" type="text" class="form-control">
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control">
                    </div>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                    </div>
                    @error('password_confirmation')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
