<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ImageUpload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ImageUpload;

    //Register
    public function register()
    {
        return view('auth.register');
    }

    //Register User
    public function register_user(Request $request)
    {
        $msg = [
            'name.required' => 'Please Enter Name.',
            'phone.required' => 'Please Enter Phone Number.',
            'phone.numeric' => 'Phone Number Must Be Number.',
            'phone.unique' => 'Phone Number Number Must Be Unique.',
            'email.required' => 'Please Enter Email.',
            'email.email' => 'Email Must Be A Valid Email.',
            'email.unique' => 'Please Enter An Unique Email.',
            'password.required' => 'Please Enter Password.',
            'password.min' => 'Password Must Be 6 Characters.',
            'confirm_password.required' => 'Please Enter Confirm Password.',
            'confirm_password.same' => 'Password And Confirm Password Must Be Same.',
            'confirm_password.min' => 'Confirm Password Must Be 6 Characters.',
        ];
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|numeric|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required_with:password|same:password|min:6',
        ], $msg);
        try {
            $path = '/images/user/';
            $image = $this->saveImage($path, $request['image']);
            $user = new User();
            $user->image = $path . '/' . $image;
            $user->name = $request['name'];
            $user->phone = $request['phone'];
            $user->email = $request['email'];
            $user->gender = $request['gender'];
            $user->password = bcrypt($request['password']);
            $user->save();

            Auth::login($user);
            return redirect()->route('products.index')->with('success', 'User Register Successfully');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // Check Email
    public function check_email(Request $request)
    {
        try {
            $input['email'] = $request->email;
            $rules = array('email' => 'unique:users,email');
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'success', 'msg' => true]);
            } else {
                return response()->json(['status' => 'success', 'msg' => false]);
            }
        } catch (Exception $exception) {
            return response()->json(['status' => 'error', 'msg' => $exception->getMessage()]);
        }
    }

    //Login
    public function login()
    {
        return view('auth.login');
    }

    //Login User
    public function login_user(Request $request)
    {
        $msg = [
            'email.required' => 'Please Enter Email',
            'email.email' => 'Please Enter A Valid Email Address',
            'password.required' => 'Please Enter Your Password',
            'password.min' => 'Please Enter Minimum 6 Character Password',
        ];
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], $msg);
        try {
            $username = $request->email;
            $password = $request->password;
            if (Auth::attempt(array('email' => $username, 'password' => $password))) {
                return redirect()->route('dashboard')->with('success', 'Hello ' . Auth::user()['name'] . ', You Are Login Successfully');
            } else {
                return redirect()->back()->with('error', 'Login Unsuccessfully!!! Please Check Your Credentials');
            }
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout Successfully');
    }
}
