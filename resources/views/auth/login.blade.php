@extends('layouts.layout')
@section('content')
    <div class="form-group login">
        <div class="form-items text-center">
            <h3>User Login</h3>
        </div>
        @if(count($errors) > 0 )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="p-0 m-0" style="list-style: none;">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissable custom-success-box">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{ session('success') }} </strong>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissable custom-success-box">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{ session('error') }} </strong>
            </div>
        @endif
        <form action="{{route('login_user')}}" method="post" autocomplete="off">
            {{csrf_field()}}
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" placeholder="Please Enter Email Address" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" placeholder="Please Enter Password" class="form-control" name="password" id="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{route('register')}}" class="btn btn-success">Register <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
        </form>
    </div>
@endsection
