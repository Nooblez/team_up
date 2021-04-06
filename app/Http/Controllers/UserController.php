<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home(){
    	return redirect()->route('dashboard');
    }

    public function get_bio(){
    	return response()->json(Auth::user()->user_bio);
    }

    public function update_bio($data){
    	$user = Auth::user();
    	$user->user_bio = $data;
    	$user->save();
    	return response()->json($data);
    }
}
