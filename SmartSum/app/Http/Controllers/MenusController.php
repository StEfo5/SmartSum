<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Summary;
use App\Models\Registration;
use DateTime;
use DateTimeInterface;
class MenusController extends Controller
{
    public function show(){
        date_default_timezone_set('Asia/Yakutsk');
        $present_date = date('Y-m-d');
        $menus = DB::table('menus')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'asc')
            ->get();
        $dormitory = DB::table('registrations')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'asc')
            ->where('user_id', Auth::user()->id)
            ->where('type', 0)
            ->pluck('is_registration');
        $breakfast = DB::table('registrations')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'asc')
            ->where('user_id', Auth::user()->id)
            ->where('type', 1)
            ->pluck('is_registration');
        $entree = DB::table('registrations')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'asc')
            ->where('user_id', Auth::user()->id)
            ->where('type', 2)
            ->pluck('is_registration');
        $second_course = DB::table('registrations')
            ->where('date', '>=', $present_date)
            ->orderBy('date', 'asc')
            ->where('user_id', Auth::user()->id)
            ->where('type', 3)
            ->pluck('is_registration');
        $dates = [];
        $days = ['Понедельник', "Втроник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресение"];
        for ($i = 0; $i < count($menus); $i++){
            $date = new DateTime($menus[$i]->date);
            $dates[$i]['l'] = $days[$date->format('N')-1];
            $dates[$i]['full'] = $date->format('d.m.Y');
        }
        return view('menus.show', [
            'menus' => $menus,
            'dormitory' => $dormitory,
            'breakfast' => $breakfast,
            'entree' => $entree,
            'second_course' => $second_course,
            'dates' => $dates,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'date' => ['required', 'unique:menus'],
        ]);

        $menu = new Menu();
        $menu->dormitory_breakfast   = $request->dormitory_breakfast;
        $menu->dormitory_dinner      = $request->dormitory_dinner;
        $menu->afternoon_snack       = $request->afternoon_snack;
        $menu->supper                = $request->supper;
        $menu->city_breakfast        = $request->city_breakfast;
        $menu->entree                = $request->entree;
        $menu->second_course         = $request->second_course;
        $menu->date                  = $request->date;
        $menu->save();

        $classes = DB::table('education_classes')
            ->get();
        foreach($classes as $class){
            $last_summary = DB::table('summaries')
                ->where('class_id', $class->id)
                ->orderBy('date', 'desc')
                ->get();
            $summary = new Summary();
            if(count($last_summary)!=0){
                $last_summary = $last_summary[0];
                $summary->dormitory     = $last_summary->dormitory;
                $summary->city          = $last_summary->city;
                $summary->breakfast     = $last_summary->breakfast;
                $summary->dinner        = $last_summary->dinner;
                $summary->entree        = $last_summary->entree;
                $summary->second_course = $last_summary->second_course;
            }
            $summary->date          = $request->date;
            $summary->class_id      = $class->id;
            $summary->save();
        }

        $dormity_students = DB::table('users')
            ->where('type', 1)
            ->get();
        foreach($dormity_students as $student){
            $registration = new Registration();
            $last_registration = DB::table('registrations')
                ->where('user_id', $student->id)
                ->orderBy('date', 'desc')
                ->get();
            if(count($last_registration)!=0){
                $last_registration = $last_registration[0];
                $registration->is_registration = $last_registration->is_registration;
            }
            $registration->user_id = $student->id;
            $registration->type    = 0;
            $registration->date    = $request->date;
            $registration->save();
        }

        $city_students = DB::table('users')
            ->where('type', 2)
            ->get();
        foreach($city_students as $student){
            for ($i = 1; $i <= 3; $i++) {
                $registration = new Registration();
                $last_registration = DB::table('registrations')
                    ->where('user_id', $student->id)
                    ->where('type', $i)
                    ->orderBy('date', 'desc')
                    ->get();
                if(count($last_registration)!=0){
                    $last_registration = $last_registration[0];
                    $registration->is_registration = $last_registration->is_registration;
                }
                $registration->user_id = $student->id;
                $registration->type    = $i;
                $registration->date    = $request->date;
                $registration->save();
            }
        }

        return Redirect::route('menus.show')->with('status', 'menu-added');
    }

    public function registration(Request $request){
        if(Auth::user()->type == 1){
            $dormitory = DB::table('registrations')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['date', $request->date],
                    ['type', 0],
                ])->value('is_registration');
            $summary_dormitory = DB::table('summaries')
                ->where([
                    ['class_id', Auth::user()->class_id],
                    ['date', $request->date],
                ])->value('dormitory');
            DB::table('summaries')
                ->where([
                    ['class_id', Auth::user()->class_id],
                    ['date', $request->date],
                ])->update([
                    'dormitory' => $summary_dormitory + $request->dormitory - $dormitory,
                ]);
            DB::table('registrations')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['date', $request->date],
                    ['type', 0],
                ])->update([
                    'is_registration' => $request->dormitory,
                    'is_confirmed' => true,
                ]);
        }
        else{
            $breakfast = DB::table('registrations')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['date', $request->date],
                    ['type', 1],
                ])->value('is_registration');
            $entree = DB::table('registrations')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['date', $request->date],
                    ['type', 2],
                ])->value('is_registration');
            $second_course = DB::table('registrations')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['date', $request->date],
                    ['type', 3],
                ])->value('is_registration');
            $summary = DB::table('summaries')
                ->where([
                    ['class_id', Auth::user()->class_id],
                    ['date', $request->date],
                ])->first();

            DB::table('summaries')
                ->where([
                    ['class_id', Auth::user()->class_id],
                    ['date', $request->date],
                ])->update([
                    'breakfast' => $summary->breakfast + $request->breakfast - $breakfast,
                    'entree' => $summary->entree + $request->entree - $entree,
                    'second_course' => $summary->second_course + $request->second_course - $second_course,
                    'city' => $summary->city + min(1, $request->breakfast + $request->entree + $request->second_course) - min(1, $breakfast + $entree + $second_course),
                    'dinner' => $summary->dinner + min(1, $request->entree + $request->second_course) - min(1, $entree + $second_course),
                ]);
            DB::table('registrations')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['date', $request->date],
                    ['type', 1],
                ])->update([
                    'is_registration' => $request->breakfast,
                    'is_confirmed' => true,
                ]);
            DB::table('registrations')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['date', $request->date],
                    ['type', 2],
                ])->update([
                    'is_registration' => $request->entree,
                    'is_confirmed' => true,
                ]);
            DB::table('registrations')
                ->where([
                    ['user_id', Auth::user()->id],
                    ['date', $request->date],
                    ['type', 3],
                ])->update([
                    'is_registration' => $request->second_course,
                    'is_confirmed' => true,
                ]);
        }
        return Redirect::route('menus.show')->with('status', 'registration-updated');
    }
}
