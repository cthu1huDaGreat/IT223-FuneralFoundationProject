<?php

namespace App\Http\Controllers;

use App\Models\GetBalance; // Make sure this is imported
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $wallet = GetBalance::first();
        $balance = $wallet ? $wallet->balance : 0.00;

        return view('page.dashboard-president', compact('balance'));
    }
}