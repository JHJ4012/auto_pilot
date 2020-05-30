<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AppCallController extends Controller
{
    // 메인페이지에서 호출하기 클릭
    public function call(){
        $station_all = DB::table('station')
                        ->get();
        
        debug($station_all);
        return response()->json(['station_all'=>$station_all]);
    }

    // 유저확인(동명이인)
    public function check_user($id){
        debug($id);
        $same_user = DB::table('user')
                        ->select('user_id','user_name','user_phone')
                        ->where('user_name', $id)
                        ->get();
                        
        debug($same_user);
        return response($same_user);
    }

    // qr_code
    public function qr_user_check($id){
        $qr_user = DB::table('dlvy')
                        ->select('dlvy_sender','dlvy_receiver')
                        ->where('dlvy_num', $id)
                        ->first();

        return response()->json([
            'qr_receiver' => $qr_user->dlvy_receiver,
            'qr_sender' => $qr_user->dlvy_sender
        ]);
    }

    // 채크포인트
    public function dlvy_checkpoint($start_point, $end_point){
        debug($start_point, $end_point);
        $path_id= DB::table('path')
                    ->where('path.path_start_point', $start_point)
                    ->where('path.path_end_point',$end_point)
                    ->value('path_id');

        return $checkpoint = DB::table('checkpoint')
                    ->select('checkpoint_id','checkpoint_lat', 'checkpoint_lon')
                    ->join('path_check', (fn($join)=>
                            $join->on('checkpoint.checkpoint_id','=','path_check.check_id')
                                ->where('path_check.path_col_id', $path_id)
                    ))
                    ->get();
        
    }


}
