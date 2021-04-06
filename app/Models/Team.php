<?php

namespace App\Models;

use App\Models\User;
use App\Models\Label;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the date the team was created.
     *
     * @return 
     */
    public function isPersonalTeamAttribute()
    {
        return $this->personal_team;
    }

    /**
    * Logica many-to-many: 
    * ogni utente può avere una quantità di Label indefinita
    *
    */
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
