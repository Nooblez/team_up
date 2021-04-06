<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function get(){
    	$logged_user = Auth::user();
    	$teams = Team::all();
    	$response = [];

    	foreach($teams as $team){
    		//Log::debug($team->allUsers());
    		foreach ($team->allUsers() as $user) {
    			//Log::debug($user);
    			if ($user['id'] == $logged_user->id) {
    				break;
    			}else{
    				foreach ($logged_user->labels as $label) {
    					foreach ($team->labels as $team_label) {
    						if($team_label->id == $label->id)
    							array_push($response, $team);
    					}
    					if (in_array($team, $response))
    						break;
    				}
    			}
    		}
    	}

    	return response()->json($response);
    }
}
