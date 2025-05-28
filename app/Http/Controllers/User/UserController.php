<?php

namespace App\Http\Controllers\User;

use App\Models\Form;
use App\Models\User;
use App\Models\Ticket;
use App\Lib\ApiHandler;
use App\Models\Referral;
use App\Constants\Status;
use App\Lib\FormProcessor;
use App\Models\Withdrawal;
use App\Models\DeviceToken;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\CommissionLog;
use Illuminate\Validation\Rule;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public $sportsPartnerId = 'stakeeye';
    public $xApp = '6E28048F-D891-4AF5-A296-D9C91C39DE7D';
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user      = auth()->user();
        $tickets   = [];// Ticket::where('user_id', auth()->user()->id)->where('status', Status::UNPUBLISHED)->latest('id')->with('lottery', 'phase')->paginate(getPaginate());

        return view('Template::user.dashboard', compact('pageTitle', 'user', 'tickets'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function transferHistory(Request $request)
    {
        $pageTitle = "Transfer Log";
        $withdraws = Withdrawal::where('user_id', auth()->id())->where('type', 'TRANSFER')->where('status', '!=', Status::PAYMENT_INITIATE);
        if ($request->search) {
            $withdraws = $withdraws->where('trx', $request->search);
        }
        $withdraws = $withdraws->with('method')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.transfer_history', compact('pageTitle', 'withdraws'));
    }

    public function gamezoneHistory(Request $request)
    {
        $pageTitle = "Gamezone Transfer Log";
        $withdraws = Withdrawal::where('user_id', auth()->id())->where('type', 'TRANSFER')->where('status', '!=', Status::PAYMENT_INITIATE);
        if ($request->search) {
            $withdraws = $withdraws->where('trx', $request->search);
        }
        $withdraws = $withdraws->with('method')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.gamezone_history', compact('pageTitle', 'withdraws'));
    }




    public function show2faForm()
    {
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Security';
        return view('Template::user.profile.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $userId = auth()->id();
        if ($request->input('referral_user')) {
            $referralUser = User::where('username', $request->input('referral_user'))->first();
            if ($referralUser) {
                $userId = $referralUser->id;
            } else {
                $notify[] = ['error', 'Referral user not found'];
                return back()->withNotify($notify);
            }
        }
        

        $transactions = Transaction::where('user_id', $userId)->searchable(['trx'])->filter(['trx_type','remark'])->orderBy('id', 'desc')->paginate(getPaginate());

        $user = auth()->user();
        
        $referrals = User::where('ref_by', $user->id)->orderBy('id', 'DESC')->paginate(getPaginate());



        return view('Template::user.transactions', compact('pageTitle', 'transactions', 'remarks', 'referrals', 'user'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == Status::KYC_PENDING) {
            $notify[] = ['error','Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = ['error','You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act', 'kyc')->first();
        return view('Template::user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view('Template::user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->firstOrFail();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $user = auth()->user();
        foreach (@$user->kyc_data ?? [] as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
            }
        }
        $userData = $formProcessor->processFormData($request, $formData);
        $user->kyc_data = $userData;
        $user->kyc_rejection_reason = null;
        $user->kv = Status::KYC_PENDING;
        $user->save();

        $notify[] = ['success','KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function userData()
    {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $pageTitle  = 'User Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request)
    {

        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile' => [
                'required',
                'regex:/^([0-9]*)$/',
                Rule::unique('users')
                    ->where('dial_code', $request->mobile_code)
                    ->ignore($user->id, 'id'),
            ]
        ]);


        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->country_name = @$request->country;
        $user->dial_code = $request->mobile_code;

        $user->profile_complete = Status::YES;
        $user->save();

        return redirect()->back()->withInput();
    }

    public function createUser(Request $request)
    {
        $pageTitle = "Create User";
        $user = auth()->user();

        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.create.form', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function createUserSubmit(Request $request)
    {

        $loggedInUser = auth()->user();

        $passwordValidation = Password::min(6);

        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $countryData  = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'password' => ['required', 'confirmed', $passwordValidation],
            'username'     => 'required|unique:users|min:6',
            'mobile' => [
                'required',
                'regex:/^([0-9]*)$/',
                Rule::unique('users')
                    ->where('dial_code', $request->mobile_code),
            ]
        ]);
/*
        $api = new ApiHandler();

        $data = [
            'username' =>  "b".$request->mobile,
            'password' => $request->password,
            'currency' => gs('cur_text'),
            'firstName' => $request->firstname,
            'lastName' => $request->lastname,
            'email' => $request->email,
            'phoneNumber' => $request->mobile_code . $request->mobile,
            "tempPasswordReset" => false,
        ];

        // Call the API
        $response = $api->callAPI('api/players/fastcreate', $data, 'POST');

        // Handle the response

        if (isset($response['errorCode'])) {
            $notify[] = ['error', $response['errorMessage']];
            return back()->withNotify($notify)->withInput($request->all());
        }else{

            $fast_create_url = $response['data']['fastLoginUrl'];
        }
*/
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->country_name = @$request->country;
        $user->dial_code = $request->mobile_code;
        $user->user_type = User::USER_TYPE_USER;
        $user->fast_create_url = null;
        $user->profile_complete = Status::YES;
        $user->ref_by = $loggedInUser->id;

        $user->ev = $request->ev ? Status::VERIFIED : Status::UNVERIFIED;
        $user->sv = $request->sv ? Status::VERIFIED : Status::UNVERIFIED;
        $user->ts = $request->ts ? Status::ENABLE : Status::DISABLE;
        if (!$request->kv) {
            $user->kv = Status::KYC_UNVERIFIED;

            if ($user->kyc_data) {
                foreach ($user->kyc_data as $kycData) {
                    if ($kycData->type == 'file') {
                        fileManager()->removeFile(getFilePath('verify') . '/' . $kycData->value);
                    }
                }
            }
            $user->kyc_data = null;
        } else {
            $user->kv = Status::KYC_VERIFIED;
        }

        $user->save();

        $notify[] = ['success', 'User added successfully'];
        return to_route('user.referred')->withNotify($notify);
    }

    

    public function addDeviceToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();

        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
    }

    public function downloadAttachment($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title = slug(gs('site_name')) . '- attachments.' . $extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error','File does not exists'];
            return back()->withNotify($notify);
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function commissions(Request $request)
    {
        $pageTitle   = 'Commissions';
        $commissions = CommissionLog::where('to_id', auth()->user()->id)->orderBy('id', 'desc')->with('userFrom')->searchable(['trx'])->filter(['commission_type'])->paginate(getPaginate());


        return view('Template::user.referral.commissions', compact('pageTitle', 'commissions'));
    }

    public function referredUsers(Request $request)
    {
        $pageTitle = 'Referrals';
        $user = auth()->user();
        $referrals = User::where('ref_by', $user->id)->orderBy('id', 'DESC')->paginate(getPaginate());

        return view('Template::user.referral.referred', compact('pageTitle', 'referrals'));
    }

    public function updateReferalStatus($userid, $action)
    {
        //check user is in referral list
        $referral = User::where('ref_by', auth()->user()->id)->where("id", $userid)->first();
        if (!$referral) {
            $notify[] = ['error', 'You are not permitted to access this'];
            return back()->withNotify($notify);
        }
        $user = User::findOrFail($userid);
        if ($action == 'block') {
            $user->status = 0;
            $user->save();
            $notify[] = ['success', 'User blocked successfully'];
        } else {
            $user->status = 1;
            $user->save();
            $notify[] = ['success', 'User unblocked successfully'];
        }
        return back()->withNotify($notify);
    }


    public function sportsGame()
    {
        $pageTitle = 'Sports Game';
        $user = auth()->user();
        //if not loggedin redirect to login page
        if (!$user) {
            $notify[] = ['error', 'Please login to access this page'];
            return redirect()->route('user.login')->withNotify($notify);
        }
        //check game url is available in session
        
        $request = new \Illuminate\Http\Request([
            'partnerId'      => $this->sportsPartnerId,
            'Username'       => $user->username,
            'isDemo'         => false,
            'isBetAllow'     => true,
            'isActive'       => true,
            'point'          => 1,
            'isDarkTheme'    => true,
            'sportName'      => 'Cricket',
            'event'          => '',
        ]);
        $request->headers->set('x-app', $this->xApp);
        $response = app(\App\Http\Controllers\SportsApiController::class)->ClientAuthentication($request);
        $data = json_decode($response->getContent(), true);

        if (isset($data['gameURL'])) {
            $gameUrl = $data['gameURL'];
        }
        return view('Template::user.sports')->with('gameUrl', $gameUrl)->with('pageTitle', $pageTitle);
    }
}
