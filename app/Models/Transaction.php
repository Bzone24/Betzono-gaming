<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Transaction extends Model
{
    const TYPE_ADMIN_ADD = 'ADMIN_ADD';
    const TYPE_ADMIN_WITHDRAW = 'ADMIN_WITHDRAW';
    const TYPE_AGENT_ADD = 'AGENT_ADD';
    const TYPE_AGENT_SUB_USER_ADD = 'AGENT_SUB_USER_ADD';
    const TYPE_AGENT_WITHDRAW = 'AGENT_WITHDRAW';
    const TYPE_AGENT_ADD_USER_WITHDRAW = 'AGENT_ADD_USER_WITHDRAW';
    const TYPE_USER_TRANSFER_OUT = 'USER_TRANSFER_OUT';
    const TYPE_USER_TRANSFER_IN = 'USER_TRANSFER_IN';
    const TYPE_USER_DEPOSIT = 'USER_DEPOSIT';
    const TYPE_USER_WITHDRAW = 'USER_WITHDRAW';
    const TYPE_USER_BET_VKINGPLAYS = 'USER_BET_VKINGPLAYS';
    const TYPE_USER_BET_SPORTSGAME = 'USER_BET_SPORTSGAME';
    

    public static function getTypeOptions(): array
    {
        return [
            self::TYPE_ADMIN_ADD,
            self::TYPE_ADMIN_WITHDRAW,
            self::TYPE_AGENT_ADD,
            self::TYPE_AGENT_SUB_USER_ADD,
            self::TYPE_AGENT_WITHDRAW,
            self::TYPE_AGENT_ADD_USER_WITHDRAW,
            self::TYPE_USER_TRANSFER_OUT,
            self::TYPE_USER_TRANSFER_IN,
            self::TYPE_USER_DEPOSIT,
            self::TYPE_USER_WITHDRAW,
        ];
    }

    public static function getOptionList(): array
    {
        return [
            self::TYPE_ADMIN_ADD => __('Admin Added'),
            self::TYPE_ADMIN_WITHDRAW => __('Admin Withdraw'),
            self::TYPE_AGENT_ADD => __('Agent Added'),
            self::TYPE_AGENT_SUB_USER_ADD => __('Transfer to user'),
            self::TYPE_AGENT_WITHDRAW => __('Agent Withdraw'),
            self::TYPE_AGENT_ADD_USER_WITHDRAW => __('Transfer from user'),
            self::TYPE_USER_TRANSFER_OUT => __('Transfer Out'),
            self::TYPE_USER_TRANSFER_IN => __('Transfer In'),
            self::TYPE_USER_DEPOSIT => __('User Deposited'),
            self::TYPE_USER_WITHDRAW => __('User Withdrawal'),
            self::TYPE_USER_BET_VKINGPLAYS => __('-'),
            self::TYPE_USER_BET_SPORTSGAME => __('-'),
        ];
    }

    public static function getTypeName($type): string
    {
        $types = self::getOptionList();
        return $types[$type] ?? __('--');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function otherUser()
    {
        return $this->belongsTo(User::class, 'other_id', 'id');
    }
    public function getCasinoBetHistoryInfo()
    {
        return  DB::table('casino_bets_history')->where("transactionId", $this->trx)->first();
    }

    public function getCasinoBetSettleHistoryInfo()
    {
        return  DB::table('casino_game_settlements_history')->where("transactionId", $this->trx)->first();
    }


    public function getSportsBetHistoryInfo()
    {
        return  DB::table('sports_bets_history')->where("transactionId", $this->trx)->first();
    }
}
