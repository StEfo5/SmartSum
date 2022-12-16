<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function division()
    {
        if (Auth::user()->type == Null){
            return redirect('/role');
        }
        else if(Auth::user()->type < 2){
            return redirect('/menus');
        }
        else{
            return redirect('/summaries');
        }
    }
}
