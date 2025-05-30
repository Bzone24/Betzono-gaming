<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        $pageTitle = "Account Recovery";
        return view('Template::user.auth.passwords.email', compact('pageTitle'));
    }

    public function showUsernameLinkRequestForm()
    {
        $pageTitle = "Username Recovery";
        return view('Template::user.auth.username.email', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate([
            'value' => 'required'
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $fieldType = $this->findFieldType();
        if ($fieldType == 'email') {
            $notify[] = ['error','Please enter the username'];
            return back()->withNotify($notify);
        }
                $user = User::where($fieldType, $request->value)->first();

        if (!$user) {
            $notify[] = ['error', 'The account could not be found'];
            return back()->withNotify($notify);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new PasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
        notify($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ], ['email']);

        $email = $user->email;
        session()->put('pass_res_mail', $email);
        session()->put('pass_res_username', $user->username);
        $notify[] = ['success', 'Password reset email sent successfully'];
        return to_route('user.password.code.verify')->withNotify($notify);
    }

    public function sendUsernameResetCodeEmail(Request $request)
    {
        $request->validate([
            'value' => 'required'
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $fieldType = $this->findFieldType();
        if ($fieldType != 'email') {
            $notify[] = ['error','Please enter the email'];
            return back()->withNotify($notify);
        }
                $user = User::where($fieldType, $request->value)->first();

        if (!$user) {
            $notify[] = ['error', 'The account could not be found'];
            return back()->withNotify($notify);
        }
 
        $code = verificationCode(6);
         

        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
        notify($user, 'USERNAME_RECOVER_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ], ['email']);

        $email = $user->email;
        session()->put('username_recover_mail', $email); 
        session()->put('username_recover_code', $code);
        $notify[] = ['success', 'Username reset email sent successfully'];
        return to_route('user.username.code.verify')->withNotify($notify);
    }

    
    public function findFieldType()
    {
        $input = request()->input('value');

        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $input]);
        return $fieldType;
    }

    public function codeVerify(Request $request)
    {
        $pageTitle = 'Verify Email';

      /*  $email = $request->session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error','Oops! session expired'];
            return to_route('user.password.request')->withNotify($notify);
        }*/

        $username = session()->get('pass_res_username');
        if (!$username) {
            $notify[] = ['error', 'Oops! session expired'];
            return to_route('user.password.request')->withNotify($notify);
        }
        //get user email from username
        $user = User::where('username', $username)->first();
        if (!$user) {
            $notify[] = ['error', 'The account could not be found'];
            return to_route('user.password.request')->withNotify($notify);
        }
        $email = $user->email;
        return view('Template::user.auth.passwords.code_verify', compact('pageTitle', 'email'));
    }


    public function codeUserVerify(Request $request)
    {
        $pageTitle = 'Verify Email';

        $email = $request->session()->get('username_recover_mail');
        if (!$email) {
            $notify[] = ['error','Oops! session expired'];
            return to_route('user.username.request')->withNotify($notify);
        }

        
        //get user email from username
        $user = User::where('email', $email)->first();
        if (!$user) {
            $notify[] = ['error', 'The account could not be found'];
            return to_route('user.username.request')->withNotify($notify);
        }
        $email = $user->email;
        return view('Template::user.auth.username.code_verify', compact('pageTitle', 'email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required'
        ]);
        $code =  str_replace(' ', '', $request->code);

        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = ['error', 'Verification code doesn\'t match'];
            return to_route('user.password.request')->withNotify($notify);
        }
        $notify[] = ['success', 'You can change your password'];
        session()->flash('fpass_email', $request->email); 
        return to_route('user.password.reset', $code)->withNotify($notify);
    }
    public function verifyUserCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required'
        ]);
         $code =  str_replace(' ', '', $request->code);
     
        if(session()->get('username_recover_code') != $code){
            $notify[] = ['error', 'Verification code doesn\'t match'];
            return to_route('user.username.request')->withNotify($notify);
        }
        
       
        //fetch username from users using email
        $user = User::where('email', $request->email)->first();
        $users = User::where('email', $request->email)->get();
        $usernames = '';
        foreach ($users as $u) {
            $usernames .= $u->username;
            $usernames .= ', ';

        }
        $usernames = rtrim($usernames, ', '); //remove last comma and space
        //trigger mail on same mail , add these usernames in mail
       
        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
        notify($user, 'USERNAME_RECOVER', [
            'code' => $code,
            'usernames' => $usernames,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ], ['email']);
       
        session()->put('username_recover_code', null);
        session()->put('username_recover_mail', null);
        $notify[] = ['success', 'We have shared usernames on your email address'];
        return to_route('user.username.request', $code)->withNotify($notify);
    }
    
}
