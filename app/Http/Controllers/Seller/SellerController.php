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
                'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
                'mail_from_name'=>env('EMAIL_FROM_NAME'),
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

    public function registerSuccess(Request $request){
        return view('back.pages.seller.register-success');
    }
}
