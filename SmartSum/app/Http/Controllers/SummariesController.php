<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DateTime;

class SummariesController extends Controller
{
    public function show($date){
        date_default_timezone_set('Asia/Yakutsk');
        $previous_date = DateTime::createFromFormat('Y-m-d', $date)->modify('-1 day')->format('Y-m-d');
        $next_date = DateTime::createFromFormat('Y-m-d', $date)->modify('+1 day')->format('Y-m-d');
        $present_date = DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y');
        $summaries = DB::table('summaries')
            ->where('date', $date)
            ->get();
        $classes = [];
        foreach($summaries as $summary){
            $classes[$summary->class_id] = DB::table('education_classes')
                ->where('id', $summary->class_id)
                ->value('name');
        }

        $class_summary = DB::table('summaries')
            ->where([
                ['date', $date],
                ['class_id', Auth::user()->class_id]
            ])->first();

        $dormitory_students = DB::table('users')
            ->where([
                ['class_id', Auth::user()->class_id],
                ['type', 1]
            ])->get();
        for ($i = 0; $i < count($dormitory_students); $i++){
            $dormitory_students[$i]->is_registration = DB::table('registrations')
                ->where([
                    ['date', $date],
                    ['user_id', $dormitory_students[$i]->id],
                ])->value('is_registration');
            $dormitory_students[$i]->is_confirmed = DB::table('registrations')
                ->where([
                    ['date', $date],
                    ['user_id', $dormitory_students[$i]->id],
                ])->value('is_confirmed');
        }

        $city_students = DB::table('users')
            ->where([
                ['class_id', Auth::user()->class_id],
                ['type', 2],
            ])->get();
        for ($i = 0; $i < count($city_students); $i++){
            $city_students[$i]->breackfast = DB::table('registrations')
                ->where([
                    ['date', $date],
                    ['user_id', $city_students[$i]->id],
                    ['type', 1],
                ])->value('is_registration');
            $city_students[$i]->entree = DB::table('registrations')
                ->where([
                    ['date', $date],
                    ['user_id', $city_students[$i]->id],
                    ['type', 2],
                ])->value('is_registration');
            $city_students[$i]->second_course = DB::table('registrations')
                ->where([
                    ['date', $date],
                    ['user_id', $city_students[$i]->id],
                    ['type', 3],
                ])->value('is_registration');
            $city_students[$i]->is_confirmed = DB::table('registrations')
                ->where([
                    ['date', $date],
                    ['user_id', $city_students[$i]->id],
                    ['type', 1],
                ])->value('is_confirmed');
        }
        return view('summaries.show', [
            'summaries' => $summaries,
            'class_summary' => $class_summary,
            'classes' => $classes,
            'previous_date' => $previous_date,
            'next_date' => $next_date,
            'present_date' => $present_date,
            'dormitory_students' => $dormitory_students,
            'city_students' => $city_students,
            'date' => $date,
        ]);
    }

    public function confirm(Request $request){
        DB::table('summaries')
            ->where([
                ['date', $request->date],
                ['class_id', Auth::user()->class_id],
            ])->update(['is_confirmed' => true]);
        return Redirect::route('summaries.show')->with('status', 'summery_updated');
    }
}
