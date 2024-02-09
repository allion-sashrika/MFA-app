<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\MyCustomMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;



class LoginRegisterController extends Controller
{
    private $credentials;
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login')
            ->withSuccess('You have successfully registered!');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function generateOTP()
    {
        if (!Session::has('resendflag')) {
            if (Session::has('otp') && Session::has('otp_expires_at')) {
                $otpExpirationTime = Session::get('otp_expires_at');
    
                if (Carbon::now()->lt($otpExpirationTime)) {
                    return view('auth.2fa');
                }
            }
        }

        $otp = mt_rand(100000, 999999);

        Session::put('otp', $otp);
        Session::put('otp_expires_at', now()->addMinutes(15));
        Session::forget('resendflag');

        $email = Session::get('email');

        Mail::to($email)->send(new MyCustomMail($otp));

        return view('auth.2fa');
    }

    public function resendOTP()
    {
        $resendflag = true;
        Session::put('resendflag', $resendflag);

        $this->generateOTP();

        return redirect()->route('generateOTP')
            ->withSuccess('OTP has been resent');
    }

    public function twofactor(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $storedOTP = Session::get('otp');
        $otpExpirationTime = Session::get('otp_expires_at');

        $credentials = Session::get('credentials');

        if (Carbon::now()->gt($otpExpirationTime)) {
            return view('auth.2fa')->withErrors(['otp' => 'OTP has expired.']);
        }

        if ($request->otp == $storedOTP) {
            Session::forget('otp');
            Session::forget('otp_expires_at');
            Auth::attempt($credentials);
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        } else {
            return view('auth.2fa')->withErrors([
                'otp' => 'The OTP you provided is incorrect.',
            ]);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Your provided credentials do not match in our records.',
            ])->onlyInput('email');
        }

        Session::put('email', $request->email);
        Session::put('password', $request->password);
        Session::put('credentials', $credentials);

        return $this->generateOTP();
    }

    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}
