<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\Status;
use App\Lib\ApiHandler;
use App\Http\Controllers\Controller;
use App\Lib\Intended;
use App\Models\AdminNotification;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        parent::__construct();
    }

    public function showRegistrationForm()
    {
        $pageTitle = "Register";
        Intended::identifyRoute();

        return view('Template::user.auth.register', compact('pageTitle'));
    }

    protected function validator(array $data)
    {

        $passwordValidation = Password::min(6);

        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $agree = 'nullable';
        if (gs('agree')) {
            $agree = 'required';
        }

        $validate = Validator::make($data, [
            'fullname' => 'required',
            //'firstname' => 'required',
            //'lastname' => 'required',
            'username' => 'required|string|unique:users',
            //'email' => 'required|string|email|unique:users',
            'password' => ['required', 'confirmed', $passwordValidation],
            'captcha' => 'sometimes|required',
            'agree' => $agree
        ], [
            //'firstname.required' => 'The first name field is required',
            //'lastname.required' => 'The last name field is required'
        ]);

        return $validate;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }
        $data = $request->all();
        $referBy = $data['refby'] ?? '';
        //session()->get('reference');
        if ($referBy) {
            $referUser = User::where('username', $referBy)->first();
            if (!$referUser) {
                $notify[] = ['error', 'Invalid referral username'];
                return back()->withNotify($notify)->withInput($request->except('password'));
            }
            $data['refby'] = $referUser->id;
        } else {
            $data['refby'] = 0;
        }
 
        event(new Registered($user = $this->create($data)));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function create(array $data)
    {
  
        $userName =  $data['username'];
        //check fullname is set 
        if (isset($data['fullname']) && !empty($data['fullname'])) {
            $nameParts = explode(' ', $data['fullname']);
            $data['firstname'] = $nameParts[0] ?? '';
            $data['lastname'] = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : '';
        } else {
            $data['firstname'] = $data['firstname'] ?? '';
            $data['lastname'] = $data['lastname'] ?? '';
        }

        //User Create
        $user = new User();
        $user->email = strtolower($data['email']);
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->username = str_replace(" ", "-", $userName);
        $user->mobile =  $data['mobile'] ?? null;
        $user->profile_complete = 1;
        $user->dial_code =  $data['mobile_code'] ?? null;
        $user->country_name = $data['country'] ?? null;
        $user->country_code = $data['country_code'] ?? null;
        $user->fast_create_url = $fast_create_url ?? null;
        $user->password = Hash::make($data['password']);
        $user->ref_by = $data['refby'] ??  0;
        $user->kv = gs('kv') ? Status::NO : Status::YES;
        $user->ev = gs('ev') ? Status::NO : Status::YES;
        $user->sv = gs('sv') ? Status::NO : Status::YES;
        $user->ts = Status::DISABLE;
        $user->tv = Status::ENABLE;

        #API Return Fields
        $user->api_user_id = isset($response['data']['id']) ? $response['data']['id'] : "";
        $user->api_login_url = isset($response['data']['fastLoginUrl']) ? $response['data']['fastLoginUrl'] : "";
        $user->user_type = User::USER_TYPE_USER;
        $user->save();
      
        //trigger welcome mail to user
        notify($user, 'DEFAULT', [
            'subject' => 'Welcome to ' . gs('app_name'),
            'message' => 'Hi ' . $data['firstname'] . ' ' . $data['lastname'] . ', Welcome to ' . gs('app_name') . '. Your account has been created successfully. Please login to your account.',
        ], ['email'], createLog: false);
        


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail', $user->id);
        $adminNotification->save();


        //Login Log Create
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        if ($exist) {
            $userLogin->longitude = $exist->longitude;
            $userLogin->latitude = $exist->latitude;
            $userLogin->city = $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country = $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude = @implode(',', $info['long']);
            $userLogin->latitude = @implode(',', $info['lat']);
            $userLogin->city = @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country = @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();


        return $user;
    }

    public function checkUser(Request $request)
    {
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email', $request->email)->exists();
            $exist['type'] = 'email';
            $exist['field'] = 'Email';
        }
        if ($request->mobile) {
            $exist['data'] = User::where('mobile', $request->mobile)->where('dial_code', $request->mobile_code)->exists();
            $exist['type'] = 'mobile';
            $exist['field'] = 'Mobile';
        }
        if ($request->username) {
            $exist['data'] = User::where('username', $request->username)->exists();
            $exist['type'] = 'username';
            $exist['field'] = 'Username';
        }
        return response($exist);
    }

    public function registered()
    {
        return to_route('user.home');
    }
}
