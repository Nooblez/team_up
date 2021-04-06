<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Label extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'label_name', 'label_description'
    ];

    /**
    * Logica many-to-many: 
	* Gli utenti che hanno la label
	*
    */

	public function users()
    {
        return $this->belongsToMany(User::class);
    }
	
	/**
    * Logica many-to-many: 
	* Gli utenti che hanno la label
	*
    */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    

    /*
    * Funzione per controllare se la label è competenza del team
    *
    */
    public function isField(Team $team)
    {

    }

}
