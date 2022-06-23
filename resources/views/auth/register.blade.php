@extends('layouts.layout')
@section('content')
    <div class="form-group registration">
        <div class="form-items text-center">
            <h3>User Registration</h3>
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
        <form action="{{route('register_user')}}" method="post" enctype="multipart/form-data" autocomplete="off">
            {{csrf_field()}}
            <div class="form-group">
                <label for="image">Profile Image</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" placeholder="Please Enter Name" value="{{old('name')}}"
                       name="name" id="name">
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" placeholder="Please Enter Email Address"
                       value="{{old('email')}}" name="email" id="email" onkeypress="hide_error_msg(this.name)">
                <span class="validation_message" id="email_err"></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" placeholder="Please Enter Phone Number"
                       onkeypress="validate(this.events)" value="{{old('phone')}}" name="phone" id="phone">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" placeholder="Please Enter Password" class="form-control" name="password"
                       id="password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" placeholder="Please Enter Confirm Password" class="form-control"
                       name="confirm_password" id="confirm_password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{route('login')}}" class="btn btn-success">Login <i class="fa fa-arrow-circle-right"
                                                                          aria-hidden="true"></i></a>
        </form>
    </div>
    @push('scripts')
        <script>
            const debounce = (fn, delay) => {
                let timeOutID;
                return function (...args) {
                    if (timeOutID) {
                        clearTimeout(timeOutID);
                    }
                    timeOutID = setTimeout(() => {
                        fn(...args);
                    }, delay)
                }
            };

            document.getElementById('email').addEventListener('keyup', debounce(event => {
                checkEmail();
            }, 2000));

            const checkEmail = () => {
                let email = document.getElementById('email').value;
                $.ajax({
                    url: '{{route('check_email')}}',
                    type: 'post',
                    data: {
                        _token: '{{csrf_token()}}',
                        email: email
                    },
                    success: function (data) {
                        if (data.status == "success") {
                            if(data.msg == true){
                                document.getElementById('email_err').innerHTML = 'This Email Already Exist';
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            })
                        }
                    }
                });
            };
        </script>
    @endpush
@endsection
