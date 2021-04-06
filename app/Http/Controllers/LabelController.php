<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Label;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LabelController extends Controller
{
	public function create(){
	   return view('labels.create-label');
    }

    public function get(){
        return response()->json(['labels' => Label::all()]);
    }

    public function getNew(){
        $labels = Label::all();

        return view('labels.get-label')->with('labels', $labels);
    }

    public function getNewTeam($team){
        $labels = Label::all();

        return view('teams.add-label')->with(['team' => $team, 'labels' => $labels]);
    }

    public function getTeam($team){
        $labels = Team::find($team)->labels;

        return response()->json(['labels' => $labels]);
    }

    public function getLeader($team){
        $labels = Team::find($team)->labels;

        return response()->json(['labels' => $labels]);
    }
    
    public function newLabel(Request $request){
        //inizializzo variabili
        $newLabel = new Label();

        //creo campi da inserire nel db            
        $newLabel->label_name = $request->input('name');
        $newLabel->label_description = $request->input('description');

        $newLabel->save();
        
        return redirect(route('labels.success'));
    }

    public function success(){
        return view('labels.success');
    }

    public function obtain($id){
        $label = Label::find($id+1);
        $user = Auth::user();
        
        $user = User::find($user->id);
        $user->labels()->attach($label->id);

        return redirect(route(('dashboard')));
    }

    public function team_obtain($team, $id){
        Log::debug('obtain');
        $label = Label::find($id+1);
        $team_update = Team::find($team);
        Log::debug($team_update);
        $team_update->labels()->attach($label->id);

        $team_update->save();

        return redirect(route('myteams.show', $team));
    }

    public function label_user(){
        $user_labels = Auth::user()->labels;
        $response = [];
        foreach ($user_labels as $label) {
            $response[] = [
                'id' => $label->id,
                'name' => $label->label_name,
            ];
        }
        return response()->json($response);
    }

    public function label_detach($id){
        $user = Auth::user();
        $user->labels()->detach($id);
    }

    public function label_team_detach($team_id, $id){
        $team = Team::find($team_id);
        $team->labels()->detach($id);
    }
}
