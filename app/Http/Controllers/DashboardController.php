<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        //$admin = Auth::user();
        //$userCount = User::count();
        //$adCount = Ad::count();
        return view('dashboard.index');
    }
}
