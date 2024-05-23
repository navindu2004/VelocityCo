<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Debug information for checking input values
        logger()->info('Attempting to login with:', ['email' => $input['email'], 'password' => $input['password']]);

        // Check if user exists and password is correct
        $user = \App\Models\User::where('email', $input['email'])->first();

        if ($user && Hash::check($input['password'], $user->password)) {
            // Attempt to authenticate the user
            if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                logger()->info('User authenticated successfully', ['user_id' => $user->id]);

                if (auth()->user()->type == 'admin') {
                    return redirect()->route('admin.home');
                } elseif (auth()->user()->type == 'manager') {
                    return redirect()->route('manager.home');
                } else {
                    return redirect()->route('home');
                }
            } else {
                logger()->error('Authentication failed despite correct password');
                return redirect()->route('login')
                    ->with('error', 'Authentication failed, please try again.');
            }
        } else {
            logger()->warning('Invalid login attempt', ['email' => $input['email']]);
            return redirect()->route('login')
                ->with('error', 'Email-Address And Password Are Wrong.');
        }
    }
}
