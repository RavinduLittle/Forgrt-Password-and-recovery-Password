<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ForgotpasController extends Controller
{
    public function showForgotpasForm()
    {
        return view ('auth.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

          $token = Str::random(64);

          DB::table('password_resets')->insert([
              'email' => $request->email,
              'token' => $token,
              'created_at' => Carbon::now()
            ]);

          Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });

          return back()->with('message', 'We have e-mailed your password reset link!');
      }

      public function showresPasForm($token) {
        return view('auth.forgetPasswordLink', ['token' => $token]);
     }

     public function SubmitrespasForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);

          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email,
                                'token' => $request->token
                              ])
                              ->first();

          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }

          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();

          return redirect('/login')->with('message', 'Your password has been changed!');
      }
}
