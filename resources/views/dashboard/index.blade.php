@extends('layouts.layout')
@section('content')
    <div class="main-section">
        <div class="form-items">
            <h3 class="text-left">Dashboard</h3>
            <div class="text-right mb-3">
                <a href="{{route('logout')}}" class="btn btn-dark btn-sm">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="section">
            <div class="row">
                <div class="col-md-4 text-center">
                    <a href="{{route('products.index')}}">Products</a>
                </div>
            </div>
        </div>
    </div>
@endsection
