<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Lib\Intended;
use App\Models\UserLogin;
use App\Models\User;
use App\Models\SharingUserToken;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Status;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $username;
    public $db_connections;


    public function __construct()
    {
        parent::__construct();
        $this->username = $this->findUsername();
        $this->db_connections = config('constant.db_connections');
    }

    public function showLoginForm(Request $request)
    {
        if($request->from){
           
            session()->put('from',$request->from);
        }
        
        $pageTitle = "Login";
        Intended::identifyRoute();
        return view('Template::user.auth.login', compact('pageTitle'));
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        Intended::reAssignSession();

        return $this->sendFailedLoginResponse($request);
    }

    public function findUsername()
    {
        $login = request()->input('username');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function validateLogin($request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
        //check if email added then redirect with notification
        if($this->username() == 'email'){
            $validator->after(function ($validator) {
                    $validator->errors()->add($this->username(), 'Please enter username to make login');
            
            });
        }
        if ($validator->fails()) {
            Intended::reAssignSession();
            $validator->validate();
        }

    }

    public function logout()
    {
       
        $user = User::find($this->guard()->user()->id);
        if ($user->sharingUserToken()->exists()) {
            $connections = $this->db_connections;
            foreach($connections as $connection_name){
               $this->logoutBetting($user,$connection_name); 
            }
            
        }
          //delete game_url session
        if (session()->has('game_url')) {
            session()->forget('game_url');
        }
        
        $this->guard()->logout();
        request()->session()->invalidate();

        $notify[] = ['success', 'You have been logged out.'];
        return to_route('user.login')->withNotify($notify);
    }


  public function authenticated(Request $request, $user)
    {
        try {
        $user->tv = $user->ts == Status::VERIFIED ? Status::UNVERIFIED : Status::VERIFIED;
        $user->save();
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip',$ip)->first();
        $userLogin = new UserLogin();
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        }else{
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',',$info['long']);
            $userLogin->latitude =  @implode(',',$info['lat']);
            $userLogin->city =  @implode(',',$info['city']);
            $userLogin->country_code = @implode(',',$info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();
        
        //save betting share tokens
        
        $sessionId = auth()->getSession()->getId();
     
         $token =hash('sha256', Str::random(64));
          $user->sharingUserToken()
                ->create([
                    'session_id' =>  $sessionId,
                    'token_used' => true,
                    'status'=>true,
                    'token'=>$token
                ]);
        
        $connections = $this->db_connections;
        foreach($connections as $connection){
             $this->saveSharingUserTokenData($user,$token,$connection);
        }
       
        $from = session()->get('from');
     
     //return to betting 
        if ($from === 'betting' && $token) {
        $baseUrl = config('constant.betting_auto_login_url');
            
        $betting_url =$baseUrl.$token;
        
        return redirect()->away($betting_url);        
                
        }
        
        //return to cricket
        if ($from === 'cricket' && $token) {
        $baseUrl = config('constant.cricket_auto_login_url');
            
        $cricket_url =$baseUrl.$token;
        
        return redirect()->away($cricket_url);        
                
        }
        
       
        $redirection = Intended::getRedirection();
        return $redirection ? $redirection : to_route('user.home');
        } catch (\Exception $e) {
            logger()->error($e);
        }
       
    }

    public function autoLogin($id)
    {
        // Validate if the $id is base64 encoded
        if (!base64_decode($id, true)) {
            return Redirect::back()->with('error', 'Invalid ID format.');
        }

        // Decode the base64 encoded $id
        $decodedId = base64_decode($id);

        // Find the user by the api_user_id
        $user = User::where('username', $decodedId)->first();

        // If no user is found, return an error
        if (!$user) {
            return Redirect::back()->with('error', 'User not found.');
        }

        // If user is found, log them in
        Auth::login($user);

        // Call the authenticated method to save the login record
        $this->authenticated(request(), $user);

        // Redirect to the deposit.index route
        return to_route('user.home')->with('success', 'Logged in successfully.');
        //return redirect()->route('user.deposit.index')->with('success', 'Logged in successfully.');
    }
     private function saveSharingUserTokenData(Object $user,string $token,string $db_connection){
        $user_ = DB::connection($db_connection)->table('users')->where('username', $user->username)->first(['id']);
        if($user_){

            $tokens_data = [
                'session_id' => null,
                'user_id' => $user_->id,
                'token' => $token,
                'token_used' => false,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ];

            DB::connection($db_connection)
            ->table('sharing_user_tokens')
            ->insertOrIgnore($tokens_data);

        }


    }
    
     private function logoutBetting(Object $user,string $db_connection)
    {
        try {
            DB::connection($db_connection)->transaction(function () use ($user,$db_connection) {
                // Get main user and their latest session in one query
                $user_second = DB::connection($db_connection)
                    ->table('users')
                    ->where('username', $user->username)
                    ->first();

                if ($user_second) {
                    $sharing_token = SharingUserToken::where('session_id', auth()->getSession()->getId())->where('token_used', true)->first();

                    // Get  The Main Table sharing token 
                    $user_second_token =   DB::connection($db_connection)
                        ->table('sharing_user_tokens')
                        ->where('token', $sharing_token->token)
                        ->where('token_used', true)
                        ->first();
                    if ($user_second_token) {
                        // Delete the latest session in one query without fetching it
                        DB::connection($db_connection)
                            ->table('sessions')
                            ->where('id', $user_second_token->session_id)
                            ->where('user_id', $user_second->id)
                            ->delete();

                        // Delete sharing user tokens
                        $sharing_token->delete();

                        DB::connection('mysql_secondary')
                            ->table('sharing_user_tokens')->where('id', $user_second_token->id)->delete();
                    }
                }
            });
        } catch (\Exception $e) {
            logger()->error($e);
        }
    }
    
    
    //     private function saveBettingSharingUserToken(Object $user,string $token){
    //      $betting_user = DB::connection('mysql_secondary')->table('users')->where('username',$user->username)->first(['id']);
                   
    //               if($betting_user)
    //              {
                      
    //                 $tokens_data_for_betting=[
    //                   'session_id'=>null,
    //                   'user_id'=>$betting_user->id,
    //                   'token'=>$token,
    //                   'token_used'=>false,
    //                   'status'=>true,
    //                   'created_at'=>now(),
    //                   'updated_at'=>now()
    //                   ];
              
                  
    
    //                  DB::connection('mysql_secondary')
    //                     ->table('sharing_user_tokens')
    //                     ->insertOrIgnore($tokens_data_for_betting);
    //              }
    // }
    
    
    //   private function logoutBetting($user)
    // {
    //     try{
    //         DB::connection('mysql_secondary')->transaction(function () use ($user) {
    //         // Get main user and their latest session in one query
    //         $betting_user = DB::connection('mysql_secondary')
    //             ->table('users')
    //             ->where('username', $user->username)
    //             ->first();

    //         if ($betting_user) {
    //             $sharing_token = SharingUserToken::where('session_id', auth()->getSession()->getId())->where('token_used', true)->first();

    //             // Get  The Main Table sharing token 
    //             $betting_user_token =   DB::connection('mysql_secondary')
    //                 ->table('sharing_user_tokens')
    //                 ->where('token', $sharing_token->token)
    //                 ->where('token_used', true)
    //                 ->first();
    //             if ($betting_user_token) {
    //                 // Delete the latest session in one query without fetching it
    //                 DB::connection('mysql_secondary')
    //                     ->table('sessions')
    //                     ->where('id', $betting_user_token->session_id)
    //                     ->where('user_id', $betting_user->id)
    //                     ->delete();

    //                 // Delete sharing user tokens
    //                 $sharing_token->delete();

    //                 DB::connection('mysql_secondary')
    //                 ->table('sharing_user_tokens')->where('id',$betting_user_token->id)->delete();
    //             }
    //         }
    //     });
    //     }catch(\Exception $e){
    //         logger()->error($e);
    //     }
       
    // }
    

}
