<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\VerificationToken;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use constGuards;
use constDefaults;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Mberacall\Kropify\Kropify;
use Mberecall\Services\Library\Kropify as LibraryKropify;

class SellerController extends Controller
{
    public function login(Request $request){
        $data = [
            'pageTitle'=>'Seller Login'
        ];
        return view('back.pages.seller.auth.login',$data);
    }//end method

    public function register(Request $request){
        $data = [
            'pageTitle'=>'Create Seller Account'
        ];
        return view('back.pages.seller.auth.register',$data);
    }//end method

    public function home(Request $request){
        $data = [
            'pageTitle'=>'Seller Dashboard'
        ];
        return view('back.pages.seller.home',$data);
    }//end method

    public function createSeller(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:sellers',
            'password'=>'min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password'=>'min:5',
        ]);

        $seller = new Seller();
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->password = Hash::make($request->password);
        $saved = $seller->save();

        if( $saved ){
            //generate token
            $token = base64_encode(Str::random(64));

            VerificationToken::create([
                'user_type'=>'seller',
                'email'=>$request->email,
                'token'=>$token
            ]);

            $actionLink = route('seller.verify',['token'=>$token]);
            $data['action_link'] = $actionLink;
            $data['seller_name'] = $request->name;
            $data['seller_email'] = $request->email;

            //send activation link to this seller email
            $mail_body = view('email-templates.seller-verify-template',$data)->render();

            $mailConfig = array(
                'mail_from_email'=>env('MAIL_FROM_ADDRESS'),
                'mail_from_name'=>env('MAIL_FROM_NAME'),
                'mail_recipient_email'=>$request->email,    
                'mail_recipient_name'=>$request->name,
                'mail_subject'=>'Verify Seller account',
                'mail_body'=>$mail_body
            );

            if(sendEmail($mailConfig)){
                return redirect()->route('seller.register-success');
            }else{
                return redirect()->route('seller.register')->with('fail','Something went wrong when sending the verifcation link');
                }
        }else{
            return redirect()->route('seller.register')->with('fail','Something went wrong');

        }
        // dd('Create Seller Account');
    }//end method

    public function verifyAccount(Request $request, $token){
        $verifyToken = VerificationToken::where('token',$token)->first();

        if( !is_null($verifyToken) ){
            $seller = Seller::where('email',$verifyToken->email)->first();

            if( !$seller->verified ){
                $seller->verified = 1;
                $seller->email_verified_at = Carbon::now();
                $seller->save();
                
                return redirect()->route('seller.login')->with('success','Account verified successfully. Login with your credentials and complete setup your seller account.');
            }else{
                return redirect()->route('seller.login')->with('info','Account already verified');
            }
        }else{
            return redirect()->route('seller.register')->with('fail','Invalid token');
        }
    }

    public function registerSuccess(Request $request){
        return view('back.pages.seller.register-success');
    }

    public function loginHandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if( $fieldType == 'email' ){
            $request->validate([
                'login_id'=>'required|email|exists:sellers,email',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or username is required',
                'login_id.email'=>'Email or username is invalid',
                'login_id.exists'=>'Email or username does not exist',
                'password.required'=>'Password is required',
            ]);
        }else{
            $request->validate([
                'login_id'=>'required|email|exists:sellers,username',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or username is required',
                'login_id.exists'=>'Username does not exist',
                'password.required'=>'Password is required',
            ]);
        }

        $creds = array(
            $fieldType=> $request->login_id,
            'password' => $request->password
        );

        if( Auth::guard('seller')->attempt($creds) ){
            //return redirect()->route('seller.home');
            if( !auth('seller')->user()->verified ){
                auth('seller')->logout();
                return redirect()->route('seller.login')->with('fail','Account not verified. Check your email for verification link');
            }else{
                return redirect()->route('seller.home');
            }
        }else{
            return redirect()->route('seller.login')->withInput()->with('fail','Invalid password');
        }
    }//end method

    public function logoutHandler(Request $request){
        Auth::guard('seller')->logout();
        return redirect()->route('seller.login')->with('fail','Logged out successfully');
    }//end method

    public function forgotPassword(Request $request){
        $data = [
            'pageTitle'=>'Forgot Password'
        ];
        return view('back.pages.seller.auth.forgot',$data);
    }

    public function sendPasswordResetLink(Request $request){
        //validate the form
        $request->validate([
            'email'=>'required|email|exists:sellers,email'
        ],[
            'email.required'=>'The :attribute is required',
            'email.email'=>'Email is invalid',
            'email.exists'=>'The :attribute does not exist'
        ]);

        //get seller details
        $seller = Seller::where('email',$request->email)->first();

        //generate token
        $token = base64_encode(Str::random(64));

        //check if there is an existing reset password token for this seller
        $oldToken = DB::table('password_reset_tokens')
                    ->where(['email'=>$seller->email,'guard'=>constGuards::SELLER])
                    ->first();

        if( $oldToken ){
            //update existing token
            DB::table('password_reset_tokens')
                ->where(['email'=>$seller->email,'guard'=>constGuards::SELLER])
                ->update([
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
        }else{
            //insert new reset password token
            DB::table('password_reset_tokens')
                ->insert([
                    'email'=>$seller->email,
                    'token'=>$token,
                    'guard'=>constGuards::SELLER,
                    'created_at'=>Carbon::now()
                ]);
        }

        $actionLink = route('seller.reset-password',['token'=>$token,'email'=>urlencode($seller->email)]);

        $data['actionLink'] = $actionLink;
        $data['seller'] = $seller;
        $mail_body = view('email-templates.seller-forgot-email-template',$data)->render();

        $mailConfig = array(
            'mail_from_email'=>env('MAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('MAIL_FROM_NAME'),
            'mail_recipient_email'=>$seller->email,
            'mail_recipient_name'=>$seller->name,
            'mail_subject'=>'Reset Password',
            'mail_body'=>$mail_body
        );

        if( sendEmail($mailConfig) ){
            return redirect()->route('seller.forgot-password')->with('success','Password reset link sent to your email');
        }else{
            return redirect()->route('seller.forgot-password')->with('fail','Something went wrong');
        }
    }

    public function showResetForm(Request $request, $token = null){
        //check if token exists
        $get_token = DB::table('password_reset_tokens')
                    ->where(['token'=>$token,'guard'=>constGuards::SELLER])
                    ->first();
        
        if( $get_token ){
            //check if this token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s',$get_token->created_at)->diffInMinutes(Carbon::now());

            if( $diffMins > constDefaults::tokenExpiredMinutes ){
                //when token is older than 15 minutes
                return redirect()->route('seller.forgot-password',['token'=>$token])->with('fail','Token expired! Request a new one');
            }else{
                return view('back.pages.seller.auth.reset')->with(['token'=>$token]);
            }
    }else{
        return redirect()->route('seller.forgot-password',['token'=>$token])->with('fail','Invalid token or token expired');
    }
}

public function resetPasswordHandler(Request $request){
    //validate the form
    $request->validate([
        'new_password'=>'required|min:5|max:45|required_with:confirm_password|same:confirm_password',
        'confirm_password'=>'required'
    ]);

    $token = DB::table('password_reset_tokens')
            ->where(['token'=>$request->token,'guard'=>constGuards::SELLER])
            ->first();

    //get seller details
    $seller = Seller::where('email',$token->email)->first();

    //update seller password
    Seller::where('email',$seller->email)->update([
        'password'=>Hash::make($request->new_password)
    ]);

    //delete token record

    DB::table('password_reset_tokens')->where([
        'email'=>$seller->email,
        'token'=>$request->token,
        'guard'=>constGuards::SELLER
    ])->delete();

    //send email to notify seller for new password
    $data['seller'] = $seller;
    $data['new_password'] = $request->new_password;

    $mail_body = view('email-templates.seller-reset-email-template',$data);

    $mailConfig = array(
        'mail_from_email'=>env('MAIL_FROM_ADDRESS'),
        'mail_from_name'=>env('MAIL_FROM_NAME'),
        'mail_recipient_email'=>$seller->email,
        'mail_recipient_name'=>$seller->name,
        'mail_subject'=>'Password Reset Successful',
        'mail_body'=>$mail_body
    );

    sendEmail($mailConfig);
    return redirect()->route('seller.login')->with('success','Done! Your password has been changed. Use new password to login to system.');
}

public function profileView(Request $request){
    $data = [
        'pageTitle'=>'Profile'
    ];
    return view('back.pages.seller.profile',$data);
}

public function changeProfilePicture(Request $request){
    $seller = Seller::findOrFail(auth('seller')->id());
    $path = 'images/users/sellers/';
    $file = $request->file('sellerProfilePictureFile');
    $old_picture = $seller->getAttributes()['picture'];
    $filename = 'SELLER_IMG_'.$seller->id.'.jpg';

    // $upload = Kropify::getFile($file,$path,$filename)->maxWoH(325)->save($path);
    // $infos = $upload->getInfo();
}

}