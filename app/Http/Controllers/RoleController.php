<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function get($role){
    	$response = '';

    	if ($role == 'all') 
    		$response = Role::all();
    	else
    		$response = Role::find($role);

    	return response()->json($response);
    }
}
