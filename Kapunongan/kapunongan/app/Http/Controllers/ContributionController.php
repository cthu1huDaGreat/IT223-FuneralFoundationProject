<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\GetBalance;

class ContributionController extends Controller
{
    // Member Dashboard
       public function dashboard()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        $total = DB::table('funeral_fund')
            ->where('user_id', $userId)
            ->sum('balance');

       $announcements = DB::table('announcements')   
            ->orderBy('date', 'desc')
            ->get();


        return view('page.dashboard-member', compact('total', 'announcements'));
    }

    // President Dashboard
    public function dashboardPresident()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        $totalContributions = DB::table('funeral_fund')->sum('balance');
        $totalMembers       = DB::table('users')->count();
        $totalFuneral       = 0;
        $wallet = GetBalance::first();
        $balance = $wallet ? $wallet->balance : 0.00;

        return view('page.dashboard-president', compact('totalMembers','totalContributions','totalFuneral','balance'));
    }
}