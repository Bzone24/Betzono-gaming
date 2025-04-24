<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\CurlRequest;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\Phase;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Winner;
use Carbon\Carbon;
use DB;

class CronController extends Controller
{
    
     
    
    public function fetchResult()
    {

        $currentDate = date("Y-m-d");
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://matkawebhook.matka-api.online/market-data-delhi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('username' => '9501656069','API_token' => '1VpPRpGozYtINbCi','markte_name' => '','date' => $currentDate),
         
        ));

        $response = curl_exec($curl);
        curl_close($curl);
       return  json_decode($response, true);

       
}
    
    public function numberResultCron(){
        
      
        $data = $this->fetchResult();
           $currentDate = date("Y-m-d");
        
        if(isset($data['today_result']) && !empty($data['today_result'])){
              foreach($data['today_result'] as $key => $val){
     
                    $name = strtolower(str_replace(" ","_", $val['market_name']));
                    if(!DB::connection('number_prediction')->table('number_results')->where("name", $name)->where("date",$val['aankdo_date'] )->first()){
                          $resultArr = array(
                              'name'=>$name,
                              'date'=>$val['aankdo_date'],
                              'result'=>$val['jodi'],
                              'created_at'=>date("Y-m-d H:i:s")
                              
                              );
                              DB::connection('number_prediction')->table('number_results')->insert($resultArr);
                    }
                    //update result 
                    $allGames = DB::connection('number_prediction')->table('games')->where('linked_game',$name)->get();  
                    foreach($allGames as $k => $v)
                    {
                        if(!DB::connection('number_prediction')->table('result')->where("GAME_ID", $v->ID)->where('DATE', $currentDate)->first()){
                            $inserArr = array('GAME_ID' => $v->ID ,'RESULT1' => $val['jodi'] ,'RESULT2'=>0, 'DATE' => $currentDate);
                            DB::connection('number_prediction')->table('result')->insert($inserArr);;
         
                        }    
                        
                    }
        
      
                       
                       
               
                  
              }
              
              
        } 
        
        
        
       
              
        
    }
   
    public function cron()
    {
        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');

        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', Status::YES);
        }
        $crons = $crons->get();
        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];
                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds($cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->target == 'all') {
            $notify[] = ['success', 'Cron executed successfully'];
            return back()->withNotify($notify);
        }
        if (request()->alias) {
            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }
    }

    private function declareWinner(){
        $phases = Phase::where('status', Status::ENABLE)->with('tickets', 'tickets.user', 'tickets.lottery', 'lottery.bonuses', 'tickets.phase', 'lottery')->where('draw_status', Status::RUNNING)->where('draw_type', Status::AUTO)->where('draw_date', '<=', Carbon::now())->get();

        foreach ($phases as $phase) {
            $lotteryBonus = $phase->lottery->bonuses;
            if ($phase->tickets->count() <= 0 && (clone $lotteryBonus)->count() <= 0) {
                continue;
            }
            $ticketNumber    = $phase->tickets->pluck('ticket_number');
            $winBonus        = clone $lotteryBonus;
            $getTicketNumber = $ticketNumber->shuffle()->take($winBonus->count());

            $allTickets = $phase->tickets;

            foreach ($getTicketNumber as $key => $numbers) {
                $ticket = (clone $allTickets)->where('ticket_number', $numbers)->first();
                $user   = $ticket->user;
                $bonus  = $winBonus[$key]->amount;

                $winner = new Winner();
                $winner->ticket_id     = $ticket->id;
                $winner->user_id       = $user->id;
                $winner->phase_id      = $phase->id;
                $winner->ticket_number = $numbers;
                $winner->level         = @$winBonus[$key]->level;
                $winner->win_bonus     = $bonus;
                $winner->save();

                $user->balance += $bonus;
                $user->save();

                $transaction = new Transaction();
                $transaction->amount       = $bonus;
                $transaction->user_id      = $user->id;
                $transaction->charge       = 0;
                $transaction->trx          = getTrx();
                $transaction->trx_type     = '+';
                $transaction->details      = 'You are winner ' . ordinal(@$winBonus[$key]->level) . ' of ' . @$ticket->lottery->name . ' of phase ' . @$ticket->phase->phase_number;
                $transaction->remark       = 'win_bonus';
                $transaction->post_balance = $user->balance;
                $transaction->save();
                $phase->draw_status = Status::COMPLETE;
                $phase->save();
                $ticket->save();

                if (gs('win_commission')) {
                    levelCommission($user->id, $bonus, 'win_commission');
                }

                notify($user, 'WIN_EMAIL', [
                    'lottery'  => $ticket->lottery->name,
                    'number'   => $numbers,
                    'amount'   => $bonus,
                    'level'    => @$winBonus[$key]->level,
                    'currency' => gs('cur_text')
                ]);
            }

            $ticketPublished = Ticket::where('phase_id', $phase->id)->get();
            foreach ($ticketPublished as $val ){
                $val->status = Status::PUBLISHED;
                $val->save();
            }
        }
    }
}
