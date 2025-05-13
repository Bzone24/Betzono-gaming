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
        //set allowed parent id
        $this->middleware(function ($request, $next) {
            if ($request->header('x-app') !== $this->xApp) {
                return response()->json(['error' => 'Unauthorized'], 102);
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
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
        
        $user = User::where('Username', $request->Username)->first();

        if (!$user) {
            return response()->json([
                'status' => 102,
                'data' => 'Invalid user',
            ], 200);
        }

        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                'status' => 103,
                'data' => 'ParnterId not get in system'
            ], 200);
        }

        return response()->json([
            'data' => number_format($user->balance ?? 0.00, 2, '.', ''),
            'status' => 100
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
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
        
        // Check if the user exists
        DB::beginTransaction();
        
        try {
            $user = User::where('username', $request->Username)->first();

            if (!$user) {
                return response()->json([
                'status' => 102,
                'data' => 'User account does not exist'
                ], 200);
            }

            if (!in_array($request->partnerId, $this->allowedParentIds)) {
                return response()->json([
                'status' => 103,
                'data' => 'ParnterId not get in system'
                ], 200);
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
                'data' => 'Unable to fetch URL',
                ], 200);
            }
            $returnUrl = $responseData['data']['url'] ?? null;
            //if game url is empty then return error
            if (empty($returnUrl)) {
                return response()->json([
                'status' => 110,
                'data' => 'Url not available.',
                ], 200);
            }
            // Save login history
            DB::table('login_history')->insert([
            'userName'      => $request->Username,
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
            'status' => 100,
            'errorMessage' => 'Success',
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => 106,
                'data' => 'An unexpected error occurred',
                'errorDetails' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ] ?? null,
            ], 200);
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
 
      

        if ($validator->fails()) {
            return response()->json([
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
        
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
                'status'       => 102,
                'data' =>   'User not found',
            ], 200);
        }

        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
             'status'       => 103,
             'data' => 'ParnterId not get in system'
            ], 200);
        }

        // Only check if exact same transaction already placed
        $exists = DB::table('sports_bets_history')
        ->where('transactionId', $request->TransactionID)
        ->where('methodName', 'placebet')
        ->exists();

        if ($exists) {
            return response()->json([
                'status'       => 109,
               'data' => 'Transaction_Duplication'
            ], 200);
        }

        if ($user->balance < $request->Amount) {
            return response()->json([
                'status'       => 108,
               'data' =>   'Insufficient balance',
            ], 200);
        }

        $type = strtoupper(trim($request->TransactionType)); // 💥 Ensure upper case

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
                'data' => $user->balance
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
            'status' => 110,
            'data' => 'Bet Failed',
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
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }

        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
            'status'       => 102,
                'data' =>   'User not found',
            ], 200);
        }

        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
             'status' => 103,
                'data' => 'ParnterId not get in system'
            ], 200);
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
            'status'       => 112,
            'data' => 'Transaction id not found'
            ], 200);
        }

        // ✅ Amount must match
        if ($request->Amount != $originalBet->amount) {
            return response()->json([
            'status'       => 110,
            'data' =>   'Amount mismatch',
            ], 200);
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
            'status'       => 109,
            'data' =>  'Bet already cancelled',
            ], 200);
        }

        // ✅ Don't allow if already settled
        $settled = DB::table('sports_game_settlements_history')
        ->where('Username', $request->Username)
        ->where('partnerId', $request->PartnerId)
        ->where('transactionId', $request->ReverseTransactionId)
        ->exists();

        if ($settled) {
            return response()->json([
            'status'       => 111,
            'data' =>  'Bet already settled',
            ], 200);
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
             ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
         
            return response()->json([
            'status'       => 110,
            'data' => 'Failed to cancel',
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
            return response()->json([
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
    
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
              'status'       => 102,
                'data' =>   'User not found',
            ], 200);
        }
    
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
             'status' => 103,
                'data' => 'ParnterId not get in system'
            ], 200);
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
                'status'       => 110,
                'data' => 'Invalid Request',
                ], 200);
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
                    'status'       => 109,
                    'data' =>  'Bet already canceled',
                ], 200);
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
            
         
            // If neither bet nor settlement exists, return error
            if (!$settlement && !$placedBet) {
                  return response()->json([
                'status'       => 109,
                'data' =>  'No valid bet or settlement found for cancellation',
                  ], 200);
            }
            
            // Calculate correction amount 
            $correctionAmount = $request->Amount;
            
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
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
             'status'       => 110,
              'data' =>  'Failed to cancel market'
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
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
        
        $user = User::where('Username', $request->Username)->first();

        if (!$user) {
            return response()->json([
              'status'       => 102,
                'data' =>   'User not found',
            ], 200);
        }
        // Check if the partnerId is valid
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                 'status' => 103,
                'data' => 'ParnterId not get in system'
            ], 200);
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
                'status'       => 109,
                'balance'      =>  'Bet Already Cancelled'
            ], 200);
        }
        
        // Check if settlement already exists
        $existingSettlement = DB::table('sports_game_settlements_history')
        ->where('transactionId', $request->TransactionID)
        ->where('partnerId', $request->PartnerId)
        ->where('Username', $request->Username)
        ->first();
 
        if ($existingSettlement) {
            return response()->json([
                'status'       => 109,
                'balance'      =>  'Transaction already settled',
            ], 200);
        }
       

        // Check if matching bet exists
        $matchingBet = DB::table('sports_bets_history')->where([
             'marketId'  => $request->MarketID,
             'Username'     => $request->Username,
             'partnerId'    => $request->PartnerId,
        ])->first();
      
        if (!$matchingBet) {
            return response()->json([
                'status'       => 110,
                'data' =>   'Invalid Request',
            ], 200);
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
                        'status'       => 108,
                        'data' =>  'Insufficient balance',
                    ], 200);
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
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 110,
                'data' =>   'Failed to settle game',
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
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
    
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
               'status'       => 102,
                'data' =>   'User not found',
            ], 200);
        }
     
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                'status' => 103,
                'data' => 'ParnterId not get in system'
            ], 200);
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
                    'status'       => 109,
                    'data'      =>  'Already resettled',
                ], 200);
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
                    'status'       => 111,
                    'data' =>  'Invalid Request',
                ], 200);
            }
    
            $difference = $newAmount - $previousPayoff;
    
            if ($difference === 0.0) {
                return response()->json([
                    'status'       => 110,
                    'data'      => 'No change in payoff. Nothing to update.',
                ], 200);
            }
    
            // Check if user has sufficient balance for negative adjustment
            if ($difference < 0 && $user->balance < abs($difference)) {
                return response()->json([
                    'status'       => 110,
                    'balance'      =>  'Insufficient balance for settlement adjustment',
                ], 200);
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
                'data'         => number_format($user->balance ?? 0.00, 2, '.', '')
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 110,
                'data'      =>  'Failed to resettle game',
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
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
    
        $user = User::where('Username', $request->Username)->first();
    
        if (!$user) {
            return response()->json([
               'status'       => 102,
                'data' =>   'User not found',
            ], 200);
        }
    
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                 'status' => 103,
                'data' => 'ParnterId not get in system'
            ], 200);
        }
       
        // Check if bet exists
        $bet = DB::table('sports_bets_history')->where([
            'Username'  => $request->Username,
            'partnerId' => $request->PartnerId,
            'marketId'  => $request->MarketID,
        ])->first();
    
        if (!$bet) {
            return response()->json([
                'status'       => 111,
                'data' =>   'Invalid Request',
            ], 200);
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
                'status'       => 109,
                'data'      =>  'Bet already canceled',
            ], 200);
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
                    'status'       => 110,
                    'data'      =>  'No valid bet or settlement found for cancellation',
                ], 200);
            }
            
            // Get payoff amount (from settlement) and original bet amount
            $payoffAmount = $request->Amount ?? 0;
            
            // We need to reverse the payoff that was applied during settlement
            if ($payoffAmount > 0) {
                // Check if user has sufficient balance to reverse the payoff
                if ($user->balance < $payoffAmount) {
                    DB::rollBack();
                    return response()->json([
                        'status'       => 110,
                        'balance'      => 'Insufficient balance to cancel settlement',
                    ], 200);
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
                'status'       => 110,
                'data'      =>   'Failed to cancel settled game',
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
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
    
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
              'status'       => 102,
                'data' =>   'User not found',
            ], 200);
        }
    
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                 'status' => 103,
                'data' => 'ParnterId not get in system'
            ], 200);
        }
     
        DB::beginTransaction();
        $ctransactionIds = [];
        //get transactionids from cashout
        if (!empty($request->cashout)) {
            foreach ($request->cashout as $key => $value) {
                $ctransactionIds[] = $value['TransactionID'];
            }
        }

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
                    'status'       => 109,
                    'data'      =>  'Already settled',
                ], 200);
            }
           

            if (!empty($ctransactionIds)) {
                $alreadyResettled = DB::table('sports_game_settlements_history')->where([
                    'Username'      => $request->Username,
                    'partnerId'     => $request->PartnerId,
                    'marketId'      => $request->MarketID,
                    'methodName'    => 'cashout',
                ])->whereIn('transactionId', $ctransactionIds)->exists();
            } else {
                $alreadyResettled = DB::table('sports_game_settlements_history')->where([
                    'Username'      => $request->Username,
                    'partnerId'     => $request->PartnerId,
                    'marketId'      => $request->MarketID,
                    'methodName'    => 'cashout',
                ])->exists();
            }
    
            if ($alreadyResettled) {
                return response()->json([
                    'status'       => 109,
                    'data'      =>  'Already cashout',
                ], 200);
            }
            

            $transactionType = $request->TransactionType == 2 ? 'CR' : 'DR';
            $totalAmount = $request->TotalAmount ?? 0;
            if ($totalAmount < 0) {
                return response()->json([
                    'status'       => 110,
                    'data'      =>  'Invalid Total Amount',
                ], 200);
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
                'status'          => 100,
                  'data'         => number_format($user->balance ?? 0.00, 2, '.', ''),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 110,
                'balance'      => 'Failed to cashout success'
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
                'status' => 101,
                'data' => 'Parameter missing in request',
            ], 200);
        }
    
        $user = User::where('Username', $request->Username)->first();
        if (!$user) {
            return response()->json([
              'status'       => 102,
                'data' =>   'User not found',
            ], 200);
        }
    
        if (!in_array($request->PartnerId, $this->allowedParentIds)) {
            return response()->json([
                 'status' => 103,
                'data' => 'ParnterId not get in system'
            ], 200);
        }
        $ctransactionIds = [];
        //get transactionids from cashout
        if (!empty($request->cashout)) {
            foreach ($request->cashout as $key => $value) {
                $ctransactionIds[] = $value['TransactionID'];
            }
        }


        $rtransactionIds = [];
        //get transactionids from cashout
        if (!empty($request->cashout)) {
            foreach ($request->cashout as $key => $value) {
                $rtransactionIds[] = $value['ReverseTransactionId'];
            }
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
                    'status'       => 109,
                    'data'      =>  'Already settled',
                ], 200);
            }
           
            if (!empty($rtransactionIds)) {
                $alreadyCashout = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'cashout',
                ])->whereIn('transactionId', $rtransactionIds)->exists();
            } else {
                $alreadyCashout = DB::table('sports_game_settlements_history')->where([
                    'Username'      => $request->Username,
                    'partnerId'     => $request->PartnerId,
                    'marketId' => $request->MarketID,
                    'methodName'    => 'cashout',
                ])->exists();
            }
    
            if (!$alreadyCashout) {
                return response()->json([
                    'status'       => 109,
                    'data'      => 'Already Cashout',
                ], 200);
            }
            

            // Check if this specific settlement is already canceled

            if (!empty($ctransactionIds)) {
                $alreadyCancelCashout = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'cancelCashout',
                ])->whereIn('transactionId', $ctransactionIds)->exists();
            } else {
                $alreadyCancelCashout = DB::table('sports_game_settlements_history')->where([
                'Username'      => $request->Username,
                'partnerId'     => $request->PartnerId,
                'marketId' => $request->MarketID,
                'methodName'    => 'cancelCashout',
                ])->exists();
            }
            if ($alreadyCancelCashout) {
                return response()->json([
                    'status'       => 109,
                    'data'      =>  'Already cancel cashout',
                ], 200);
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
                'status'       => 110,
                'data'      =>   'Invaild request',
                ], 200);
            }

            if ($totalAmount < 0) {
                return response()->json([
                    'status'       => 110,
                    'data'      =>  'Invalid Total Amount',
                ], 200);
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
                'status'          => 100,
                  'data'         => number_format($user->balance ?? 0.00, 2, '.', '')
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'       => 110,
                'data' => 'Failed to cancel cashout success',
            ], 200);
        }
    }
}
