<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDO;

class NotificationController extends Controller
{
    public function summary(Request $request){
        $telegram_id = DB::table('users')
            ->where([
                ['class_id', $request->class_id],
                ['role', 1],
            ])->pluck('telegram_id');
        $api_token = '5971157491:AAGR5y1mPCmxxKyv-QRET4ZdIRLarar0Ud8';
        foreach($telegram_id as $item){
            $data = [
                'chat_id' => $item,
                'text' => 'Отправьте сводку питания',
            ];
            $response = file_get_contents("https://api.telegram.org/bot$api_token/sendMessage?" . http_build_query($data));    
        }
        return redirect()->back()->with('status', 'notification_sent');
    }

    public function user(Request $request){
        $telegram_id = DB::table('users')
            ->where([
                ['id', $request->user_id],
            ])->value('telegram_id');
        $api_token = '5971157491:AAGR5y1mPCmxxKyv-QRET4ZdIRLarar0Ud8';
        $data = [
            'chat_id' => $telegram_id,
            'text' => 'Подтвердите питание',
        ];
        $response = file_get_contents("https://api.telegram.org/bot$api_token/sendMessage?" . http_build_query($data));    
        return redirect()->back()->with('status', 'notification_sent');
    }
}
