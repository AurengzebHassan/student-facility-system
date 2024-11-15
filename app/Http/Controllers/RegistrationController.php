<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use App\Mail\ForgotPasswordMail;

class RegistrationController extends Controller
{
    public function registration()
    {
        return view('layout.adminpanel.signup');
    }

    public function adminRegistration(Request $request)
    {

        // validate incoming request

        $request->validate([
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email|max:40|regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
            'password' => 'required|string|min:8|max:35|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'class' => 'required|min:3|max:15',
            'number' => 'required|digits:11|unique:users,number|regex:/^0[0-9]{10}$/',
            'rollno' => 'required|unique:users,rollno|min:8|max:20|regex:/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/',
        ], [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 3 characters.',
            'name.max' => 'Name must not exceed 20 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'Email is already in use.',
            'email.max' => 'Email must not exceed 40 characters.',
            'email.regex' => 'Email must be in lowercase format.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password must not exceed 35 characters.',
            'password.regex' => 'Password must contain at least one alphabet, one number, and one special character.',
            'class.required' => 'Depart is required.',
            'number.required' => 'Number is required.',
            'number.digits' => 'Number must be exactly 11 digits.',
            'number.unique' => 'Number is already in use.',
            'number.regex' => 'Number must start with 0 and contain only numeric characters.',
            'rollno.required' => 'Roll number is required.',
            'rollno.unique' => 'Roll number is already in use.',
            'rollno.min' => 'Roll number must be at least 8 characters.',
            'rollno.max' => 'Roll number must not exceed 20 characters.',
            'rollno.regex' => 'Roll number is not accurate.',
        ]);

        $save = new User;
        //user
        $save->name = trim($request->name);  // database 
        $save->email = trim($request->email);
        $save->class = trim($request->class);
        $save->number = trim($request->number);
        $save->rollno = trim($request->rollno);
        $save->password = Hash::make($request->password);
        $save->remember_token = Str::random(40);
        $save->user_id = mt_rand(10000000, 99999999);
        $save->save();

        Mail::to($save->email)->send(new RegisterMail($save));

        // Alert::success('Success', 'Account Registerd now verify your email Adress');
        return redirect()->route('login')->with('success', 'Account registered. Please verify your email address.');
    }
    public function verify($token)
    {
        // Find the user with the provided token
        $user = User::where('remember_token', $token)->first();

        // Check if the user exists
        if (!is_null($user)) {

            $user->email_verified_at = now();    // date('Y-m-d H:i:s')
            $user->remember_token = Str::random(40);
            $user->save();
            Alert::success('Success', 'Now You can Login');
            return redirect()->route('login');
        } else {
            // If no user is found with the provided token, return a 404 error
            abort(404);
        }
    }

    public function showLoginForm()
    {
        return view('layout.adminpanel.login');
    }

    public function authenticate(Request $request)
    {
        // Attempt admin login
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Admin login successful
            session()->put('id', Auth::guard('admin')->user()->id);
            Alert::success('Success', 'Admin login successful.');
            return redirect()->route('dashboard');
        }

        // Attempt regular user login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            // Check if user's email is verified and account is enabled
            if (!empty(Auth::user()->email_verified_at) && Auth::user()->is_enabled) {
                // User account is verified and enabled
                session()->put('id', Auth::user()->id);
                Alert::success('Success', 'User login successful.');
                return redirect()->route('frontend.index');
            } else {
                // User account is disabled or email not verified
                if (!empty(Auth::user()->email_verified_at)) {
                    // Account is disabled
                    Alert::error('Error', 'Your account is disabled.');
                    return redirect()->route('login');
                }  // User account is disabled or email not verified
                else {
                    $user_id = Auth::user()->id;
                    Auth::logout();
                    $save = User::getSingle($user_id);
                    $save->remember_token = Str::random(40);
                    $save->save();
                    Mail::to($save->email)->send(new RegisterMail($save));
                    Alert::error('Error', 'Please verify your email address.');
                    return redirect()->back();
                }
            }
        } else {
            // Login failed
            Alert::error('Error', 'Incorrect email or password.');
            return redirect()->route('login');
        }
    }

  
    

    public function user_reset_password()
    {
        return view('frontend.forgot');
    }

    public function forget_password(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if (!empty($user)) {
            $user->remember_token = Str::random(40);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            Alert::success('Success', 'Check email and reset password');
            return redirect()->back();
        } else {

            Alert::error('Error', 'Email not Found');
            return redirect()->back();
        }
    }
    public function resetmail($token)
    {
        $user = User::where('remember_token', '=', $token)->first();
        if (!empty($user)) {
            $data['user'] = $user;
            return view('frontend.resetpasscode');
        } else {
            abort(404);
        }
    }

    public function postreset($token, Request $request)
    {

        if (empty($request->password) || empty($request->password_confirmation)) {
            Alert::error('Error', 'Password fields cannot be empty.');
            return redirect()->back()->withInput();
        }

        $user = User::where('remember_token', '=', $token)->first();
        if (!empty($user)) {
            if ($request->password == $request->password_confirmation) {

                $user->password = Hash::make($request->password);
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = date('Y-m-d H:i:s');
                }
                $user->remember_token = Str::random(40);
                $user->Save();
                Alert::success('Success', 'Password Change Successfully');
                return redirect()->route('login');
            } else {
                Alert::error('Error', 'Password does not Match');
                return redirect()->back();
            }
        } else {
            abort(404);
        }
    }
}
