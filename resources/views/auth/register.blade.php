@extends('layouts.layout')
@section('content')
    <div class="form-group registration">
        <div class="form-items text-center">
            <h3>User Registration</h3>
        </div>
        @include('messages')
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
                       onkeypress="validate(this.events)" value="{{old('phone')}}" name="phone" id="phone" onkeyup="hide_error_msg(this.name)">
                <span class="validation_message" id="phone_err"></span>
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
                checkEmailPhone('email');
            }, 2000));

            document.getElementById('phone').addEventListener('keyup', debounce(event => {
                checkEmailPhone('phone');
            }, 2000));

            const checkEmailPhone = (type) => {
                let email = document.getElementById('email').value;
                let phone = document.getElementById('phone').value;
                $.ajax({
                    url: '{{route('check_email')}}',
                    type: 'post',
                    data: {
                        _token: '{{csrf_token()}}',
                        email: email,
                        phone: phone,
                        type:type
                    },
                    success: function (data) {
                        if (data.status == "success") {
                            if(data.msg == true){
                                if(type == 'email'){
                                    document.getElementById('email_err').innerHTML = 'This Email Already Exist';
                                }else{
                                    document.getElementById('phone_err').innerHTML = 'This Phone Already Exist';
                                }
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
