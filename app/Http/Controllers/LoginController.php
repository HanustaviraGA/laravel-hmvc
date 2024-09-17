<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;

class LoginController extends Controller
{
    public function login_aksi(Request $request){
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $data = $request->all();
        $cred = [
            'email' => $data['email'],
            'password' => $data['password']
        ];
        if(Auth::attempt($cred)){
            return response()->json(['message' => 'success'], 200);
        }else{
            return response()->json(['message' => 'failed'], 401);
        }
    }

    public function logout_aksi(){
        Session::flush();
        Auth::logout();
        return response()->json(['message' => 'success'], 200);
    }
}
