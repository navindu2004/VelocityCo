<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\VerificationToken;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

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
}
