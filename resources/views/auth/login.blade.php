@extends('layouts.layout')
@section('content')
    <div class="form-group login">
        <div class="form-items text-center">
            <h3>User Login</h3>
        </div>
        @include('messages')
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
