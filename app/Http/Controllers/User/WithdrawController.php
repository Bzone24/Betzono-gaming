<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Lib\ApiHandler;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use App\Models\User;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function withdrawMoney()
    {
        $referredByRole = \App\Models\User::with('referrer')->find(auth()->user()->id)->referrer->user_type??''; 
        if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT || $referredByRole =='AGENT') {
            return to_route('user.withdraw.history');
        }

        $withdrawMethod = WithdrawMethod::active()->get();
        $pageTitle = 'Withdraw Money';
        return view('Template::user.withdraw.methods', compact('pageTitle', 'withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
      
        $referredByRole = \App\Models\User::with('referrer')->find(auth()->user()->id)->referrer->user_type??''; 
        if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT || $referredByRole =='AGENT') {
        
            return to_route('user.withdraw.history');
        }
        

        $request->validate([
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->active()->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount'];
            return back()->withNotify($notify)->withInput($request->all());
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'Insufficient balance for withdrawal'];
            return back()->withNotify($notify)->withInput($request->all());
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;

        if ($afterCharge <= 0) {
            $notify[] = ['error', 'Withdraw amount must be sufficient for charges'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->type = Withdrawal::TYPE_WITHDRAWAL;
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return to_route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
     

        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view('Template::user.withdraw.preview', compact('pageTitle', 'withdraw'));
    }

    public function withdrawSubmit(Request $request)
    {
       

        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();

        $method = $withdraw->method;
        if ($method->status == Status::DISABLE) {
            abort(404);
        }

        $formData = @$method->form->form_data ?? [];

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user, $request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify)->withInput($request->all());
            }
        }

        if ($withdraw->amount > $user->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $withdraw->status = Status::PAYMENT_PENDING;
        $withdraw->withdraw_information = $userData;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = 'Withdraw request via ' . $withdraw->method->name;
        $transaction->trx = $withdraw->trx;
        $transaction->remark = 'withdraw';
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.data.details', $withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount, currencyFormat:false),
            'amount' => showAmount($withdraw->amount, currencyFormat:false),
            'charge' => showAmount($withdraw->charge, currencyFormat:false),
            'rate' => showAmount($withdraw->rate, currencyFormat:false),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance, currencyFormat:false),
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return to_route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog(Request $request)
    {
        $pageTitle = "Withdrawal Log";
        $withdraws = Withdrawal::where('user_id', auth()->id())->where('type','!=','TRANSFER')->where('status', '!=', Status::PAYMENT_INITIATE);
        if ($request->search) {
            $withdraws = $withdraws->where('trx', $request->search);
        }
        $withdraws = $withdraws->with('method')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.withdraw.log', compact('pageTitle', 'withdraws'));
    }

    public function transferMoney(Request $request, $type)
    {
        // if (auth()->user()->user_type != \App\Models\User::USER_TYPE_AGENT) {
        //     return to_route('user.withdraw.history');
        // }

        if($type ==="in" || $type === 'out'){
            $pageTitle = $type === "in" ? 'Withdraw Money from Gamezone' : 'Transfer Money to Gamezone';
            $user      = auth()->user();

            $api = new ApiHandler();

            $data = [
                'username' => $user->username,
                'currency' => gs('cur_text'),
            ];

            // Call the API
            $response = $api->callAPI('api/balance/player', $data, 'POST');

            // Handle the response
            if (isset($response['errorCode'])) {
                $notify[] = ['error', $response['errorMessage']];
                return back()->withNotify($notify)->withInput($request->all());
            }

            $gameZoneBalance = 0;

            if($type ==="in"){
                $gameZoneBalance = isset($response['data']['real']) ? ($response['data']['real']/100) : 0;
            }
            
            return view('Template::user.transfer.transfer', compact('pageTitle', 'user', 'type', 'gameZoneBalance'));
        }

        abort(404);
    }

    public function transferSubmit(Request $request)
    {
        if (auth()->user()->user_type == \App\Models\User::USER_TYPE_AGENT) {
            return to_route('user.withdraw.history');
        }

        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:in,out',
        ]);

        $user = auth()->user();

        if ($request->type === "out" && $request->amount > $user->balance) {
            $notify[] = ['error', 'Insufficient balance for withdrawal'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $api = new ApiHandler();

        if($request->type === "out"){
            $data = [
                'username' => $user->username,
                'amount' => (float) ($request->amount * 100 ),
                'currency' => gs('cur_text'),
            ];

            // Call the API
            $response = $api->callAPI('api/balance/player/deposit', $data, 'POST');

            // Handle the response
            if (isset($response['errorCode'])) {
                $notify[] = ['error', $response['errorMessage']];
                return back()->withNotify($notify)->withInput($request->all());
            }

            $withdraw = new Withdrawal();
            $withdraw->method_id = ""; // wallet method ID
            $withdraw->user_id = $user->id;
            $withdraw->amount = $request->amount;
            $withdraw->currency = gs('cur_sym');
            $withdraw->rate = "";
            $withdraw->charge = "";
            $withdraw->final_amount = $request->amount;
            $withdraw->after_charge = $request->amount;
            $withdraw->status = Status::PAYMENT_SUCCESS; //success
            $withdraw->trx = getTrx();
            $withdraw->type = Withdrawal::TYPE_TRANSFER;
            $withdraw->api_transfer_number = isset($response['data']['transactionId']) ? $response['data']['transactionId'] : "";
            $withdraw->save();
            session()->put('wtrx', $withdraw->trx);

            $user->balance  -=  $withdraw->amount;
            $user->save();


            $transaction = new Transaction();
            $transaction->user_id = $withdraw->user_id;
            $transaction->amount = $withdraw->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = "";
            $transaction->trx_type = '-';
            $transaction->details = 'Transfer Request';
            $transaction->trx = $withdraw->trx;
            $transaction->remark = 'transfer';
            $transaction->type = Transaction::TYPE_USER_TRANSFER_OUT;
            $transaction->save();

            $notify[] = ['success', 'Transfer request sent successfully'];
        }

        if($request->type === "in"){
            $data = [
                'username' => $user->username,
                'amount' => (float) ($request->amount * 100),
                'currency' => gs('cur_text'),
            ];

            // Call the API
            $response = $api->callAPI('api/balance/player/withdraw', $data, 'POST');

            // Handle the response
            if (isset($response['errorCode'])) {
                $notify[] = ['error', $response['errorMessage']];
                return back()->withNotify($notify)->withInput($request->all());
            }

            $user->balance  +=  $request->amount;
            $user->save();


            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $request->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = "";
            $transaction->trx_type = '+';
            $transaction->details = 'Withdraw Request';
            $transaction->trx =  getTrx();
            $transaction->remark = 'withdraw';
            $transaction->type = Transaction::TYPE_USER_WITHDRAW;
            $transaction->save();

            $notify[] = ['success', 'Withdraw request sent successfully'];
        }

        
        return to_route('user.transactions')->withNotify($notify);
    }

    public function manageUser(Request $request, $type, $id)
    {
        $user      = auth()->user();
        $userToManage = User::findOrFail(base64_decode($id));

        if ($type === "add") {
            $pageTitle = 'Add Money';
            $balance = getAmount($user->balance);

            return view('Template::user.transfer.transfertouser', compact('pageTitle', 'user', 'userToManage', 'type', 'balance'));
        }

        if ($type === "withdraw") {
            $pageTitle = "Withdraw Money";
            $balance = getAmount($userToManage->balance);

            return view('Template::user.transfer.transfertouser', compact('pageTitle', 'user', 'userToManage', 'type', 'balance'));
        }

        $notify[] = ['error', 'Wrong request try again'];

        return to_route('user.referred')->withNotify($notify);
    }

    public function manageUserSubmit(Request $request)
    {
        if (auth()->user()->user_type != \App\Models\User::USER_TYPE_AGENT) {
            return to_route('user.withdraw.history');
        }

        $request->validate([
            'amount' => 'required|numeric',
            'user_id' => 'required|numeric|exists:users,id',
            'type' => 'required'
        ]);

        $user = auth()->user();

        $userToManage = User::find($request->input('user_id'));

        if ($request->type === "add" && ($request->amount > $user->balance)) {
            $notify[] = ['error', 'Insufficient balance for adding funds'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        if ($request->type === "withdraw" && ($request->amount > $userToManage->balance)) {
            $notify[] = ['error', 'Insufficient balance for withdrawal'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        // Handle the response
        if (isset($response['errorCode'])) {
            $notify[] = ['error', $response['errorMessage']];
            return back()->withNotify($notify)->withInput($request->all());
        }

        if ($request->type === "add") {
            $this->addFunds($userToManage, $request->amount);
            $notify[] = ['success', 'Funds added successfully'];
        }

        if ($request->type === "withdraw") {
            $this->withdrawFunds($userToManage, $request->amount);
            $notify[] = ['success', 'Funds withdrawal successfull'];
        }

        return to_route('user.referred')->withNotify($notify);
    }

    public function addFunds($userToManage, $amount)
    {
        if (auth()->user()->user_type != \App\Models\User::USER_TYPE_AGENT) {
            return to_route('user.withdraw.history');
        }

        $user = auth()->user();
        //withdraw from agent
        $withdraw = new Withdrawal();
        $withdraw->method_id = ""; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $amount;
        $withdraw->currency = gs('cur_sym');
        $withdraw->rate = "";
        $withdraw->charge = "";
        $withdraw->final_amount = $amount;
        $withdraw->after_charge = $amount;
        $withdraw->status = Status::PAYMENT_SUCCESS; //success
        $withdraw->trx = getTrx();
        $withdraw->type = Withdrawal::TYPE_ADD_FUNDS;
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);

        $user->balance  -=  $withdraw->amount;
        $user->save();


        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = "";
        $transaction->trx_type = '-';
        $transaction->details = 'Added Fund to ' . $userToManage->fullname;
        $transaction->trx = $withdraw->trx;
        $transaction->remark = 'added fund';
        $transaction->other_id = $userToManage->id;
        $transaction->type = Transaction::TYPE_AGENT_SUB_USER_ADD;
        $transaction->save();

        //add funds & transaction to user
        $transaction = new Transaction();
        $trx = getTrx();

        $userToManage->balance += $amount;
        $userToManage->save();

        $transaction->trx_type = '+';
        $transaction->remark = 'balance_add';
        $transaction->user_id = $userToManage->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $userToManage->balance;
        $transaction->charge = 0;
        $transaction->trx =  $trx;
        $transaction->details = "Funds added by " . $user->fullname;
        $transaction->type = Transaction::TYPE_AGENT_ADD;
        $transaction->other_id = $user->id;
        $transaction->save();

        return true;
    }


    public function withdrawFunds($userToManage, $amount)
    {
        if (auth()->user()->user_type != \App\Models\User::USER_TYPE_AGENT) {
            return to_route('user.withdraw.history');
        }

        $user = auth()->user();

        //withdraw from user
        $withdraw = new Withdrawal();
        $withdraw->method_id = ""; // wallet method ID
        $withdraw->user_id = $userToManage->id;
        $withdraw->amount = $amount;
        $withdraw->currency = gs('cur_sym');
        $withdraw->rate = "";
        $withdraw->charge = "";
        $withdraw->final_amount = $amount;
        $withdraw->after_charge = $amount;
        $withdraw->status = Status::PAYMENT_SUCCESS; //success
        $withdraw->trx = getTrx();
        $withdraw->type = Withdrawal::TYPE_ADD_FUNDS;
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);

        $userToManage->balance  -=  $withdraw->amount;
        $userToManage->save();


        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $userToManage->balance;
        $transaction->charge = "";
        $transaction->trx_type = '-';
        $transaction->details = 'Fund withdrawal by ' . $user->fullname;
        $transaction->trx = $withdraw->trx;
        $transaction->remark = 'added withdrawal';
        $transaction->other_id = $user->id;
        $transaction->type = Transaction::TYPE_AGENT_WITHDRAW;
        $transaction->save();

        //add funds & transaction to user
        $transaction = new Transaction();
        $trx = getTrx();

        $user->balance += $amount;
        $user->save();

        $transaction->trx_type = '+';
        $transaction->remark = 'balance_add';
        $transaction->user_id = $user->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx =  $trx;
        $transaction->details = "Funds withdrawal from " . $userToManage->fullname;
        $transaction->other_id = $userToManage->id;
        $transaction->type = Transaction::TYPE_AGENT_ADD_USER_WITHDRAW;
        $transaction->save();

        return true;
    }
}
