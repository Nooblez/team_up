<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use App\Mail\UserSubmit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TeamController extends Controller
{
    public function show(Request $request, $id){
    	$team = Team::find($id);
    	$users = $team->allUsers();

    	foreach ($users as $user) {
    	}

    	return view('teams.show')->with([
    		'users' => $request->user,
    		'team' => Team::find($id)
    	]);
    }

    public function profile($id){
        return view('teams.profile')->with('team', Team::find($id));
    }

    public function add($team, $user, $role){
        $find_team = Team::find($team);
        $find_user = User::where('email', $user)->first();
        $what_role = Role::find($role);

        if (!$find_team->users()->contains($find_user)) {
            $db = DB::insert('insert into team_user (team_id, user_id, role_id) values ('. $find_team->id . ', '. $find_user->id .', '. $what_role->id .')');
        }else{
            Log::debug('ciao');
        }
    }

    public function getMembers($team){
        $response = Team::find($team)->users;

        return response()->json(['labels' => $response]);
    }

    public function getLeader($team_id){
        return response()->json(User::find(Team::find($team_id)->user_id));
    }

    public function submit($team_id){
        $team = Team::find($team_id);
        $emails = ['adripalumbo95@rocketmail.com'];

        $users = DB::table('team_user')
            ->select('user_id')
            ->where('role_id', 1)
            ->where('team_id', $team_id)
            ->get();

        foreach ($users as $user) {
            array_push($emails, $user->email);
        }

        foreach ($emails as $email) {
            Mail::to($email)->send(new UserSubmit(Auth::user()->name, $team->name));
        }
    }
}
