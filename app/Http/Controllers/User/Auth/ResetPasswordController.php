<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Lib\ApiHandler;
class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {

        $email = session('fpass_email');
        $token = session()->has('token') ? session('token') : $token;
        if (PasswordReset::where('token', $token)->where('email', $email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return to_route('user.password.request')->withNotify($notify);
        }
        return view('Template::user.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email, 'pageTitle' => 'Reset Password']
        );
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules());
        $reset = PasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        if (!$reset) {
            $notify[] = ['error', 'Invalid verification code'];
            return to_route('user.login')->withNotify($notify);
        }

        //update user password on main site
        $user = User::where('email', $reset->email)->first();
        $api = new ApiHandler();

        $data = [
            'username' => $user->username,
            'password' => $request->password, 
        ];
echo "<pre>";
print_r($data);
        // Call the API
        $response = $api->callAPI('api/players/password/change', $data, 'POST');
echo "<pre>";
print_r($response);die;
        // Handle the response

        if (isset($response['errorCode'])) {
            $notify[] = ['error', $response['errorMessage']];
            return back()->withNotify($notify)->withInput($request->all());
        }



        
        $user->password = Hash::make($request->password);
        $user->save();



        $userIpInfo = getIpInfo();
        $userBrowser = osBrowser();
        notify($user, 'PASS_RESET_DONE', [
            'operating_system' => @$userBrowser['os_platform'],
            'browser' => @$userBrowser['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ],['email']);


        $notify[] = ['success', 'Password changed successfully'];
        return to_route('user.login')->withNotify($notify);
    }


    protected function rules()
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required','confirmed',$passwordValidation],
        ];
    }

}
