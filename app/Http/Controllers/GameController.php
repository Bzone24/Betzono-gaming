<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Phase;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\Ticket;
use App\Models\OtherGames;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use DB;

class GameController extends Controller
{
    public function playGame($gameslug)
    {
      
        if (!empty($gameslug)) {
            $gameDetails = OtherGames::where('slug', $gameslug)->where('status', 1)->first();
            if ($gameDetails) {
                $user = auth()->user();
            
             //check user exists
                $userExists = false;
                if ($gameslug == 'number_prediction') {
                    $userExists = DB::connection($gameslug)->table('USERS')->where("EMAIL", $user->email)->first();
        
                } elseif ($gameslug == 'aviator') {
                    $userExists = DB::connection($gameslug)->table('users')->where("email", $user->email)->first();
                } elseif ($gameslug == 'color_prediction') {
                    $userExists = DB::connection($gameslug)->table('users')->where("phone", $user->mobile)->first();
                }
                if (!$userExists) {
                    if ($gameslug == 'number_prediction') {
                        $userData = array (
                            "NAME" => $user->firstname . " " . $user->lastname  ,
                            "EMAIL" => $user->email  ,
                            "MOBILE" => $user->mobile ,
                            "WALLET" => $user->balance,
                            "PASSWORD" => bcrypt(123456),
                        );
                        DB::connection($gameslug)->table('USERS')->insert($userData);
                        $userExists = DB::connection($gameslug)->table('USERS')->where("EMAIL", $user->email)->first();
                        $redirectUrl = $gameslug . '/autologin.php?id=' . $userExists->ID;
                    } elseif ($gameslug == 'aviator') {
                        $userData = array (
                            "name" => $user->firstname . "-" . $user->lastname  ,
                            "email" => $user->email  ,
                            "mobile" => $user->mobile ,
                            "password" => bcrypt(123456),
                            "country" => $user->country_code,
                            "currency" => "₹",
                            "isadmin" => 0,
                            "confirm_password" => 123456,
                            "status" => 1,
                            "created_at" => date("Y-m-d H:i:s")
                        );

                        DB::connection($gameslug)->table('users')->insert($userData);
                        $userExists = DB::connection($gameslug)->table('users')->where("email", $user->email)->first();
                        //update balance
                        DB::connection($gameslug)->table('wallets')->insert(['userid' => $userExists->id,"amount" => $user->balance, "created_at" => date("Y-m-d H:i:s")]);
                       
                        $redirectUrl = $gameslug . '/autologin/' . $userExists->id;
                    } elseif ($gameslug == 'color_prediction') {
                        $userData = array (
                            "name_user" => $user->firstname . "" . $user->lastname  ,
                            "id_user" => rand(10000, 99999),
                            "phone" => $user->mobile ,
                            "money" => $user->balance,
                            "password" => md5(123456),
                            'plain_password' => 123456,
                            'status' => 1,
                            'veri' =>1,
                            'time'=> time()
                            
                        );
                        DB::connection($gameslug)->table('users')->insert($userData);
                        $userExists = DB::connection($gameslug)->table('users')->where("phone", $user->mobile)->first();
                        $redirectUrl =  'https://cp.stakeye.com/autologin/' . $userExists->id;
                    }
                } else {
                    if ($gameslug == 'number_prediction') {
                        $userData = array (
                             "WALLET" => $user->balance
                          );
                        DB::connection($gameslug)->table('USERS')->where("ID", $userExists->ID)->update($userData);
                        $userExists = DB::connection($gameslug)->table('USERS')->where("EMAIL", $user->email)->first();
                        $redirectUrl = $gameslug . '/autologin.php?id=' . $userExists->ID;
                    } elseif ($gameslug == 'aviator') {
                        $userExists = DB::connection($gameslug)->table('users')->where("email", $user->email)->first();
                        DB::connection($gameslug)->table('wallets')->where('userid', $userExists->id)->update(["amount" => $user->balance, "created_at" => date("Y-m-d H:i:s")]);
                        $redirectUrl = $gameslug . '/autologin/' . $userExists->id;
                    } elseif ($gameslug == 'color_prediction') {

                        $userExists = DB::connection($gameslug)->table('users')->where("phone", $user->mobile)->first();

                        DB::connection($gameslug)->table('users')->where('id', $userExists->id)->update(["money" => $user->balance]);
                          $redirectUrl =  'https://cp.stakeye.com/autologin/' . $userExists->id;
                          return redirect($redirectUrl);
                     }
                }
                 
                return redirect(url($redirectUrl));
            } else {
                $notify[] = ['error','Game is not avialable right now.'];
                return back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error','Game is not avialable  right now.'];
            return back()->withNotify($notify);
        }
    }

    public function fundTransferToGame(Request $request, $type, $gameslug)
    {

      
        if (!empty($gameslug)) {
            $gameDetails = OtherGames::where('slug', $gameslug)->where('status', 1)->first();
            if ($gameDetails) {
                if ($request->isMethod('POST')) {
                    $type  = $request->input('type');
                    $amount  = $request->input('amount');
                    if ($type == 'addtogame') {
                        if (auth()->user()->balance >= $amount) {
                              $loggeInUserId = auth()->user()->id;
                              $loggedInUserEmail = auth()->user()->email;
                            //update in game wallet
                            $gameUserInfo = DB::connection($gameslug)->table("USERS")->where("EMAIL", $loggedInUserEmail)->first();
                            if ($gameUserInfo) {
                                $walletAmount = $gameUserInfo->WALLET;
                                $updatedBalance = $walletAmount + $amount;

                                DB::connection($gameslug)->table("USERS")
                                ->where('EMAIL', $loggedInUserEmail)
                                ->update(['WALLET' => $updatedBalance]);

                                DB::connection($gameslug)->table('TRANSACTIONS')->insert([
                                    'USER_ID' => $gameUserInfo->ID,
                                    'AMOUNT' => $amount,
                                    'BALANCE' => $updatedBalance,
                                    'DATE_TIME' => now(),
                                    'REMARK' => 'Fund transfer from main wallet',
                                ]);


                                //update in main value
                                $postBalance = auth()->user()->balance - $amount;
                                if ($gameslug == 'number_prediction') {
                                    $details = 'Fund transfer to satta game';
                                } else {
                                    $details = 'Fund transfer to  game';
                                }

                                DB::table('transactions')->insert([
                                    'user_id' => $loggeInUserId,
                                    'amount' => $amount,
                                    'post_balance' => $postBalance,
                                    'trx_type' => '-',
                                    'trx' => now(),
                                    'details' => $details,
                                    'remark' => $details,
                                    'type' => 'TYPE_USER_TRANSFER_OUT',
                                    'created_at' => date("Y-m-d H:i:s"),
                                ]);

                                DB::table('users')->where("id", $loggeInUserId)->update(['balance' => $postBalance]);
                                $notify[] = ['success','Requested processed successfully!'];
                                return back()->withNotify($notify);
                            }
                         
                            $notify[] = ['error','Something went wrong. Please try again!'];
                            return back()->withNotify($notify);
                          

                            //update in current wallet
                        } else {
                            $notify[] = ['error','Requested amount is insufficient!'];
                            return back()->withNotify($notify);
                        }
                    } elseif ($type == 'transferfromgame') {
                        if (auth()->user()->balance >= $amount) {
                            $loggeInUserId = auth()->user()->id;
                            $loggedInUserEmail = auth()->user()->email;
                    
                          //update in game wallet
                            $gameUserInfo = DB::connection($gameslug)->table("USERS")->where("EMAIL", $loggedInUserEmail)->first();
                            if ($gameUserInfo) {
                                $walletAmount = $gameUserInfo->WALLET;
                                $updatedBalance = $walletAmount - $amount;

                                DB::connection($gameslug)->table("USERS")
                                ->where('EMAIL', $loggedInUserEmail)
                                ->update(['WALLET' => $updatedBalance]);

                                DB::connection($gameslug)->table('TRANSACTIONS')->insert([
                                  'USER_ID' => $gameUserInfo->ID,
                                  'AMOUNT' => $amount,
                                  'BALANCE' => $updatedBalance,
                                  'DATE_TIME' => now(),
                                  'REMARK' => 'Fund transfer to main wallet',
                                ]);


                                //update in main value
                                $postBalance = auth()->user()->balance + $amount;
                                if ($gameslug == 'number_prediction') {
                                    $details = 'Fund transfer from satta game';
                                } else {
                                    $details = 'Fund transfer from  game';
                                }

                                DB::table('transactions')->insert([
                                  'user_id' => $loggeInUserId,
                                  'amount' => $amount,
                                  'post_balance' => $postBalance,
                                  'trx_type' => '+',
                                  'trx' => now(),
                                  'details' => $details,
                                  'remark' => $details,
                                  'type' => 'TYPE_USER_TRANSFER_IN',
                                  'created_at' => date("Y-m-d H:i:s"),
                                ]);

                                DB::table('users')->where("id", $loggeInUserId)->update(['balance' => $postBalance]);
                                $notify[] = ['success','Requested processed successfully!'];
                                return back()->withNotify($notify);
                            }
                       
                            $notify[] = ['error','Something went wrong. Please try again!'];
                            return back()->withNotify($notify);
                        

                          //update in current wallet
                        } else {
                            $notify[] = ['error','Requested amount is insufficient!'];
                            return back()->withNotify($notify);
                        }
                    } else {
                        $notify[] = ['error','Unable to process the request'];
                        return back()->withNotify($notify);
                    }
                }

                $user = auth()->user();
            
             //check user exists
                $userExists = DB::connection($gameslug)->table('USERS')->where("EMAIL", $user->email)->first();
                if ($type == 'addtogame') {
                    $pageTitle = 'Transfer to game';
                } else {
                    $pageTitle = 'Transfer from game';
                }
                return view('frontend.game.game-fund-transfers')->with('type', $type)->with("userExists", $userExists)->with('pageTitle', $pageTitle)->with('gameslug', $gameslug);
            } else {
                $notify[] = ['error','Game is not avialable right now.'];
                return back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error','Game is not avialable  right now.'];
            return back()->withNotify($notify);
        }
    }
}
