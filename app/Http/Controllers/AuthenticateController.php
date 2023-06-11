<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;

class AuthenticateController extends Controller
{
    public  function authenticate(Request $data){
        // validate login
        if (Auth::attempt($data->only('username','password'))) {
          return JWT::encode(array('uid'=>Auth::user()->uid,'name'=>Auth::user()->username),'ThienLuong','HS512');;
        }else{
            return response()->json(['Failed' => 'Unauthorize'], 403);
        }
    }

}
