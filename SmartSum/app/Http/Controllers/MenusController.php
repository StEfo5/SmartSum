<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenusController extends Controller
{
    public function show(){
        $present_date = date('Y-m-d');
        $menus = DB::table('menus')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'desc')
            ->get();
        $dormitory = DB::table('registrations')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'desc')
            ->where('user_id', Auth::user()->id)
            ->where('type', 0)
            ->value('is_registration');
        $breakfast = DB::table('registrations')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'desc')
            ->where('user_id', Auth::user()->id)
            ->where('type', 1)
            ->value('is_registration');
        $dinner = DB::table('registrations')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'desc')
            ->where('user_id', Auth::user()->id)
            ->where('type', 2)
            ->value('is_registration');
        return view('menus', [
            'menus' => $menus,
            'dormitry' => $dormitory,
            'breakfast' => $breakfast,
            'dinner' => $dinner,
        ]);
    }
}
