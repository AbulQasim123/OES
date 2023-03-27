<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Subject;
use App\Models\PasswordReset;

class AuthController extends Controller
{
    public function loadLoginRegister()
    {
        if (Auth::user() && Auth::user()->type == "Admin") {
            return redirect('/admin/dashboard');
        } else if (Auth::user() && Auth::user()->type == "Student") {
            return redirect('/dashboard');
        }

        // $insert_id = User::insertGetId([
        //     'name' => 'Kishan',
        //     'email' => 'kishan@gmail.com',
        //     'password' => 'kishan',
        //     'type' => 'Student'
        // ]);
        
        // Post::create([
        //     'user_id' => $insert_id,
        //     'post' => "Post title 4"
        // ]);

        // $users = User::with('post')->get();
        
        
        // return view('auth/login-register', compact('users'));
        return view('auth/login-register');
    }
    public function Register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|min:2|max:10',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:3|max:8|confirmed',
                'password_confirmation' => 'required'
            ],
            [
                'name.required' => 'Name Field is required?',
                'name.string' => 'Name only should be letter. not allowed number or special char',
                'name.min' => 'Name should be Minimum 2 character long?',
                'name.max' => 'Name should be Maximum 10 character long',
                'email.required' => 'Email is required?',
                'email.email' => 'Enter a valid email address',
                'email.unique' => 'Email has been already taken!',
                'password.required' => 'Password is required?',
                'password.min' => 'Password should be Minimum 2 character long',
                'password.max' => 'Password should be Maximum 6 character long',
                'password.confirmed' => 'Confirm Password does not match with password!',
                'password_confirmation.required' => 'Confirm Password is required?',
            ]
        )->validate();
        // dd($request);
        $user = User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'Admin'
        ]);
        return back()->with(['success' => 'Registration has been successfully.']);
    }

    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:3|max:10',
            ],
            [
                'email.required' => 'Email is required?',
                'email.email' => 'Enter a valid email address',
                'password.required' => 'Password is required?',
                'password.min' => 'Password should be Minimum 2 character long',
                'password.max' => 'Password should be Maximum 8 character long',
            ]
        )->validate();

        // $userdata = User::where('email',$request->loginemail)->first();
            
        
        $credenttial = $request->only('email','password');

        // dd($credenttial);
        if (Auth::attempt($credenttial)) {
            if (Auth::user()->type == "Admin") {
                // $request->session()->put('user', $credenttial);
                return redirect('/admin/dashboard');
            } else {
                
                return redirect('/dashboard');
            }
        
        } else {
            return back()->with(['error' => "Invalid Credenttial..."]);
        }

        
    }

    public function StudentDashboard()
    {
        return view('student.dashboard');
    }
    public function AdminDashboard()
    {
        $subjects = Subject::all();
        return view('admin.dashboard', compact('subjects'));
    }
    public function Logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

    // Load Forget Password view
    public function ForgetPasswordLoad()
    {
        return view('auth\forget-password');
    }
    //Submit Forget Password view
    public function ForgetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_email' => 'required|email',
            ],
            [
                'user_email.required' => 'Email is required?',
                'user_email.email' => 'Enter a valid email address',
            ]
        )->validate();

        try {
            $user = User::where('email', $request->user_email)->get();
            if (count($user) > 0) {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain . '/reset-password?token=' . $token;

                $data['url'] = $url;
                $data['email'] = $request->user_email;
                $data['title'] = "Password Reset";
                $data['body'] = "Please click on below link to reset";

                Mail::send('mail.forgetpasswordmail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $request->user_email],
                    [
                        'email' => $request->user_email,
                        'token' => $token,
                        'created_at' => $datetime,
                    ]
                );
                return back()->with('success', 'Please Check your email to reset your password');
            } else {
                return back()->with('error', 'Email is not exist!');
            }
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    // Load Reset Password view
    public function ResetPasswordLoad(Request $request)
    {
        $resettoken = PasswordReset::where('token', $request->token)->get();
        if (isset($request->token) && count($resettoken) > 0) {
            $resetuser = User::where('email', $resettoken[0]['email'])->get();
            return view('auth/resetpassword', compact('resetuser'));
            
        } else {
            return view('error/404');
        }
    }
    // Submit Reset Password view
    public static function ResetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'old_password' => 'required|min:3|max:8',
                'password' => 'required|min:3|max:6|confirmed',
                'password_confirmation' => 'required'
            ],
            [
                'old_password.required' => 'Old Password is required?',
                'old_password.min' => 'Password should be Minimum 2 character long',
                'old_password.max' => 'Password should be Maximum 6 character long',
                'password.required' => 'Password is required?',
                'password.min' => 'Password should be Minimum 2 character long!',
                'password.max' => 'Password should be Maximum 8 character long!',
                'password.confirmed' => 'Confirm Password does not match with password!',
                'password_confirmation.required' => 'Confirm Password is required?',
            ]
        )->validate();

        $user = User::find($request->resetid);
        // dd($user);
        if(Hash::check($request->old_password, $user->password)){
            return back()->with('error', 'The old password does not match our records');
        }
        if($request->old_password == $request->password){
            return back()->with('error', 'Your current password can not be with new password');
        }else{
            $user->password = Hash::make($request->password);
            $user->save();
            PasswordReset::where('email',$user->email)->delete();
            return "<h3>Password Reset has been Successfully.</h3>";
        }
    }
}
