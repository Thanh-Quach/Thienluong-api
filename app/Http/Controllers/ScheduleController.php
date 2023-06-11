<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\MeetingSchedule;

class ScheduleController extends Controller
{
  public function store (Request $data) {

    MeetingSchedule::create([
        'uid'=>Controller::v5(Controller::v4(), time()),
        'name'=>$data->name,
        'birthday'=>$data->birthday,
        
        'meeting-date'=>$data->meetingdate,
        'meeting-method'=>$data->meetingmethod,
        'note'=>$data->note,

        'phone'=>$data->phone,
        'email'=>$data->email,
        'date-create'=>time(),
      ]);

      return response()->json(['Success' => 'Meeting created'], 200);
    }

  public function show ($userid) {
    if(Controller::tokenValidate()){
      return MeetingSchedule::where('uid', $userId)
      ->first();
    };
  }
  
  public function index () {
    if(Controller::tokenValidate()){
      return MeetingSchedule::all();
    };
  }
  
  public function destroy ($uid) {
    if(Controller::tokenValidate()){
      return MeetingSchedule::where('uid',$uid)
      ->delete();
    };
  }
}
