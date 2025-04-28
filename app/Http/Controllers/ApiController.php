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


class ApiController extends Controller
{
    public function deposit(Request $request){

        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,api_user_id',
            'amount' => 'required|integer|min:1',
            'transaction_id' => 'required',
        ]);

        // If validation fails, return a JSON response with the errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $check = Transaction::where('trx', $request->transaction_id)->first();

        if($check){
            return response()->json([
                'status' => 'error',
                'transaction' => $check->trx,
                'message' => 'Transaction already exists!',
            ], 422);
        }

        $user = User::where('api_user_id', $request->user_id)->first();        
        $amount = $request->amount;
        $user->balance += $amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->trx_type = '+';
        $transaction->remark = 'balance_add';
        $transaction->user_id = $user->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx =  $request->transaction_id;
        $transaction->details = "Funds withdrawal from Game Zone";
        $transaction->type = Transaction::TYPE_USER_TRANSFER_IN;
        $transaction->save();

        // Validation passed, continue processing...
        return response()->json([
            'status' => 'success',
            'transaction' => $transaction->trx,
            'message' => 'Deposit request raised successfully!',
        ]);
    }
    
    public function checkBalance(Request $request){
        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,api_user_id', 
        ]);

        // If validation fails, return a JSON response with the errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
 
        $user = User::where('api_user_id', $request->user_id)->first();
        if(!$user){
            return response()->json([
                'status' => 'error', 
                'message' => 'User not exists!',
            ], 422);
        }
        // Validation passed, continue processing...
        return response()->json([
            'status' => 'success',
            'balance' => $user->balance,
            'message' => 'Balance fetched successfully!',
        ]);
    }
    
    public function getLobbyUrl(Request $request)
    {
        try {
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $payload = [
            "userName"   => $user->username,
            "agentCode"  => "stakeye",
            "tpGameId"   => $request->gameId,
            "tpGameTableId"=>$request->gameTableId,
            "isAllowBet" => true,
            "isDemoUser" => true,
            "returnUrl"  => "https://stakeye.com"
        ];

    
            // Remove optional fields if they are NULL
            if (!empty($user->firstname)) {
                $payload["firstName"] = $user->firstname;
            }
            if (!empty($user->lastname)) {
                $payload["lastName"] = $user->lastname;
            }
            $client = new Client();
    
            // Make API request using Guzzle
            $response = $client->post('https://api.vkingplays.com/api/Login', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
                'json' => $payload, // Send payload as JSON
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
    
            if ($data['status'] == "0" && isset($data['lobbyURL'])) {
                return response()->json($data);
            } else {
                return response()->json(['error' => $data['errorMessage'] ?? 'Unknown error'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }

    public function insertGames(){
        try {
            DB::beginTransaction(); // Start Transaction

            $client = new Client();
            $headers = ['Content-Type' => 'application/json'];
            $body = json_encode(['agentCode' => 'stakeye']);

            $response = $client->post('https://api.vkingplays.com/api/GameList', [
                'headers' => $headers,
                'body' => $body
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['gameList'])) {
                return response()->json(['message' => 'Invalid API response'], 400);
            }

            foreach ($data['gameList'] as $game) {
                foreach ($game['data'] as $table) {
                    Game::updateOrCreate(
                        ['table_code' => $table['tableCode']],
                        [
                            'game_code' => $game['gameCode'],
                            'game_name' => $game['gameName'],
                            'table_name' => $table['tableName'],
                            'image_url' => $table['imageUrl'] ?? null,
                            'type' => $table['type'] ?? 'default'
                        ]
                    );
                }
            }

            DB::commit();
            return response()->json(['message' => 'Games inserted successfully'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'userName'       => 'required|string',
            'agentCode'      => 'required|string',
            'tpGameId'       => 'nullable|string',
            'tpGameTableId'  => 'nullable|string',
            'firstName'      => 'required|string',
            'isAllowBet'     => 'required|boolean',
            'lastName'       => 'required|string',
            'isDemoUser'     => 'required|boolean',
            'returnUrl'      => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 105,
                'errorMessage' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        }

        DB::beginTransaction();
        
        try {
            
        $user = User::where('username', $request->userName)->first();

        if (!$user) {
            return response()->json([
                'status' => 104,
                'errorMessage' => 'User account does not exist',
            ], 404);
        }

        $allowedAgentCodes = ['stakeye'];

        if (!in_array($request->agentCode, $allowedAgentCodes)) {
            return response()->json([
                'status' => 109,
                'errorMessage' => 'Invalid agent code',
            ], 401);
        }
        
        DB::table('login_history')->insert([
            'userName'      => $request->userName,
            'agentCode'     => $request->agentCode,
            'tpGameId'      => $request->tpGameId,
            'tpGameTableId' => $request->tpGameTableId,
            'firstName'     => $request->firstName,
            'lastName'      => $request->lastName,
            'isAllowBet'    => $request->isAllowBet,
            'isDemoUser'    => $request->isDemoUser,
            'returnUrl'     => $request->returnUrl,
            'status'        => 0, // Assuming 0 means success
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // $token = Hash::make($request->userName . now());

        // DB::table('users')->where('id', $user->id)->update([
        //     'last_login' => now(),
        // ]);
        DB::commit();

        return response()->json([
            'agentCode' => $request->agentCode,
            'userName' => $user->username,
            'lobbyURL' => $request->returnUrl,
            'status' => "0", 
            'errorMessage' => 'Success',
        ], 200);
        
        } catch (\Throwable $th) {
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

    public function validateUser(Request $request){
        $validator = Validator::make($request->all(), [
            'userName'   => 'required|string',
            'agentCode'  => 'required|string',
            'tpGameId'   => 'required|integer',
            'methodName' => 'required|string|in:validateuser',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'userName' => $request->userName,
                'agentCode' => $request->agentCode,
                'status' => 105, 
                'errorMessage' => 'Validation Error',
                'errors'  => $validator->errors(),
                'Point' => 0.00,    
            ], 400);
        }
        
        try {
            
        $user = User::where('username', $request->userName)->first();

        if (!$user) {
            return response()->json([
                'userName' => $request->userName,
                'agentCode' => $request->agentCode,
                'status' => 104,
                'errorMessage' => 'Invalid user',
                'Point' => 0.00,
            ], 404);
        }

        $allowedAgentCodes = ['stakeye'];

        if (!in_array($request->agentCode, $allowedAgentCodes)) {
            return response()->json([
                'userName' => $request->userName,
                'agentCode' => $request->agentCode,
                'status' => 109,
                'errorMessage' => 'Invalid agent code',
                'Point' => 0.00,
            ], 401);
        }

        $gameExists = DB::table('games')
            ->where('game_code', $request->tpGameId)
            ->exists();

        if (!$gameExists) {
            return response()->json([
                'status'       => 102,
                'errorMessage' => 'Invalid tpGameId',
            ], 400);
        }
        
        return response()->json([
            'agentCode' => $request->agentCode,
            'currencyId' => null,
            'userName' => $user->username,
            'isAllowBet' => true,
            'isDemoUser' => false,
            'point' => 1,
            'partnerShip' => [],
            'balance' =>$user->balance,
            'status' => 0,
            'errorMessage' => 'Success'
        ], 200);
        
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 106,
                'errorMessage' => 'An unexpected error occurred',
                'Point' => 0.00,
                'trace' => [
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                    'trace' => $th->getTraceAsString()
                ] ?? null,
            ], 500);
        }
    }

    public function getBalance(Request $request){

        $validator = Validator::make($request->all(), [
            'userName'   => 'required|string',
            'agentCode'  => 'required|string',
            'tpGameId'   => 'nullable|integer',
            'methodName' => 'required|string|in:getbalance',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'userName' => $request->userName,
                'agentCode' => $request->agentCode,
                'status' => 105,
                'balance' => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 400);
        }
        
        $user = User::where('username', $request->userName)->first();

        if (!$user) {
            return response()->json([
                'userName' => $request->userName,
                'agentCode' => $request->agentCode,
                'status' => 104,
                'balance' => 0.00,
                'errorMessage' => 'Invalid user',
            ], 404);
        }

        $allowedAgentCodes = ['stakeye'];

        if (!in_array($request->agentCode, $allowedAgentCodes)) {
            return response()->json([
                'userName' => $request->userName,
                'agentCode' => $request->agentCode,
                'status' => 109,
                'balance' => 0.00,
                'errorMessage' => 'Invalid agent code',
            ], 401);
        }

        return response()->json([
            'agentCode' => $request->agentCode,
            'userName' => $user->username,
            'tpGameId' => $request->tpGameId,
            'balance' => $user->balance ?? 0.00,
            'status' => 0,
            'errorMessage' => 'Success'
        ], 200);
    }

    /**
 * Place a bet for casino games
 */
public function placeBet(Request $request)
{
    $validator = Validator::make($request->all(), [
        'userName'          => 'required|string',
        'agentCode'         => 'required|string',
        'roundId'           => 'required|string',
        'tpGameId'          => 'required|integer',
        'amount'            => 'required|numeric|min:0.01',
        'transactionType'   => 'required|string|in:DR,CR',
        'transactionId'     => 'required|string',
        'tableCode'         => 'required|string',
        'gameType'          => 'required|string',
        'methodName'        => 'required|string|in:placebet',
        'runnerName'        => 'nullable|string',
        'rate'              => 'nullable|numeric|min:1',
        'stake'             => 'nullable|numeric|min:0.01',
        'betType'           => 'nullable|string',
        'vkingtransactionId'=> 'nullable|integer',
    ], [
        'amount.min' => 'Invalid Amount',
        'amount.required' => 'Amount is required',
    ]);

    if ($request->amount < 0.01) {
        return response()->json([
            'status'       => 108,
            'errorMessage' => 'Invalid amount',
        ], 400);
    }
    
    if ($validator->fails()) {
        $errors = $validator->errors();
        if ($errors->has('amount') && in_array('Invalid Amount', $errors->get('amount'))) {
            return response()->json([
                'status'       => 108,
                'errorMessage' => 'Invalid Amount',
            ], 400);
        }

        return response()->json([
            'userName'     => $request->userName ?? '',
            'agentCode'    => $request->agentCode ?? '',
            'status'       => 105,
            'balance'      => 0.00,
            'errorMessage' => 'Validation Error',
            'errors'       => $validator->errors(),
        ], 400);
    }

    $user = User::where('username', $request->userName)->first();
    if (!$user) {
        return response()->json([
            'status' => 104,
            'errorMessage' => 'User not found',
        ], 404);
    }

    if (!in_array($request->agentCode, ['stakeye'])) {
        return response()->json([
            'status' => 109,
            'errorMessage' => 'Invalid agent code',
        ], 401);
    }

    // Only check if exact same transaction already placed
    $exists = DB::table('casino_bets_history')
        ->where('transactionId', $request->transactionId)
        ->where('methodName', 'placebet')
        ->exists();

    if ($exists) {
        return response()->json([
            'status' => 102,
            'errorMessage' => 'Invalid Request',
        ], 400);
    }

    if ($user->balance < $request->amount && $request->transactionType == 'DR') {
        return response()->json([
            'status' => 100,
            'errorMessage' => 'Insufficient balance',
        ], 400);
    }

    $type = strtoupper(trim($request->transactionType)); // 💥 Ensure upper case

    DB::beginTransaction();
    try {
        if ($type === 'CR') {
            $user->increment('balance', $request->amount);
            $trxType = '+';
        } else {
            $user->decrement('balance', $request->amount);
            $trxType = '-';
        }

        // 💾 Save to cache
        Cache::put('bet_transaction_type_' . $request->transactionId, $type, now()->addHours(24));

        // ✅ Insert into DB
        DB::table('casino_bets_history')->insert([
            'userName'           => $request->userName,
            'agentCode'          => $request->agentCode,
            'roundid'            => $request->roundId,
            'tpGameId'           => $request->tpGameId,
            'amount'             => $request->amount,
            'transactionType'    => $type,
            'transactionId'      => $request->transactionId,
            'tableCode'          => $request->tableCode,
            'gametype'           => $request->gameType,
            'methodName'         => $request->methodName,
            'runnerName'         => $request->runnerName,
            'rate'               => $request->rate,
            'stake'              => $request->stake,
            'betType'            => $request->betType,
            'vkingtransactionId' => $request->vkingtransactionId,
            'status'             => 'placed',
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // 💰 Transaction log
        $trx = new Transaction();
        $trx->user_id = $user->id;
        $trx->amount = $request->amount;
        $trx->charge = 0;
        $trx->post_balance = $user->balance;
        $trx->trx_type = $trxType;
        $trx->trx = $request->transactionId;
        $trx->details = 'Casino game - ' . ($type === 'DR' ? 'Debit' : 'Credit');
        $trx->remark = ($type === 'DR' ? 'balance_subtract' : 'balance_add');
        $trx->type = Transaction::TYPE_USER_BET_VKINGPLAYS;
        $trx->created_at = now();
        $trx->updated_at = now();
        $trx->save();

        DB::commit();

        return response()->json([
            'userName' => $request->userName,
            'agentCode' => $request->agentCode,
            'tpGameId' => $request->tpGameId,
            'roundId' => $request->roundId,
            'balance' => $user->balance,
            'transactionId' => $request->transactionId,
            'partnertxnId' => $request->partnertxnId ?? null,
            'tableCode' => $request->tableCode,
            'status' => 0,
            'errorMessage' => 'Success',
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('PlaceBet Error: ' . $e->getMessage());
        return response()->json([
            'status' => 500,
            'errorMessage' => 'Bet Failed',
        ]);
    }
}

/**
 * Cancel a previously placed bet
 */
public function cancelBet(Request $request)
{
    $validator = Validator::make($request->all(), [
        'userName'             => 'required|string',
        'agentCode'            => 'required|string',
        'roundId'              => 'required|string',
        'tpGameId'             => 'required|integer',
        'amount'               => 'required|numeric|min:0.01',
        'transactionId'        => 'required|string',
        'reversetransactionId' => 'required|string',
        'tableCode'            => 'required|string',
        'gameType'             => 'required|string',
        'methodName'           => 'required|string|in:cancelbet',
        'runnerName'           => 'nullable|string',
        'rate'                 => 'nullable|numeric',
        'stake'                => 'nullable|numeric|min:0',
        'betType'              => 'nullable|string',
        'vkingtransactionId'   => 'nullable|integer',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'       => 105,
            'errorMessage' => 'Validation Error',
            'errors'       => $validator->errors(),
        ], 400);
    }

    $user = User::where('username', $request->userName)->first();
    if (!$user) {
        return response()->json([
            'status'       => 104,
            'errorMessage' => 'User not found',
        ], 404);
    }

    if (!in_array($request->agentCode, ['stakeye'])) {
        return response()->json([
            'status'       => 109,
            'errorMessage' => 'Invalid agent code',
        ], 401);
    }

    // ✅ Original bet must exist
    $originalBet = DB::table('casino_bets_history')
        ->where('transactionId', $request->reversetransactionId)
        ->where('methodName', 'placebet')
        ->first();

    if (!$originalBet) {
        return response()->json([
            'status'       => 102,
            'errorMessage' => 'Invalid Request',
        ], 400);
    }

    // ✅ Amount must match
    if ($request->amount != $originalBet->amount) {
        return response()->json([
            'status'       => 108,
            'errorMessage' => 'Amount mismatch',
        ], 400);
    }

    // ✅ Check if already cancelled using reversetransactionId
    $alreadyCancelled = DB::table('casino_bets_history')
        ->where('methodName', 'cancelbet')
        ->where('transactionId', $request->reversetransactionId)
        ->exists();

    if ($alreadyCancelled) {
        return response()->json([
            'status'       => 111,
            'errorMessage' => 'Bet already cancelled',
        ], 400);
    }

    // ✅ Don't allow if already settled
    $settled = DB::table('casino_game_settlements_history')
        ->where('transactionId', $request->reversetransactionId)
        ->exists();

    if ($settled) {
        return response()->json([
            'status'       => 112,
            'errorMessage' => 'Bet already settled',
        ], 400);
    }

    // ✅ Determine original transaction type
    $originalType = null;

    if (!empty($originalBet->transactionType)) {
        $originalType = strtoupper(trim($originalBet->transactionType));
    } elseif (Cache::has('bet_transaction_type_' . $request->reversetransactionId)) {
        $originalType = strtoupper(trim(Cache::get('bet_transaction_type_' . $request->reversetransactionId)));
    } else {
        $originalType = 'DR'; // default if nothing found
    }

    DB::beginTransaction();
    try {
        if ($originalType === 'CR') {
            $user->decrement('balance', $request->amount);
            $cancelType = 'DR';
            $trxType = '-';
        } else {
            $user->increment('balance', $request->amount);
            $cancelType = 'CR';
            $trxType = '+';
        }

        DB::table('casino_bets_history')->insert([
            'userName'             => $request->userName,
            'agentCode'            => $request->agentCode,
            'roundid'              => $request->roundId,
            'tpGameId'             => $request->tpGameId,
            'amount'               => $request->amount,
            'transactionType'      => $cancelType,
            'transactionId'        => $request->transactionId,
            'tableCode'            => $request->tableCode,
            'gametype'             => $request->gameType,
            'methodName'           => $request->methodName,
            'runnerName'           => $request->runnerName,
            'rate'                 => $request->rate,
            'stake'                => $request->stake,
            'betType'              => $request->betType,
            'vkingtransactionId'   => $request->vkingtransactionId,
            'status'               => 'cancelled',
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        $trx = new Transaction();
        $trx->user_id = $user->id;
        $trx->amount = $request->amount;
        $trx->charge = 0;
        $trx->post_balance = $user->balance;
        $trx->trx_type = $trxType;
        $trx->trx = $request->transactionId;
        $trx->details = 'Bet cancellation adjustment';
        $trx->remark = 'cancelbet';
        $trx->type = Transaction::TYPE_USER_BET_VKINGPLAYS;
        $trx->created_at = now();
        $trx->updated_at = now();
        $trx->save();

        // Cleanup cache
        Cache::forget('bet_transaction_type_' . $request->reversetransactionId);

        DB::commit();

        return response()->json([
            'userName'             => $request->userName,
            'agentCode'            => $request->agentCode,
            'tpGameId'             => $request->tpGameId,
            'roundId'              => $request->roundId,
            'tableCode'            => $request->tableCode,
            'transactionId'        => $request->transactionId,
            'reversetransactionId' => $request->reversetransactionId,
            'balance'              => $user->balance,
            'status'               => 0,
            'errorMessage'         => 'Bet cancelled successfully',
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('CancelBet Error: ' . $e->getMessage());

        return response()->json([
            'status'       => 500,
            'errorMessage' => 'Cancel failed: ' . $e->getMessage(),
        ], 500);
    }
}

    


    public function cancelGame(Request $request){
        $validator = Validator::make($request->all(), [
            'userName'           => 'required|string',
            'agentCode'          => 'required|string',
            'roundId'            => 'required|string',
            'tpGameId'           => 'required|integer',
            'tableCode'          => 'required|string',
            'gameType'           => 'required|string',
            'methodName'         => 'required|string|in:cancelgame',
            'vkingtransactionId' => 'required|integer',
            'amount'             => 'required|numeric|min:0',
            'runnerName'         => 'nullable|string',
            'rate'               => 'nullable|numeric',
            'stake'              => 'nullable|numeric|min:0',
            'betType'            => 'nullable|string',
        ], [
            'amount.min' => 'Invalid Amount',
            'amount.required' => 'Amount is required',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('amount') && in_array('Invalid Amount', $errors->get('amount'))) {
                return response()->json([
                    'status'       => 108,
                    'errorMessage' => 'Invalid Amount',
                ], 400);
            }

            return response()->json([
                'userName'     => $request->userName ?? '',
                'agentCode'    => $request->agentCode ?? '',
                'status'       => 105,
                'balance'      => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('username', $request->userName)->first();
        if (!$user) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 104,
                'balance'      => 0.00,
                'errorMessage' => 'User not found',
            ], 404);
        }
    
        $allowedAgentCodes = ['stakeye'];
        if (!in_array($request->agentCode, $allowedAgentCodes)) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 109,
                'balance'      => $user->balance,
                'errorMessage' => 'Invalid agent code',
            ], 401);
        }
    
        $gameExists = DB::table('games')
            ->where('game_code', $request->tpGameId)
            ->exists();
    
        if (!$gameExists) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 102,
                'balance'      => $user->balance,
                'errorMessage' => 'Invalid tpGameId',
            ], 400);
        }
    
        // Check for transaction ID to prevent duplicate cancellations
        $transactionId = Str::uuid()->toString();
        $normalizedTableCode = str_replace('smt_', '', $request->tableCode);
    
        DB::beginTransaction();
        try {
            // Check if already canceled
            // Check if this specific game cancellation already exists
            $alreadyCanceled = DB::table('casino_game_cancellations')->where([
                'vkingtransactionId' => $request->vkingtransactionId,
                'userName'      => $request->userName,
                'agentCode'     => $request->agentCode,
                'roundId'       => $request->roundId,
            ])->exists();

            if ($alreadyCanceled) {
                return response()->json([
                    'userName'     => $request->userName,
                    'agentCode'    => $request->agentCode,
                    'status'       => 111,
                    'balance'      => $user->balance,
                    'errorMessage' => 'Bet already canceled',
                ], 400);
            }
    
            // Check if bet exists
            $bet = DB::table('casino_bets_history')->where([
                'roundId'   => $request->roundId,
                'userName'  => $request->userName,
                'agentCode' => $request->agentCode,
                'tpGameId'  => $request->tpGameId,
            ])->first();
    
            if (!$bet) {
                return response()->json([
                    'status'       => 102,
                    'errorMessage' => 'Invalid Request',
                ], 400);
            }
    
            // Get settlement data if exists
            $settlement = DB::table('casino_game_settlements_history')->where([
                'agentCode' => $request->agentCode,
                'userName'  => $request->userName,
                'roundId'   => $request->roundId,
                'tpGameId'  => $request->tpGameId,
            ])
            ->where('methodName', '!=', 'cancelsettledgame')
            ->first();
            
            // Get placed bet data
            $placedBet = DB::table('casino_bets_history')->where([
                'agentCode' => $request->agentCode,
                'userName'  => $request->userName,
                'roundid'   => $request->roundId,
                'tpGameId'  => $request->tpGameId,
            ])
            ->first();
            
            // Validate amount matches
            if ($placedBet && $placedBet->amount != $request->amount) {
                return response()->json([
                    'status'       => 102,
                    'errorMessage' => 'Invalid Amount',
                ], 400);
            }
            
            // If neither bet nor settlement exists, return error
            if (!$settlement && !$placedBet) {
                return response()->json([
                    'userName'     => $request->userName,
                    'agentCode'    => $request->agentCode,
                    'status'       => 114,
                    'balance'      => $user->balance,
                    'errorMessage' => 'No valid bet or settlement found for cancellation',
                ], 400);
            }
            
            // Calculate correction amount
            $betAmount = $placedBet->amount ?? 0;
            $payoffAmount = $settlement->payoff ?? 0;
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
    
            // Record the cancellation
            DB::table('casino_game_cancellations')->insert([
                'userName'           => $request->userName,
                'tpGameId'           => $request->tpGameId,
                'agentCode'          => $request->agentCode,
                'amount'             => $correctionAmount,
                'roundId'            => $request->roundId,
                'vkingtransactionId' => $request->vkingtransactionId,
                'tableCode'          => $normalizedTableCode,
                'gameType'           => $request->gameType,
                'runnerName'         => $request->runnerName,
                'rate'               => $request->rate,
                'stake'              => $request->stake,
                'betType'            => $request->betType,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
    
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
                $transaction->details = 'Game cancellation balance adjustment';
                $transaction->remark = 'cancel_game';
                $transaction->type = Transaction::TYPE_USER_BET_VKINGPLAYS;
                $transaction->created_at = now();
                $transaction->updated_at = now();
                $transaction->save();
            }
    
            DB::commit();
    
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'roundId'      => $request->roundId,
                'tpGameId'     => $request->tpGameId,
                'balance'      => $user->balance,
                'status'       => 0,
                'errorMessage' => 'Success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 106,
                'balance'      => $user->balance ?? 0.00,
                'errorMessage' => 'Failed to cancel game',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }
    
    

    public function settleGame(Request $request){
       
        
      $validator = Validator::make($request->all(), [
            'userName'         => 'required|string',
            'agentCode'        => 'required|string',
            'roundId'          => 'required|string',
            'tpGameId'         => 'required|integer',
            'transactionType'  => 'required|string',
            'transactionId'    => 'required|string',
            'tableCode'        => 'required|string',
            'liability'        => 'required|numeric|min:0',
            'payoff'           => 'required|numeric|min:0',
            'netpl'            => 'required|numeric',
            'gametype'         => 'nullable|string',
            #'methodName'       => 'required|string|in:settlegame',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'userName'     => $request->userName ?? '',
                'agentCode'    => $request->agentCode ?? '',
                'status'       => 105,
                'balance'      => 0.00,
                'roundid'      => $request->roundId ?? '',
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
        
        $user = User::where('username', $request->userName)->first();

        if (!$user) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 104,
                'balance'      => 0.00,
                'roundid'      => $request->roundId,
                'errorMessage' => 'User not found',
            ], 404);
        }
        
        $allowedAgentCodes = ['stakeye'];

        if (!in_array($request->agentCode, $allowedAgentCodes)) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 109,
                'balance'      => $user->balance,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Invalid agent code',
            ], 401);
        }

        $gameExists = DB::table('games')
            ->where('game_code', $request->tpGameId)
            ->exists();
      
        
        if (!$gameExists) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 102,
                'balance'      => $user->balance,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Invalid tpGameId',
            ], 400);
        }

        // Remove this check as 'amount' is not required in validation, might cause errors
        // Instead use payoff from the request
        /*
        if ($user->balance < $request->amount) {
            return response()->json([
                'userName' => $request->userName,
                'agentCode' => $request->agentCode,
                'status' => 100,
                'balance' => 0.00,
                'roundid' => $request->roundId,
                'errorMessage' => 'Insufficient balance',
            ], 400);
        }
        */
        
        // Check if bet was already cancelled
        $cancelledBet = DB::table('casino_bets_history')->where([
            'transactionId'=> $request->transactionId,
            'userName'     => $request->userName,
            'agentCode'    => $request->agentCode,
            'methodName'   => 'cancelbet'
        ])->first();
   
        if ($cancelledBet) {
            return response()->json([ 
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'roundId'      => $request->roundId,
                'status'       => 111,
                'balance'      => $user->balance,
                'errorMessage' => 'Bet Already Cancelled'
            ], 400);
        }
        
        // Check if settlement already exists
        $existingSettlement = DB::table('casino_game_settlements_history')
        ->where('transactionId', $request->transactionId)
        ->first();
 
        if ($existingSettlement) {
            return response()->json([ 
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'roundId'      => $request->roundId,
                'status'       => 112,
                'balance'      => $user->balance,
                'errorMessage' => 'Transaction already settled',
            ], 400);
        }
       

        // Check if matching bet exists
        $matchingBet = DB::table('casino_bets_history')->where([
            'roundid'        => $request->roundId,
            // 'transactionId'  => $request->transactionId,
        ])->first();
      
        if (!$matchingBet) {
            return response()->json([
                'status'       => 102,
                'errorMessage' => 'Invalid Request',
            ], 400);
        }

        // Verify transaction ID with game ID
        $existingTxn = DB::table('casino_bets_history')->where([
            'tpGameId'       => $request->tpGameId,
            'roundid'        => $request->roundId,
            // 'transactionId'  => $request->transactionId,
        ])->first();
          if (!$existingTxn) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 102,
                'balance'      => $user->balance,
                'errorMessage' => 'Invalid tpGameId',
            ], 400);
        }

        DB::beginTransaction();
        
        try {
            $payoffAmount = $request->payoff;
            $transactionType = $request->transactionType;
           // Handle balance update according to transaction type
            if (strtolower($transactionType) == 'cr') {
                $user->increment('balance', $payoffAmount);
                $balance = ['pay' => $payoffAmount , 'balance' => $user->balance ];
                
        
            
                $trx_type = '+';
                $transactionDetails = 'Winning amount credited from Casino game';
                $transactionRemark = 'balance_add';
            } elseif ($transactionType == 'DR') {
                if ($user->balance < $payoffAmount) {
                    DB::rollBack();
                    return response()->json([
                        'userName'     => $request->userName,
                        'agentCode'    => $request->agentCode,
                        'status'       => 100,
                        'balance'      => $user->balance,
                        'roundid'      => $request->roundId,
                        'errorMessage' => 'Insufficient balance',
                    ], 400);
                }
                
                $user->decrement('balance', $payoffAmount);
                $trx_type = '-';
                $transactionDetails = 'Amount deducted for Casino game settlement';
                $transactionRemark = 'balance_subtract';
            } else {
                // This should never happen due to validation
                throw new \Exception('Invalid transaction type');
            }
               $balance = ['balance' => $user->balance , 'data' =>[
                'userName'          => $request->userName,
                'agentCode'         => $request->agentCode,
                'tpGameId'          => $request->tpGameId,
                'roundId'           => $request->roundId,
                'transactionType'   => $transactionType,
                'transactionId'     => $request->transactionId,
                'tableCode'         => $request->tableCode,
                'liability'         => $request->liability,
                'netpl'             => $request->netpl,
                'payoff'            => $payoffAmount,
                'gametype'          => $request->gametype ?? '',
                'methodName'        => $request->methodName??'settlegame',
                'status'            => 'settled',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]];
                
            // Store settlement history
            DB::table('casino_game_settlements_history')->insert([
                'userName'          => $request->userName,
                'agentCode'         => $request->agentCode,
                'tpGameId'          => $request->tpGameId,
                'roundId'           => $request->roundId,
                'transactionType'   => $transactionType,
                'transactionId'     => $request->transactionId,
                'tableCode'         => $request->tableCode,
                'liability'         => $request->liability,
                'netpl'             => $request->netpl,
                'payoff'            => $payoffAmount,
                'gametype'          => $request->gametype ?? '',
                'methodName'        => $request->methodName??'settlegame',
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
            $transaction->trx = $request->transactionId;
            $transaction->details = $transactionDetails;
            $transaction->remark = $transactionRemark;
            $transaction->type = Transaction::TYPE_USER_BET_VKINGPLAYS;
            $transaction->created_at = now();
            $transaction->updated_at = now();
            $transaction->save();

            DB::commit();

            return response()->json([
                'userName'         => $request->userName,
                'agentCode'        => $request->agentCode,
                'tpGameId'         => $request->tpGameId,
                'roundId'          => $request->roundId,
                'balance'          => number_format($user->balance, 2, '.', ''), // Ensuring proper decimal format
                'transactionType'  => $transactionType,
                'transactionId'    => $request->transactionId,
                'partnertxnId'     => "stakeye-".$transaction->id,
                'tableCode'        => $request->tableCode,
                'liability'        => $request->liability ?? 0,
                'netpl'            => $request->netpl ?? 0,
                'payoff'           => $payoffAmount ?? 0,
                'status'           => 0,
                'errorMessage'     => 'Success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 106,
                'balance'      => $user->balance,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Failed to settle game',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }

   

    public function cancelSettledGame(Request $request){
        $validator = Validator::make($request->all(), [
            'userName'     => 'required|string',
            'agentCode'    => 'required|string',
            'roundId'      => 'required|string',
            'tpGameId'     => 'required|integer',
            'tableCode'    => 'required|string',
            'gameType'     => 'required|string',
            'methodName'   => 'required|string|in:cancelsettledgame',
            'runnerName'   => 'nullable|string',
            'rate'         => 'nullable|numeric|min:0',
            'stake'        => 'nullable|numeric|min:0',
            'betType'      => 'nullable|string|in:Back,Lay',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'userName'     => $request->userName ?? '',
                'agentCode'    => $request->agentCode ?? '',
                'roundid'      => $request->roundId ?? '',
                'status'       => 105,
                'balance'      => 0.00,
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('username', $request->userName)->first();
    
        if (!$user) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 104,
                'balance'      => 0.00,
                'roundid'      => $request->roundId,
                'errorMessage' => 'User not found',
            ], 404);
        }
    
        $allowedAgentCodes = ['stakeye'];
        if (!in_array($request->agentCode, $allowedAgentCodes)) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 109,
                'balance'      => $user->balance,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Invalid agent code',
            ], 401);
        }
    
        $gameExists = DB::table('games')
            ->where('game_code', $request->tpGameId)
            ->exists();
    
        if (!$gameExists) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 102,
                'balance'      => $user->balance,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Invalid tpGameId',
            ], 400);
        }
    
        $normalizedTableCode = str_replace('smt_', '', $request->tableCode);
    
        // Check if bet exists
        $bet = DB::table('casino_bets_history')->where([
            'roundId'   => $request->roundId,
            'userName'  => $request->userName,
            'agentCode' => $request->agentCode,
            'tpGameId'  => $request->tpGameId,
        ])->first();
    
        if (!$bet) {
            return response()->json([
                'status'       => 102,
                'errorMessage' => 'Invalid Request',
            ], 400);
        }
    
        // Check if settlement is already canceled
        // Check if this specific settlement is already canceled
        $alreadyCanceled = DB::table('casino_game_settlements_history')->where([
            'roundId'       => $request->roundId,
            'userName'      => $request->userName,
            'agentCode'     => $request->agentCode,
            'tpGameId'      => $request->tpGameId,
            'transactionId' => $request->transactionId,
            'methodName'    => 'cancelsettledgame',
        ])->exists();

        if ($alreadyCanceled) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 112,
                'balance'      => $user->balance,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Bet already canceled',
            ], 400);
        }
    
        DB::beginTransaction();
        try {
            // Get settlement data
            $settlement = DB::table('casino_game_settlements_history')->where([
                'agentCode' => $request->agentCode,
                'userName'  => $request->userName,
                'roundId'   => $request->roundId,
                'tpGameId'  => $request->tpGameId,
            ])
            ->where('methodName', '!=', 'cancelsettledgame')
            ->first();
            
            // Get placed bet data
            $placedBet = DB::table('casino_bets_history')->where([
                'agentCode' => $request->agentCode,
                'userName'  => $request->userName,
                'roundid'   => $request->roundId,
                'tpGameId'  => $request->tpGameId,
            ])
            ->first();
            
            // If neither settlement nor placed bet exists, return error
            if (!$settlement && !$placedBet) {
                return response()->json([
                    'userName'     => $request->userName,
                    'agentCode'    => $request->agentCode,
                    'status'       => 114,
                    'balance'      => $user->balance,
                    'roundid'      => $request->roundId,
                    'errorMessage' => 'No valid bet or settlement found for cancellation',
                ], 400);
            }
            
            // Get payoff amount (from settlement) and original bet amount
            $betAmount = $placedBet->amount ?? 0;
            $payoffAmount = $settlement->payoff ?? 0;
            
            // We need to reverse the payoff that was applied during settlement
            if ($payoffAmount > 0) {
                // Check if user has sufficient balance to reverse the payoff
                if ($user->balance < $payoffAmount) {
                    DB::rollBack();
                    return response()->json([
                        'userName'     => $request->userName,
                        'agentCode'    => $request->agentCode,
                        'status'       => 100,
                        'balance'      => $user->balance,
                        'roundid'      => $request->roundId,
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
            
            // Generate transaction ID
            $transactionId = (string) Str::uuid();
    
            // Record the cancellation in settlement history
            DB::table('casino_game_settlements_history')->insert([
                'userName'        => $request->userName,
                'agentCode'       => $request->agentCode,
                'tpGameId'        => $request->tpGameId,
                'roundId'         => $request->roundId,
                'transactionType' => 'DR',
                'transactionId'   => $transactionId,
                'tableCode'       => $normalizedTableCode,
                'liability'       => $request->liability ?? 0,
                'netpl'           => $request->netpl ?? 0,
                'payoff'          => $payoffAmount,
                'gametype'        => $request->gameType,
                'methodName'      => $request->methodName,
                'status'          => 'canceled',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
            
            // Record transaction if balance was changed
            if ($payoffAmount != 0) {
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->amount = abs($payoffAmount);
                $transaction->charge = 0;
                $transaction->post_balance = $user->balance;
                $transaction->trx_type = $trx_type;
                $transaction->trx = $transactionId;
                $transaction->details = $transactionDetails;
                $transaction->remark = 'cancel_settled_game';
                $transaction->type = Transaction::TYPE_USER_BET_VKINGPLAYS;
                $transaction->created_at = now();
                $transaction->updated_at = now();
                $transaction->save();
            }
    
            $user->refresh();
            DB::commit();
    
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'tpGameId'     => $request->tpGameId,
                'roundId'      => $request->roundId,
                'tableCode'    => $normalizedTableCode,
                'balance'      => $user->balance,
                'status'       => 0,
                'errorMessage' => 'Success',
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 106,
                'balance'      => $user->balance ?? 0.00,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Failed to cancel settled game',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }
    
    


    public function resettleGame(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userName'        => 'required|string',
            'agentCode'       => 'required|string',
            'roundId'         => 'required|string',
            'tpGameId'        => 'required|integer',
            'amount'          => 'required|numeric|min:0',
            'transactionType' => 'required|string|in:CR,DR',
            'transactionId'   => 'required|string',
            'tableCode'       => 'required|string',
            'gameType'        => 'required|string',
            'methodName'      => 'required|string|in:resettlegame',
            'runnerName'      => 'nullable|string',
            'rate'            => 'nullable|numeric|min:0',
            'stake'           => 'nullable|numeric|min:0',
            'betType'         => 'nullable|string|in:Back,Lay',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'userName'     => $request->userName ?? '',
                'agentCode'    => $request->agentCode ?? '',
                'status'       => 105,
                'balance'      => 0.00,
                'roundid'      => $request->roundId ?? '',
                'errorMessage' => 'Validation Error',
                'errors'       => $validator->errors(),
            ], 400);
        }
    
        $user = User::where('username', $request->userName)->first();
        if (!$user) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 104,
                'balance'      => 0.00,
                'roundid'      => $request->roundId,
                'errorMessage' => 'User not found',
            ], 404);
        }
    
        $allowedAgentCodes = ['stakeye'];
        if (!in_array($request->agentCode, $allowedAgentCodes)) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 109,
                'balance'      => $user->balance,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Invalid agent code',
            ], 401);
        }
    
        $gameExists = DB::table('games')->where('game_code', $request->tpGameId)->exists();
        if (!$gameExists) {
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 102,
                'balance'      => $user->balance,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Invalid tpGameId',
            ], 400);
        }
    
        DB::beginTransaction();
        try {
            // Check if already resettled
            $alreadyResettled = DB::table('casino_game_settlements_history')->where([
                'roundId'       => $request->roundId,
                'tpGameId'      => $request->tpGameId,
                'userName'      => $request->userName,
                'agentCode'     => $request->agentCode,
                'transactionId' => $request->transactionId,
                'methodName'    => 'resettlegame',
            ])->exists();
    
            if ($alreadyResettled) {
                return response()->json([
                    'userName'     => $request->userName,
                    'agentCode'    => $request->agentCode,
                    'status'       => 116,
                    'balance'      => $user->balance,
                    'roundid'      => $request->roundId,
                    'errorMessage' => 'Already resettled',
                ], 400);
            }
    
            // Get previous payoff (from 'settlegame')
            $previousPayoff = DB::table('casino_game_settlements_history')
                ->where([
                    'roundId'       => $request->roundId,
                    'tpGameId'      => $request->tpGameId,
                    'userName'      => $request->userName,
                    'agentCode'     => $request->agentCode,
                    'methodName'    => 'settlegame',
                ])
                ->value('payoff');
    
            $newAmount = $request->amount;
    
            if ($previousPayoff === null) {
                return response()->json([
                    'status'       => 102,
                    'errorMessage' => 'Invalid Request',
                ], 400);
            }
    
            $difference = $newAmount - $previousPayoff;
    
            if ($difference === 0.0) {
                return response()->json([
                    'userName'     => $request->userName,
                    'agentCode'    => $request->agentCode,
                    'status'       => 117,
                    'balance'      => $user->balance,
                    'roundid'      => $request->roundId,
                    'errorMessage' => 'No change in payoff. Nothing to update.',
                ], 400);
            }
    
            // Check if user has sufficient balance for negative adjustment
            if ($difference < 0 && $user->balance < abs($difference)) {
                return response()->json([
                    'userName'     => $request->userName,
                    'agentCode'    => $request->agentCode,
                    'status'       => 100,
                    'balance'      => $user->balance,
                    'roundid'      => $request->roundId,
                    'errorMessage' => 'Insufficient balance for settlement adjustment',
                ], 400);
            }
    
            // Generate unique transaction ID for this adjustment
            $adjustmentTxnId = (string) Str::uuid();
    
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
            DB::table('casino_game_settlements_history')->insert([
                'agentCode'        => $request->agentCode,
                'userName'         => $request->userName,
                'tpGameId'         => $request->tpGameId,
                'roundId'          => $request->roundId,
                'transactionType'  => $request->transactionType,
                'transactionId'    => $adjustmentTxnId,
                'tableCode'        => $request->tableCode,
                'netpl'            => $newAmount,
                'payoff'           => $newAmount,
                'gametype'         => $request->gameType,
                'methodName'       => $request->methodName,
                'runnerName'       => $request->runnerName,
                'rate'             => $request->rate,
                'stake'            => $request->stake,
                'status'           => 'resettled',
                'created_at'       => now(),
                'updated_at'       => now(),
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
            $transaction->type = Transaction::TYPE_USER_BET_VKINGPLAYS;
            $transaction->created_at = now();
            $transaction->updated_at = now();
            $transaction->save();
    
            // Make sure we have the latest balance
            $user->refresh();
    
            DB::commit();
    
            return response()->json([
                'userName'        => $request->userName,
                'agentCode'       => $request->agentCode,
                'tpGameId'        => $request->tpGameId,
                'roundId'         => $request->roundId,
                'transactionId'   => $request->transactionId,
                'transactionType' => $request->transactionType,
                'tableCode'       => $request->tableCode,
                'balance'         => $user->balance,
                'previousAmount'  => $previousPayoff,
                'newAmount'       => $newAmount,
                'adjustment'      => $difference,
                'status'          => 0,
                'errorMessage'    => 'Resettle success',
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'userName'     => $request->userName,
                'agentCode'    => $request->agentCode,
                'status'       => 106,
                'balance'      => $user->balance ?? 0.00,
                'roundid'      => $request->roundId,
                'errorMessage' => 'Failed to resettle game',
                'error'        => $e->getMessage(),
            ], 500);
        }
    }




}  

