<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionLog;
use App\Models\NotificationLog;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\UserLogin;
use App\Models\Winner;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    public function transaction(Request $request, $userId = null)
    {
        $pageTitle = 'Transaction Logs';

        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::searchable(['trx','user:username'])->filter(['trx_type','remark','type'])->dateFilter()->orderBy('id', 'desc')->with('user');

        if ($userId) {
            $transactions = $transactions->where('user_id', $userId);
        }
        $transactions = $transactions->paginate(getPaginate());
        $getTypeOptions = Transaction::getTypeOptions();
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'remarks', 'getTypeOptions'));
    }
    public function exportTransaction(Request $request, $userId = null)
    {
        $transactionsQuery = Transaction::searchable(['trx', 'user:username'])
            ->filter(['trx_type', 'remark', 'type'])
            ->dateFilter()
            ->orderBy('id', 'desc')
            ->with('user');

        if ($userId) {
            $transactionsQuery->where('user_id', $userId);
        }

        $transactions = $transactionsQuery->get(); // Fetch all transactions for export
        //header for the CSV file
        $headerRow = [
            'Full Name',
            'Username',
            'Transaction ID',
            'Date',
            'Transaction Type',
            'Amount',
            'Post Balance',
            'Type Name',
            'Details',
            'Sport',
            'Event',
            'Market',
            'Runner',
            'Type',
            'Rate',  
        ];

        // Prepare the array for export
        $finalArr = [];
        $transactions->each(function ($trx) use (&$finalArr) {
            $baseData = [
            $trx->user->fullname ?? 'N/A',
            $trx->user->username ?? 'N/A',
            $trx->trx,
            showDateTime($trx->created_at),
            $trx->trx_type,
            showAmount($trx->amount),
            showAmount($trx->post_balance),
            \App\Models\Transaction::getTypeName($trx->type),
            $trx->details,



            $trx->getSportsBetHistoryInfo() ? $trx->getSportsBetHistoryInfo()->eventTypeName ?? '' : ($trx->getSportBetSettleHistoryInfo() ? $trx->getSportBetSettleHistoryInfo()->eventTypeName ?? '' : ''),

            $trx->getSportsBetHistoryInfo() ? $trx->getSportsBetHistoryInfo()->eventName ?? '' : ($trx->getSportBetSettleHistoryInfo() ? $trx->getSportBetSettleHistoryInfo()->eventName ?? '' : ''),
            $trx->getSportsBetHistoryInfo() ? $trx->getSportsBetHistoryInfo()->marketName ?? '' : ($trx->getSportBetSettleHistoryInfo() ? $trx->getSportBetSettleHistoryInfo()->marketName ?? '' : ''),
            $trx->getSportsBetHistoryInfo() ? $trx->getSportsBetHistoryInfo()->runnerName ?? '' : ($trx->getSportBetSettleHistoryInfo() ? $trx->getSportBetSettleHistoryInfo()->runnerName ?? '' : ''),
            $trx->getSportsBetHistoryInfo() ? $trx->getSportsBetHistoryInfo()->betType ?? '' : ($trx->getSportBetSettleHistoryInfo() ? $trx->getSportBetSettleHistoryInfo()->betType ?? '' : ''),
            $trx->getSportsBetHistoryInfo() ? $trx->getSportsBetHistoryInfo()->rate ?? '' : ($trx->getSportBetSettleHistoryInfo() ? $trx->getSportBetSettleHistoryInfo()->rate ?? '' : ''),
             

 




            
            ];
            $finalArr[] = $baseData;
        });

        // Export the data using Maatwebsite Excel
        return Excel::download(new class($headerRow, $finalArr) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $headerRow;
            private $data;

            public function __construct($headerRow, $data)
            {
            $this->headerRow = $headerRow;
            $this->data = $data;
            }

            public function array(): array
            {
            return $this->data;
            }

            public function headings(): array
            {
            return $this->headerRow;
            }
        }, 'transactions.xlsx', ExcelFormat::XLSX);
        
       
    }

    public function gamezoneTransaction(Request $request, $userId = null)
    {
        $pageTitle = 'Gamezone Logs';

        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::searchable(['trx', 'user:username'])
            ->filter(['trx_type', 'remark'])
            ->dateFilter()
            ->orderBy('id', 'desc')
            ->with('user');

        // Where for TYPE_USER_TRANSFER_OUT or TYPE_USER_TRANSFER_IN
        $transactions = $transactions->where(function ($query) {
            $query->where('type', Transaction::TYPE_USER_TRANSFER_OUT)
                  ->orWhere('type', Transaction::TYPE_USER_TRANSFER_IN);
        });

        if ($userId) {
            $transactions = $transactions->where('user_id', $userId);
        }

        $transactions = $transactions->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }


    public function loginHistory(Request $request)
    {
        $pageTitle = 'User Login History';
        $loginLogs = UserLogin::orderBy('id', 'desc')->searchable(['user:username'])->dateFilter()->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs', 'ip'));
    }

    public function notificationHistory(Request $request)
    {
        $pageTitle = 'Notification History';
        $logs = NotificationLog::orderBy('id', 'desc')->searchable(['user:username'])->dateFilter()->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs'));
    }

    public function emailDetails($id)
    {
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle', 'email'));
    }

    public function commissions()
    {
        $pageTitle = 'Commission History';
        $logs = CommissionLog::searchable(['trx','userTo:username'])->filter(['commission_type'])->dateFilter()->with(['userTo','userFrom'])->latest()->paginate(getPaginate());
        return view('admin.reports.commission_log', compact('pageTitle', 'logs'));
    }


    public function winners()
    {
        $pageTitle = "All Winners";
        $winners = Winner::searchable(['user:username','ticket_number'])->orderBy('id', 'desc')->with(['tickets','tickets.user','tickets.lottery','tickets.phase'])->paginate(getPaginate());
        return view('admin.reports.winners', compact('pageTitle', 'winners'));
    }


    public function tickets()
    {
        $pageTitle = 'All Sold Lottery Tickets';
        $tickets = Ticket::searchable(['user:username'])->orderBy('id', 'desc')->with('user', 'lottery', 'phase')->paginate(getPaginate());
        return view('admin.reports.tickets', compact('pageTitle', 'tickets'));
    }
}
