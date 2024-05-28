<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Pipeline;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use constGuards;
use constDefaults;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Actions\Fortify\RedirectIfTwoFactorAuthenticatable;
use App\Actions\Fortify\AttemptToAuthenticate;
use App\Http\Responses\LoginResponse;

class AdminController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }


    public function login(){
        return redirect()->route('auth.login');
    }

    /**
     * Show the login view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LoginViewResponse
     */
    public function create(Request $request): LoginViewResponse
    {
        return app(LoginViewResponse::class);
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param  \Laravel\Fortify\Http\Requests\LoginRequest  $request
     * @return mixed
     */
    public function store(LoginRequest $request)
    {
        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Authentication passed, redirect to the admin dashboard
            return redirect()->intended('admin/dashboard');
        }
    
        // Authentication failed, redirect back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Get the authentication pipeline instance.
     *
     * @param  \Laravel\Fortify\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Pipeline\Pipeline
     */
    protected function loginPipeline(LoginRequest $request)
    {
        if (Fortify::$authenticateThroughCallback) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        if (is_array(config('fortify.pipelines.login'))) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                config('fortify.pipelines.login')
            ));
        }

        return (new Pipeline(app()))->send($request)->through(array_filter([
            config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
            config('fortify.lowercase_usernames') ? CanonicalizeUsername::class : null,
            Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
            AttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LogoutResponse
     */
    public function destroy(Request $request): LogoutResponse
    {
        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return app(LogoutResponse::class);
    }


    //new code from tutorial
    public function loginHandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'type';

        if($fieldType == 'email'){
            $request->validate([
                'login_id'=>'required|email|exists:admins,email',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or username is required',
                'login_id.email'=>'Invalid email address',
                'login_id.exists'=>'Email does not exist in system',
                'password.required'=>'Password is required'
            ]);
        }else{
            $request->validate([
                'login_id'=>'required|exists:admins,type',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.exists'=>'Username is not existing in the system',
                'password.required'=>'Password is required',
            ]);

        }

        $creds = array(
            $fieldType => $request->login_id,
            'password'=>$request->password
        );

        if(Auth::guard('admin')->attempt($creds) ){
            return redirect()->route('admin.home');
        }else{
            session()->flash('fail','Incorrect credentials');
            return redirect()->route('admin.login');
        }
    }

    public function logoutHandler(Request $request){
        Auth::guard('admin')->logout();
        session()->flash('fail', 'You are logged out.');
        return redirect()->route('admin.login');
    }

    public function sendPasswordResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:admins,email'
        ],[
            'email.required'=>'The :attribute is required',
            'email.email'=>'Invalid email address',
            'email.exists'=>'The :attribute does not exist in system'
        ]);

        //Get admin details
        $admin = Admin::where('email',$request->email)->first();

        //Generate token
        $token = base64_encode(Str::random(64));

        //Check if there is an existing reset password token
        $oldToken = DB::table('password_reset_tokens')
                        ->where(['email'=>$request->email,'guard'=>constGuards::ADMIN])
                        ->first();

        if( $oldToken ){
            //Update Token
            DB::table('password_reset_tokens')
                ->where(['email'=>$request->email,'guard'=>constGuards::ADMIN])
                ->update([
                'token'=>$token,
                'created_at'=>Carbon::now()
                ]);
        }else{
            //add new token
            DB::table('password_reset_tokens')->insert([
                'email'=>$request->email,
                'guard'=>constGuards::ADMIN,
                'token'=>$token,
                'created_at'=>Carbon::now()
            ]);
        }

        $actionLink = route('admin.reset-password',['token'=>$token,'email'=>$request->email]);

        $data = array(
            'actionLink'=>$actionLink,
            'admin'=>$admin
        );

        $mail_body = view('email-templates.admin-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('EMAIL_FROM_NAME'),
            'mail_recipient_email'=>$admin->email,
            'mail_recipient_name'=>$admin->name,
            'mail_subject'=>'Reset Password',
            'mail_body'=>$mail_body
        );

        if( sendEmail($mailConfig) ){
            session()->flash('success','We have emailed your password reset link');
            return redirect()->route('admin.forgot-password');
        }else{
            session()->flash('fail','Something went wrong');
            return redirect()->route('admin.forgot-password');
        }

    }

    public function resetPassword(Request $request, $token = null){
        $check_token = DB::table('password_reset_tokens')
                        ->where(['token'=>$token,'guard'=>constGuards::ADMIN])
                        ->first();

        if( $check_token ){
            //check if token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if( $diffMins > constDefaults::tokenExpiredMinutes ){
                //if token expired
                session()->flash('fail','Token expired, request another reset password link.');
                return redirect()->route('admin.forgot-password',['token'=>$token]);
            }else{
                return view('back.pages.admin.auth.reset-password')->with(['token'=>$token]);
            }
        }else{
            session()->flash('fail','Invalid token!, request another reset password link');
            return redirect()->route('admin.forgot-password',['token'=>$token]);
        }
    }

    public function resetPasswordHandler(Request $request){
        $request->validate([
            'new_password'=>'required|min:5|max:45|required_with:new_password_confirmation|
            same:new_password_configuration',
            'new_password_confirmation' => 'required'
        ]);

        $token = DB::table('password_reset_tokens')
                    ->where(['token' =>$request->token, 'guard'=>constGuards::ADMIN])
                    ->first();

        //get admin details
        $admin = Admin::where('email',$token->email)->first();

        //update admin password
        Admin::where('email', $admin->email)->update([
            'password'=>Hash::make($request->new_password)
        ]);

        //delete token record
        DB::table('password_reset_tokens')->where([
            'email'=>$admin->email,
            'token'=>$request->token,
            'guard'=>constGuards::ADMIN
        ])->delete();

        //send email to notify admin
        $data = array(
            'admin'=>$admin,
            'new_password'=>$request->new_password
        );

        $mail_body = view('email-templates.admin-reset-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email'=>env('MAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('MAIL_FROM_NAME'),
            'mail_recipient_email'=>$admin->email,
            'mail_recipient_name'=>$admin->name,
            'mail_subject'=>'Password Changed',
            'mail_body'=>$mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('admin.login')->with('success', 'Done! Your password has been changed. Use new password to login to system');
    }

    public function profileView(Request $request){
        $admin = null;
        if( Auth::guard('admin')->check() ){
            $admin = Admin::findOrFail(auth()->id());
        }
        return view('back.pages.admin.profile', compact('admin'));
    }
}
