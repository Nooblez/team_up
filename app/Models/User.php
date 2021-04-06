<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use DB;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
    * Logica many-to-many: 
    * ogni utente può avere una quantità di Label indefinita
    *
    */
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
    

    /*
    * Funzione per controllare se l'utente ha labels
    *
    */
    public function hasLabels()
    {   
        $response = false;
        //estraggo la colonna con gli utenti
        $usersWithLabel = DB::table('label_user')->pluck('user_id');

        if($usersWithLabel->contains($this->get('id')))
        {
            $response = true;
        }
        return $response;
    }

    /*
    * Funzione per ottenere tutte le label dell'utente
    *
    */

    public function whatLabels()
    {   
        $userLabels = DB::table('label_user')->where('user_id', '=', $this->id)->pluck('user_id', 'label_id');
        foreach ($userLabels as $userLabel) {
            $allLabels = Label::all();
            foreach ($allLabels as $label) {
                if($userLabel->id == $label->id)
                {
                    array_push($response, $label);
                }
            }
        }
        return $response;
    }
}
