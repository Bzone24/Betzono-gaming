<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class SportsApiController extends Controller
{
     
    //set x-app in variable
    protected $xApp = 'CED86870-A667-450F-B5D1-5EE7717324EA';
    //set partner id in variable
    protected $allowedParentIds = ['stakeyedemo'];
    //set vendor url
    protected $authenticationUrl = 'https://stakeyeapi.powerplay247.com/api/Iframe/ClientAuthentication';

    public function __construct()
    {
        //check request have header x-app and x-app value = 'CED86870-A667-450F-B5D1-5EE7717324EA'
        $this->middleware(function ($request, $next) {
            if ($request->header('x-app') !== $this->xApp) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $next($request);
        });
    }
    /**
     * Get Balance
     */
    public function getBalance(Request $request)
    {
        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'Username'   => 'required|string',
            'PartnerId'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'data' => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 400);
        }
        
        $user = User::where('Username', $request->Username)->first();

        if (!$user) {
            return response()->json([
                'status' => 422,
                'data' => 0.00,
                'errorMessage' => 'Invalid user',
            ], 404);
        }

        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                'status' => 422,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid partner id',
            ], 401);
        }

        return response()->json([
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'status' => 100,
            'errorMessage' => 'Success'
        ], 200);
    }
    //fetch gameurl
    public function ClientAuthentication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'partnerId'      => 'required|string',
            'Username'       => 'required|string',
            'isDemo'       => 'nullable|boolean',
            'isBetAllow'      => 'required|boolean',
            'isActive'       => 'required|boolean',
            'point' => 'required|numeric',
            'isDarkTheme'      => 'required|boolean',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'data' => 0.00,
                'errorMessage' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        }
        // Check if the user exists
        DB::beginTransaction();
        
        try {
            $user = User::where('Username', $request->Username)->first();

            if (!$user) {
                return response()->json([
                'status' => 104,
                'data' => 0.00,
                'errorMessage' => 'User account does not exist',
                ], 404);
            }

            if (!in_array($request->partnerId, $this->allowedParentIds)) {
                return response()->json([
                'status' => 109,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid partnerId',
                ], 401);
            }

            //call api
           
            $params = [
            'partnerId' => $request->partnerId,
            'Username' => $request->Username,
            'isDemo' => $request->isDemo ?? false,
            'isBetAllow' => $request->isBetAllow,
            'isActive' => $request->isActive,
            'point' => $request->point ?? 1,
            'isDarkTheme' => $request->isDarkTheme ?? false,
            'sportName' => $request->sportName ?? "Cricket",
            "event" => "",
            ];
            // Initialize cURL
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->authenticationUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($params),
                CURLOPT_HTTPHEADER => array(
                    'X-App: ' . $this->xApp,
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseData = json_decode($response, true);
            if ($responseData['status'] != 100) {
                return response()->json([
                'status' => $responseData['status'],
                'errorMessage' => $responseData['errorMessage'],
                ], 400);
            }
            $returnUrl = $responseData['data']['url'] ?? null;
            //if game url is empty then return error
            if (empty($returnUrl)) {
                return response()->json([
                'status' => 102,
                'errorMessage' => 'Url not available.',
                ], 400);
            }
            // Save login history
            DB::table('login_history')->insert([
            'Username'      => $request->Username,
            'agentCode'     => $request->partnerId,
            'tpGameId'      => $request->tpGameId ?? null,
            'tpGameTableId' => $request->tpGameTableId ?? null,
            'firstName'     => $user->firstname,
            'lastName'      => $user->lastname,
            'isAllowBet'    => $request->isBetAllow,
            'isDemoUser'    => $request->isDemo,
            'returnUrl'     => $returnUrl,
            'type' => 'sports',
            'status'        => 0, // Assuming 0 means success
            'created_at'    => now(),
            'updated_at'    => now(),
            ]);

        
            DB::commit();

            return response()->json([
            'agentCode' => $request->partnerId,
            'Username' => $user->Username,
            'gameURL' => $returnUrl ?? '',
            'status' => "0",
            'errorMessage' => 'Success',
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => 106,
                'errorMessage' => 'An unexpected error occurred',
                'errorDetails' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ] ?? null,
            ], 500);
        }
    }

 /**
 * Place a bet for casino games
 */
    public function placeBet(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'Username'          => 'required|string',
        'PartnerId'         => 'required|string',
        'TransactionID'     => 'required|string',
        'TransactionType'   => 'required|integer',
        'Amount'            => 'required|numeric|min:0.01',
        'Eventtypename'           => 'required|string',
        'Competitionname'           => 'required|string',
        'Eventname'           => 'required|string',
        'Marketname'           => 'required|string',
        'Markettype'          => 'required|integer',
        'MarketID'         => 'required|integer',
        'Runnername'           => 'required|string',
        'RunnerID'          => 'required|integer',
        'BetType'             => 'required|integer',
        'Rate'             => 'required|numeric',
        'Stake'            => 'required|numeric',
        'isBetMatched'            => 'required|boolean',
        'Point'     => 'required|integer',
        'SessionPoint'         => 'nullable|numeric',
        ]);
 
        if ($request->Amount < 0.01) {
            return response()->json([
            'status'       => 422,
            'data' => 0,
            'errorMessage' => 'Invalid amount',
            ], 400);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('amount') && in_array('Invalid Amount', $errors->get('amount'))) {
                return response()->json([
                    'status'       => 422,
                    'data' => 0.00,
                    'errorMessage' => 'Invalid Amount',
                ], 400);
            }

            return response()->json([
            'status'       => 422,
            'data' => 0.00,
            'errorMessage' => 'Validation Error',
            'errors'       => $validator->errors(),
            ], 400);
        }

        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
                'status'       => 422,
                'data' => 0.00,
                'errorMessage' => 'User not found',
            ], 404);
        }

        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
             'status'       => 422,
             'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
             'errorMessage' => 'Invalid partnerId',
            ], 401);
        }

        // Only check if exact same transaction already placed
        $exists = DB::table('sports_bets_history')
        ->where('transactionId', $request->TransactionID)
        ->where('methodName', 'placebet')
        ->exists();

        if ($exists) {
            return response()->json([
                'status'       => 422,
               'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid Request',
            ], 400);
        }

        if ($user->balance < $request->Amount) {
            return response()->json([
                'status'       => 422,
               'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'errorMessage' => 'Insufficient balance',
            ], 400);
        }

        $type = strtoupper(trim($request->transactionType)); // 💥 Ensure upper case

        DB::beginTransaction();
        try {
            if ($type === 2) {
                $user->increment('balance', $request->Amount);
                $trxType = '+';
            } else {
                $user->decrement('balance', $request->Amount);
                $trxType = '-';
            }

            // 💾 Save to cache
            Cache::put('bet_transaction_type_' . $request->transactionId, $type, now()->addHours(24));

 
            // ✅ Insert into DB
            DB::table('sports_bets_history')->insert([
                'Username'           => $request->Username,
                'partnerId'          => $request->PartnerId,
                'transactionId'      => $request->TransactionID,
                'transactionType'    => $request->TransactionType == 2 ? 'Credit' : 'Debit',
                'amount'             => $request->Amount,
                'eventTypeName'      => $request->Eventtypename,
                'competitionName'    => $request->Competitionname,
                'eventName'          => $request->Eventname,
                'marketName'         => $request->Marketname,
                'marketType'         => $request->Markettype,
                'marketId'           => $request->MarketID,
                'runnerName'         => $request->Runnername,
                'runnerId'           => $request->RunnerID,
                'betType'            => $request->BetType,
                'rate'               => $request->Rate,
                'stake'              => $request->Stake,
                'isBetMatched'       => $request->isBetMatched,
                'point'              => $request->Point,
                'sessionPoint'       => $request->SessionPoint,
                'methodName' => 'placebet',
                'status'             => 'placed',
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);




            // 💰 Transaction log
            $trx = new Transaction();
            $trx->user_id = $user->id;
            $trx->amount = $request->Amount;
            $trx->charge = 0;
            $trx->post_balance = $user->balance;
            $trx->trx_type = $trxType;
            $trx->trx = $request->TransactionID;
            $trx->details = 'Sport game - ' . ($type === 'DR' ? 'Debit' : 'Credit');
            $trx->remark = ($type === 'DR' ? 'balance_subtract' : 'balance_add');
            $trx->type = Transaction::TYPE_USER_BET_SPORTSGAME;
            $trx->created_at = now();
            $trx->updated_at = now();
            $trx->save();

            DB::commit();

            return response()->json([
                'status'       => 100,
                'data' => $user->balance,
                'errorMessage' => 'Success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('PlaceBet Error: ' . $e->getMessage());
            return response()->json([
            'status' => 422,
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'errorMessage' => 'Bet Failed',
            ]);
        }
    }


/**
 * Cancel a previously placed bet
 */
    public function CancelBet(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'Username'          => 'required|string',
        'PartnerId'         => 'required|string',
        'TransactionID'     => 'required|string',
        'TransactionType'   => 'required|integer',
        'Amount'            => 'required|numeric|min:0.01',
        'Eventtypename'           => 'required|string',
        'Competitionname'           => 'required|string',
        'Eventname'           => 'required|string',
        'Marketname'           => 'required|string',
        'Markettype'          => 'required|integer',
        'MarketID'         => 'required|integer',
        'Runnername'           => 'required|string',
        'RunnerID'          => 'required|integer',
        'BetType'             => 'required|integer',
        'Rate'             => 'required|numeric',
        'Stake'            => 'required|numeric',
        'isBetMatched'            => 'required|boolean',
        'Point'     => 'required|integer',
        'ReverseTransactionId'         => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
            'status'       => 422,
            'data' => 0.00,
            'errorMessage' => 'Validation Error',
            'errors'       => $validator->errors(),
            ], 400);
        }

        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
            'status'       => 422,
            'data' => 0.00,
            'errorMessage' => 'User not found',
            ], 404);
        }

        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
            'status'       => 422,
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'errorMessage' => 'Invalid partnerId',
            ], 401);
        }

        // ✅ Original bet must exist
        $originalBet = DB::table('sports_bets_history')
        ->where('transactionId', $request->ReverseTransactionId)
        ->where('Username', $request->Username)
        ->where('partnerId', $request->PartnerId)
        ->where('methodName', 'placebet')
        ->first();

        if (!$originalBet) {
            return response()->json([
            'status'       => 422,
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'errorMessage' => 'Invalid Request',
            ], 400);
        }

        // ✅ Amount must match
        if ($request->Amount != $originalBet->amount) {
            return response()->json([
            'status'       => 422,
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'errorMessage' => 'Amount mismatch',
            ], 400);
        }

        // ✅ Check if already cancelled using reversetransactionId
        $alreadyCancelled = DB::table('sports_bets_history')
        ->where('methodName', 'cancelbet')
        ->where('Username', $request->Username)
        ->where('partnerId', $request->PartnerId)
        ->where('ReverseTransactionId', $request->ReverseTransactionId)
        ->exists();

        if ($alreadyCancelled) {
            return response()->json([
            'status'       => 422,
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'errorMessage' => 'Bet already cancelled',
            ], 400);
        }

        // ✅ Don't allow if already settled
        $settled = DB::table('sports_game_settlements_history')
        ->where('Username', $request->Username)
        ->where('partnerId', $request->PartnerId)
        ->where('transactionId', $request->ReverseTransactionId)
        ->exists();

        if ($settled) {
            return response()->json([
            'status'       => 422,
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'errorMessage' => 'Bet already settled',
            ], 400);
        }

        // ✅ Determine original transaction type
        $originalType = null;
        if (!empty($originalBet->TransactionType)) {
            $originalType = strtoupper(trim($originalBet->TransactionType == 2 ? 'CR' : 'DR'));
        } elseif (Cache::has('bet_transaction_type_' . $request->ReverseTransactionId)) {
            $originalType = strtoupper(trim(Cache::get('bet_transaction_type_' . $request->ReverseTransactionId)));
        } else {
            $originalType = 'DR'; // default if nothing found
        }
        DB::beginTransaction();
        try {
            if ($originalType === 'CR') {
                  $user->decrement('balance', $request->Amount);
                  $trxType = '-';
            } else {
                 $user->increment('balance', $request->Amount);
                 $trxType = '+';
            }
             
            DB::table('sports_bets_history')->insert([
            'Username'           => $request->Username,
            'partnerId'          => $request->PartnerId,
            'transactionId'      => $request->TransactionID,
            'transactionType'    => $request->TransactionType == 2 ? 'Credit' : 'Debit',
            'amount'             => $request->Amount,
            'eventTypeName'      => $request->Eventtypename,
            'competitionName'    => $request->Competitionname,
            'eventName'          => $request->Eventname,
            'marketName'         => $request->Marketname,
            'marketType'         => $request->Markettype,
            'marketId'           => $request->MarketID,
            'runnerName'         => $request->Runnername,
            'runnerId'           => $request->RunnerID,
            'betType'            => $request->BetType,
            'rate'               => $request->Rate,
            'stake'              => $request->Stake,
            'isBetMatched'       => $request->isBetMatched,
            'point'              => $request->Point,
            'sessionPoint'       => $request->SessionPoint,
            'ReverseTransactionId' => $request->ReverseTransactionId,
            'status'             => 'cancelbet',
            'methodName' => 'cancelbet',
            'created_at'         => now(),
            'updated_at'         => now(),

            ]);
 
             $trx = new Transaction();
             $trx->user_id = $user->id;
             $trx->amount = $request->Amount;
             $trx->charge = 0;
             $trx->post_balance = $user->balance;
             $trx->trx_type = $trxType;
             $trx->trx = $request->transactionId;
             $trx->details = 'Bet cancellation adjustment';
             $trx->remark = 'cancelbet';
             $trx->type = Transaction::TYPE_USER_BET_SPORTSGAME;
             $trx->created_at = now();
             $trx->updated_at = now();
             $trx->save();

             // Cleanup cache
             Cache::forget('bet_transaction_type_' . $request->ReverseTransactionId);

             DB::commit();

             return response()->json([
                'status'               => 100,
                'data'              => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage'         => 'Bet cancelled successfully',
             ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('CancelBet Error: ' . $e->getMessage());

            return response()->json([
            'status'       => 422,
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'errorMessage' => 'Cancel failed: ' . $e->getMessage(),
            ], 500);
        }
    }
/**
 * Market Cancel
 */
    public function marketCancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Username'           => 'required|string',
            'PartnerId'          => 'required|string',
            'TransactionID'            => 'required|string',
            'Markettype'           => 'required|integer',
            'MarketID'          => 'required',
            'TransactionType'           => 'required',
            'Amount'             => 'required|numeric|min:0'
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('amount') && in_array('Invalid Amount', $errors->get('amount'))) {
                return response()->json([
                  'status'       => 422,
                'data' => 0.00,
                    'errorMessage' => 'Invalid Amount',
                ], 400);
            }

            return response()->json([
               'status'       => 422,
                'data' => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
              'status'       => 422,
            'data' => 0.00,
                'errorMessage' => 'User not found',
            ], 404);
        }
    
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
             'status'       => 422,
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid partnerId',
            ], 401);
        }
  
    
        // Check for transaction ID to prevent duplicate cancellations
        $transactionId = Str::uuid()->toString();
    
         DB::beginTransaction();
        try {
            // Check if already canceled
            // Check market already cancelled

              // Check if bet exists
            $bet = DB::table('sports_bets_history')->where([
                'partnerId' => $request->PartnerId,
                'userName'      => $request->Username,
                'marketId'     => $request->MarketID,
            ])->first();
    
            if (!$bet) {
                return response()->json([
                'status'       => 422,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                   'errorMessage' => 'Invalid Request',
                ], 400);
            }


             //check already cancel
             $alreadyCanceled = DB::table('sports_bets_history')->where([
                'partnerId' => $request->PartnerId,
                'userName'      => $request->Username,
                'marketId'     => $request->MarketID,
                'status'       => 'cancelbet',
             ])->exists();
 
            if ($alreadyCanceled) {
                return response()->json([
                   'status'       => 422,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Bet already canceled',
                ], 400);
            }
 
          
        
            // Get settlement data if exists
            $settlement = DB::table('sports_game_settlements_history')->where([
                'partnerId' => $request->PartnerId,
                'userName'  => $request->Username,
                'marketId'   => $request->MarketID
            ])
             ->where('methodName', '!=', 'cancelsettledgame')
             ->first();
            
             // Get placed bet data
             $placedBet = DB::table('sports_bets_history')->where([
                'partnerId' => $request->PartnerId,
                'userName'  => $request->Username,
                'marketId'   => $request->MarketID
             ])
             ->first();
            
             // Validate amount matches
            if ($placedBet && $placedBet->amount != $request->Amount) {
                return response()->json([
                  'status'       => 422,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Invalid Amount',
                ], 400);
            }
            
            // If neither bet nor settlement exists, return error
            if (!$settlement && !$placedBet) {
                  return response()->json([
                'status'       => 422,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'No valid bet or settlement found for cancellation',
                  ], 400);
            }
            
            // Calculate correction amount
            $betAmount = $placedBet->amount ?? 0;
            $payoffAmount = $settlement->payableAmount ?? 0;
            $correctionAmount = $payoffAmount - $betAmount;
            
            // Apply balance correction
            if ($correctionAmount > 0) {
                 // If player won money, we need to take it back
                 $user->decrement('balance', $correctionAmount);
                 $trx_type = '-';
            } elseif ($correctionAmount < 0) {
                // If player lost money, we need to return it
                $user->increment('balance', abs($correctionAmount));
                $trx_type = '+';
            } else {
                // No change needed
                $trx_type = '=';
            }
     
         // Refresh user to get updated balance
            $user->refresh();
    
            // Record transaction if balance was changed
            if ($correctionAmount != 0) {
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = abs($correctionAmount);
                $transaction->charge = 0;
                $transaction->post_balance = $user->balance;
                $transaction->trx_type = $trx_type;
                $transaction->trx = $transactionId;
                $transaction->details = 'Market cancellation balance adjustment';
                $transaction->remark = 'cancel_market';
                $transaction->type = Transaction::TYPE_USER_BET_SPORTSGAME;
                $transaction->created_at = now();
                $transaction->updated_at = now();
                $transaction->save();
            }
    
            DB::commit();
    
            return response()->json([
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'status'       => 100,
                'errorMessage' => 'Success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
             'status'       => 422,
              'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
               'errorMessage' => 'Failed to cancel market',
               'error'        => $e->getMessage(),
            ], 500);
        }
    }
    
/**
 * Settle Market
 */

    public function settleMarket(Request $request)
    {
       
        
        $validator = Validator::make($request->all(), [
            'PartnerId'        => 'required|string',
            'Username'         => 'required|string',
            'TransactionID'    => 'required|string',
            'Eventtypename'           => 'required|string',
            'Competitionname'           => 'required|string',
            'Eventname'           => 'required|string',
            'Marketname'           => 'required|string',
            'Markettype'          => 'required|integer',
            'MarketID'         => 'required|integer',
            'TransactionType'  => 'required',
            'PayableAmount'           => 'required|numeric|min:0',
            'NetPL'          => 'required',
            'CommissionAmount'           => 'required|numeric|min:0',
            'Commission'          => 'required|numeric|min:0',
            'Point'         => 'required|integer',
        ]);
 
 
        if ($validator->fails()) {
            return response()->json([
                'status'       => 422,
                'data' => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
        
        $user = User::where('Username', $request->Username)->first();

        if (!$user) {
            return response()->json([
               'status'       => 422,
                'data' => 0.00,
                'errorMessage' => 'User not found',
            ], 404);
        }
        // Check if the partnerId is valid
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                'status'       => 422,
                'balance'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid partnerId',
            ], 401);
        }
   
        // Check if bet was already cancelled
        $cancelledBet = DB::table('sports_bets_history')->where([
            'transactionId' => $request->TransactionID,
            'Username'     => $request->Username,
            'partnerId'    => $request->PartnerId,
            'methodName'   => 'cancelbet'
        ])->first();
   
        if ($cancelledBet) {
            return response()->json([
                'status'       => 422,
                'balance'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Bet Already Cancelled'
            ], 400);
        }
        
        // Check if settlement already exists
        $existingSettlement = DB::table('sports_game_settlements_history')
        ->where('transactionId', $request->TransactionID)
        ->where('partnerId', $request->PartnerId)
        ->where('Username', $request->Username)
        ->first();
 
        if ($existingSettlement) {
            return response()->json([
                'status'       => 422,
                'balance'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Transaction already settled',
            ], 400);
        }
       

        // Check if matching bet exists
        $matchingBet = DB::table('sports_bets_history')->where([
             'marketId'  => $request->MarketID,
             'Username'     => $request->Username,
             'partnerId'    => $request->PartnerId,
        ])->first();
      
        if (!$matchingBet) {
            return response()->json([
                'status'       => 422,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid Request',
            ], 400);
        }
 
        DB::beginTransaction();
        
        try {
            $payoffAmount = $request->PayableAmount;
            $transactionType = $request->TransactionType == 2 ? 'CR' : 'DR';
           // Handle balance update according to transaction type
            if ($transactionType == 'CR') {
                $user->increment('balance', $payoffAmount);
                $balance = ['pay' => $payoffAmount , 'balance' => $user->balance ];
                
                $trx_type = '+';
                $transactionDetails = 'Winning amount credited from Sports game';
                $transactionRemark = 'balance_add';
            } elseif ($transactionType == 'DR') {
                if ($user->balance < $payoffAmount) {
                    DB::rollBack();
                    return response()->json([
                        'status'       => 100,
                        'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                        'errorMessage' => 'Insufficient balance',
                    ], 400);
                }
                
                $user->decrement('balance', $payoffAmount);
                $trx_type = '-';
                $transactionDetails = 'Amount deducted for Sports game settlement';
                $transactionRemark = 'balance_subtract';
            } else {
                // This should never happen due to validation
                throw  \Exception('Invalid transaction type');
            }
             
            // Store settlement history
               DB::table('sports_game_settlements_history')->insert([
                'partnerId'         => $request->PartnerId,
                'userName'          => $request->Username,
                'transactionId'     => $request->TransactionID,
                'marketId'           => $request->MarketID,
                'marketType'     => $request->Markettype,
                'transactionType'   => $transactionType,
                'marketName'    => $request->Marketname,
                'payableAmount'            => $payoffAmount,
                'eventName'             => $request->Eventname,
                'netpl'             => $request->NetPL,
                'competitionName'             => $request->Competitionname,
                'methodName'        =>  'settlegame',
                'eventTypeName'             => $request->Eventtypename,
                'point'            => $request->Point,
                'commissionAmount'       => $request->CommissionAmount,
                'commission'           => $request->Commission,
                'status'            => 'settled',
                'created_at'        => now(),
                'updated_at'        => now(),
               ]);
 
            
            // Refresh user to get updated balance
            $user->refresh();
   
            // Record transaction
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $payoffAmount;
            $transaction->charge = 0;
            $transaction->post_balance = $user->balance;
            $transaction->trx_type = $trx_type;
            $transaction->trx = $request->TransactionID;
            $transaction->details = $transactionDetails;
            $transaction->remark = $transactionRemark;
            $transaction->type = Transaction::TYPE_USER_BET_SPORTSGAME;
            $transaction->created_at = now();
            $transaction->updated_at = now();
            $transaction->save();

            DB::commit();

            return response()->json([
                'status'       => 100,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage'     => 'Success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 422,
                'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Failed to settle game',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }


 
/**
 * Resettle market
 */
  
   
    public function resettle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'PartnerId'        => 'required|string',
            'Username'         => 'required|string',
            'TransactionID'    => 'required|string',
            'Eventtypename'           => 'required|string',
            'Competitionname'           => 'required|string',
            'Eventname'           => 'required|string',
            'Marketname'           => 'required|string',
            'Markettype'          => 'required|integer',
            'MarketID'         => 'required|integer',
            'TransactionType'  => 'required',
            'PayableAmount'           => 'required|numeric|min:0',
            'NetPL'          => 'required',
            'CommissionAmount'           => 'required|numeric|min:0',
            'Commission'          => 'required|numeric|min:0',
            'Point'         => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status'       => 422,
                'data'      => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
                'status'       => 422,
                'data'      => 0.00,
                'errorMessage' => 'User not found',
            ], 404);
        }
     
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                'status'       => 422,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid partnerId',
            ], 401);
        }
    
     
        DB::beginTransaction();
        try {
            // Check if already resettled
            $alreadyResettled = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'resettled',
            ])->exists();
    
            if ($alreadyResettled) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Already resettled',
                ], 400);
            }
    
            // Get previous payoff (from 'settlegame')
            $previousPayoff = DB::table('sports_game_settlements_history')
                ->where([
                    'Username'      => $request->Username,
                    'partnerId'     => $request->PartnerId,
                    'marketId' => $request->MarketID,
                    'methodName'    => 'settlegame',
                ])
                ->value('payableAmount');
    
            $newAmount = $request->PayableAmount;
    
            if ($previousPayoff === null) {
                return response()->json([
                    'status'       => 422,
                    'data' => 0.00,
                    'errorMessage' => 'Invalid Request',
                ], 400);
            }
    
            $difference = $newAmount - $previousPayoff;
    
            if ($difference === 0.0) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'No change in payoff. Nothing to update.',
                ], 400);
            }
    
            // Check if user has sufficient balance for negative adjustment
            if ($difference < 0 && $user->balance < abs($difference)) {
                return response()->json([
                    'status'       => 422,
                    'balance'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Insufficient balance for settlement adjustment',
                ], 400);
            }
    
            // Generate unique transaction ID for this adjustment
            $adjustmentTxnId = (string) Str::uuid();
            $transactionType = $request->TransactionType == 2 ? 'CR' : 'DR';
            if ($difference > 0) {
                // User gets more money
                $user->increment('balance', $difference);
                $trxType = '+';
                $transactionDetails = 'Settlement adjustment - additional amount credited';
                $transactionRemark = 'resettlegame_add';
            } else {
                // User gets less money (or owes more)
                $user->decrement('balance', abs($difference));
                $trxType = '-';
                $transactionDetails = 'Settlement adjustment - amount deducted';
                $transactionRemark = 'resettlegame_subtract';
            }
            // Insert new resettlement record
                DB::table('sports_game_settlements_history')->insert([
                    'partnerId'         => $request->PartnerId,
                    'userName'          => $request->Username,
                    'transactionId'     => $request->TransactionID,
                    'marketId'           => $request->MarketID,
                    'marketType'     => $request->Markettype,
                    'transactionType'   => $transactionType,
                    'marketName'    => $request->Marketname,
                    'payableAmount'            => $newAmount,
                    'eventName'             => $request->Eventname,
                    'netpl'             => $newAmount,
                    'competitionName'             => $request->Competitionname,
                    'methodName'        =>  'resettled',
                    'eventTypeName'             => $request->Eventtypename,
                    'point'            => $request->Point,
                    'commissionAmount'       => $request->CommissionAmount,
                    'commission'           => $request->Commission,
                    'status'            => 'resettled',
                    'created_at'        => now(),
                    'updated_at'        => now(),
                   ]);
  
            // Log the transaction
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = abs($difference);
            $transaction->charge = 0;
            $transaction->post_balance = $user->balance;
            $transaction->trx_type = $trxType;
            $transaction->trx = $adjustmentTxnId;
            $transaction->details = $transactionDetails;
            $transaction->remark = $transactionRemark;
            $transaction->type = Transaction::TYPE_USER_BET_SPORTSGAME;
            $transaction->created_at = now();
            $transaction->updated_at = now();
            $transaction->save();
    
            // Make sure we have the latest balance
            $user->refresh();
    
            DB::commit();
    
            return response()->json([
                'status'          => 100,
                'data'         => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage'    => 'Resettle success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 422,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Failed to resettle game',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }

/**
 * Cancel Settled Market
 */
    public function cancelSettledMarket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Username'     => 'required|string',
            'PartnerId'    => 'required|string',
            'TransactionID'      => 'required|string',
            'Markettype'     => 'required|integer',
            'MarketID'    => 'required|integer',
            'TransactionType'     => 'required|integer',
            'Amount'   => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status'       => 422,
                'data'      => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('Username', $request->Username)->first();
    
        if (!$user) {
            return response()->json([
                'status'       => 422,
                'data'      => 0.00,
                'errorMessage' => 'User not found',
            ], 404);
        }
    
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                'status'       => 100,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid partnerId',
            ], 401);
        }
       
        // Check if bet exists
        $bet = DB::table('sports_bets_history')->where([
            'Username'  => $request->Username,
            'partnerId' => $request->PartnerId,
            'marketId'  => $request->MarketID,
        ])->first();
    
        if (!$bet) {
            return response()->json([
                'status'       => 422,
                'data' => 0.00,
                'errorMessage' => 'Invalid Request',
            ], 400);
        }
    
        // Check if settlement is already canceled
        // Check if this specific settlement is already canceled
        $alreadyCanceled = DB::table('sports_game_settlements_history')->where([
            'Username'  => $request->Username,
            'partnerId' => $request->PartnerId,
            'marketId'  => $request->MarketID,
            'methodName'    => 'cancelSettledMarket',
        ])->exists();

        if ($alreadyCanceled) {
            return response()->json([
                'status'       => 422,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Bet already canceled',
            ], 400);
        }
    
        DB::beginTransaction();
        try {
            // Get settlement data
            $settlement = DB::table('sports_game_settlements_history')->where([
                'Username'  => $request->Username,
                'partnerId' => $request->PartnerId,
                'marketId'  => $request->MarketID,
            ])
            ->where('methodName', '!=', 'cancelSettledMarket')
            ->first();
            
            // Get placed bet data
            $placedBet = DB::table('sports_bets_history')->where([
                'Username'  => $request->Username,
                'partnerId' => $request->PartnerId,
                'marketId'  => $request->MarketID,
            ])
            ->first();
            
            // If neither settlement nor placed bet exists, return error
            if (!$settlement && !$placedBet) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'No valid bet or settlement found for cancellation',
                ], 400);
            }
            
            // Get payoff amount (from settlement) and original bet amount
            $betAmount = $placedBet->amount ?? 0;
            $payoffAmount = $settlement->payableAmount ?? 0;
            
            // We need to reverse the payoff that was applied during settlement
            if ($payoffAmount > 0) {
                // Check if user has sufficient balance to reverse the payoff
                if ($user->balance < $payoffAmount) {
                    DB::rollBack();
                    return response()->json([
                        'status'       => 422,
                        'balance'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                        'errorMessage' => 'Insufficient balance to cancel settlement',
                    ], 400);
                }
                
                // If payoff was positive (user won), deduct it back
                $user->decrement('balance', $payoffAmount);
                $trx_type = '-';
                $transactionDetails = 'Canceled settlement - winning amount reversed';
            } elseif ($payoffAmount < 0) {
                // If payoff was negative (user lost), add it back
                $user->increment('balance', abs($payoffAmount));
                $trx_type = '+';
                $transactionDetails = 'Canceled settlement - lost amount returned';
            } else {
                // No balance change
                $trx_type = '=';
                $transactionDetails = 'Canceled settlement - no balance change';
            }
             
           
            $transactionType = $request->transactionType == 2 ? 'CR' : 'DR';
            DB::table('sports_game_settlements_history')->insert([
                'partnerId'         => $request->PartnerId,
                'userName'          => $request->Username,
                'transactionId'     => $request->TransactionID,
                'marketId'           => $request->MarketID,
                'marketType'     => $request->Markettype,
                'transactionType'   => $transactionType,
                'marketName'    => $settlement->marketName,
                'payableAmount'            => $payoffAmount,
                'eventName'             => $settlement->Eventname ?? null,
                'netpl'             => $payoffAmount,
                'competitionName'             => $settlement->Competitionname ?? null,
                'methodName'        =>  'cancelSettledMarket',
                'eventTypeName'             => $settlement->Eventtypename ?? null,
                'point'            => $settlement->Point ?? null,
                'commissionAmount'       => $settlement->CommissionAmount ?? null,
                'commission'           => $settlement->Commission ?? null,
                'status'            => 'cancelSettledMarket',
                'created_at'        => now(),
                'updated_at'        => now(),
               ]);
            
            // Record transaction if balance was changed
            if ($payoffAmount != 0) {
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = abs($payoffAmount);
                $transaction->charge = 0;
                $transaction->post_balance = $user->balance;
                $transaction->trx_type = $trx_type;
                $transaction->trx = $request->TransactionID;
                $transaction->details = $transactionDetails;
                $transaction->remark = 'cancelSettledMarket';
                $transaction->type = Transaction::TYPE_USER_BET_SPORTSGAME;
                $transaction->created_at = now();
                $transaction->updated_at = now();
                $transaction->save();
            }
    
            $user->refresh();
            DB::commit();
    
            return response()->json([
                'status'       => 100,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 422,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Failed to cancel settled game',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }
    


 
    /**
     * Cashout
     */

    public function cashout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'PartnerId'        => 'required|string',
            'Username'         => 'required|string',
            'Eventtypename'           => 'required|string',
            'Competitionname'           => 'required|string',
            'Eventname'           => 'required|string',
            'Marketname'           => 'required|string',
            'Markettype'          => 'required|integer',
            'MarketID'         => 'required|integer',
            'TransactionType'  => 'required',
            'TotalAmount'           => 'required|numeric|min:0',
            'cashout'          => 'required',
            'Point'         => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status'       => 422,
                'balance'      => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
                'status'       => 422,
                'balance'      => 0.00,
                'errorMessage' => 'User not found',
            ], 404);
        }
    
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                'status'       => 422,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid partnerId',
            ], 401);
        }
     
        DB::beginTransaction();
        try {
            // Check if already resettled
            $alreadyResettled = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'settlegame',
            ])->exists();
    
            if ($alreadyResettled) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Already settled',
                ], 400);
            }
           

            $alreadyResettled = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'cashout',
            ])->exists();
    
            if ($alreadyResettled) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Already cashout',
                ], 400);
            }
            

            $transactionType = $request->TransactionType == 2 ? 'CR' : 'DR';
            $totalAmount = $request->TotalAmount ?? 0;
            if ($totalAmount < 0) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Invalid Total Amount',
                ], 400);
            }
           
            if ($transactionType == 'CR') {
                // User gets more money
                $user->increment('balance', abs($totalAmount));
                $trxType = '+';
                $transactionDetails = 'Cashout Adjustment - amount credited';
                $transactionRemark = 'cashout_credit';
            } else {
                // User gets less money (or owes more)
                $user->decrement('balance', abs($totalAmount));
                $trxType = '-';
                $transactionDetails = 'Cashout Adjustment - amount deducted';
                $transactionRemark = 'cashout_subtract';
            }
            // Insert new resettlement record
            $adjustmentTxnId = (string) Str::uuid();
            DB::table('sports_game_settlements_history')->insert([
                'partnerId'         => $request->PartnerId,
                'userName'          => $request->Username,
                'transactionId'     => $adjustmentTxnId,
                'marketId'           => $request->MarketID,
                'marketType'     => $request->Markettype,
                'transactionType'   => $transactionType,
                'marketName'    => $request->Marketname,
                'payableAmount'            => $totalAmount,
                'eventName'             => $request->Eventname ?? null,
                'netpl'             => $totalAmount,
                'competitionName'             => $request->Competitionname ?? null,
                'methodName'        =>  'cashout',
                'eventTypeName'             => $request->Eventtypename ?? null,
                'point'            => $request->Point ?? null,
                'commissionAmount'       => $request->CommissionAmount ?? null,
                'commission'           => $request->Commission ?? null,
                'status'            => 'cashout',
                'cashout' => json_encode($request->cashout ?? []),
                'created_at'        => now(),
                'updated_at'        => now(),
               ]);
          
            // Log the transaction
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = abs($totalAmount);
            $transaction->charge = 0;
            $transaction->post_balance = $user->balance;
            $transaction->trx_type = $trxType;
            $transaction->trx = $adjustmentTxnId;
            $transaction->details = $transactionDetails;
            $transaction->remark = $transactionRemark;
            $transaction->type = Transaction::TYPE_USER_BET_SPORTSGAME;
            $transaction->created_at = now();
            $transaction->updated_at = now();
            $transaction->save();
    
            // Make sure we have the latest balance
            $user->refresh();
    
            DB::commit();
    
            return response()->json([
                  'data'         => number_format($user->balance ?? 0.00, 2, '.', ''),
               'status'          => 100,
                'errorMessage'    => 'cashout success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 422,
                'balance'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Failed to cashout success',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }

    public function cancelCashout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'PartnerId'        => 'required|string',
            'Username'         => 'required|string',
            'Eventtypename'           => 'required|string',
            'Competitionname'           => 'required|string',
            'Eventname'           => 'required|string',
            'Marketname'           => 'required|string',
            'Markettype'          => 'required|integer',
            'MarketID'         => 'required|integer',
            'TransactionType'  => 'required',
            'TotalAmount'           => 'required|numeric|min:0',
            'cashout'          => 'required',
            'Point'         => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status'       => 422,
                'balance'      => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
                'status'       => 422,
                'balance'      => 0.00,
                'errorMessage' => 'User not found',
            ], 404);
        }
    
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                'status'       => 422,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invalid partnerId',
            ], 401);
        }
     
        DB::beginTransaction();
        try {
            // Check if already resettled
            $alreadyResettled = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'settlegame',
            ])->exists();
    
            if ($alreadyResettled) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Already settled',
                ], 400);
            }
           

            $alreadyCashout = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'cashout',
            ])->exists();
    
            if (!$alreadyCashout) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Already Cashout',
                ], 400);
            }
            
            $alreadyCancelCashout = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'cancelCashout',
            ])->exists();
            if ($alreadyCancelCashout) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Already cancel cashout',
                ], 400);
            }
            //check the previous cashout of same market to check balance

            $totalAmount = $request->TotalAmount ?? 0;
            $transactionType = $request->TransactionType == 2 ? 'CR' : 'DR';
            $alreadyCashout = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'cashout',
            ])
            ->first();
            if ($alreadyCashout->payableAmount  != $totalAmount) {
                return response()->json([
                'status'       => 422,
                'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Invaild request',
                ], 400);
            }

            if ($totalAmount < 0) {
                return response()->json([
                    'status'       => 422,
                    'data'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                    'errorMessage' => 'Invalid Total Amount',
                ], 400);
            }
           
            if ($transactionType == 'CR') {
                // User gets more money
                $user->increment('balance', abs($totalAmount));
                $trxType = '+';
                $transactionDetails = 'Cancel Cashout Adjustment - amount credited';
                $transactionRemark = 'cancel_cashout_credit';
            } else {
                // User gets less money (or owes more)
                $user->decrement('balance', abs($totalAmount));
                $trxType = '-';
                $transactionDetails = 'Cancel Cashout Adjustment - amount deducted';
                $transactionRemark = 'cancel_cashout_subtract';
            }
            // Insert new resettlement record
            $adjustmentTxnId = (string) Str::uuid();
            DB::table('sports_game_settlements_history')->insert([
                'partnerId'         => $request->PartnerId,
                'userName'          => $request->Username,
                'transactionId'     => $adjustmentTxnId,
                'marketId'           => $request->MarketID,
                'marketType'     => $request->Markettype,
                'transactionType'   => $transactionType,
                'marketName'    => $request->Marketname,
                'payableAmount'            => $totalAmount,
                'eventName'             => $request->Eventname ?? null,
                'netpl'             => $totalAmount,
                'competitionName'             => $request->Competitionname ?? null,
                'methodName'        =>  'cashout',
                'eventTypeName'             => $request->Eventtypename ?? null,
                'point'            => $request->Point ?? null,
                'commissionAmount'       => $request->CommissionAmount ?? null,
                'commission'           => $request->Commission ?? null,
                'status'            => 'cashout',
                'cashout' => json_encode($request->cashout ?? []),
                'created_at'        => now(),
                'updated_at'        => now(),
               ]);
          
            // Log the transaction
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = abs($totalAmount);
            $transaction->charge = 0;
            $transaction->post_balance = $user->balance;
            $transaction->trx_type = $trxType;
            $transaction->trx = $adjustmentTxnId;
            $transaction->details = $transactionDetails;
            $transaction->remark = $transactionRemark;
            $transaction->type = Transaction::TYPE_USER_BET_SPORTSGAME;
            $transaction->created_at = now();
            $transaction->updated_at = now();
            $transaction->save();
    
            // Make sure we have the latest balance
            $user->refresh();
    
            DB::commit();
    
            return response()->json([
                  'data'         => number_format($user->balance ?? 0.00, 2, '.', ''),
               'status'          => 100,
                'errorMessage'    => 'cancel cashout success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 422,
                'balance'      => number_format($user->balance ?? 0.00, 2, '.', ''),
                'errorMessage' => 'Failed to cancel cashout success',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }
}
