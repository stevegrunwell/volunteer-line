<?php

namespace App;

use App\Group;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define the association to the Group model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany;
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->withPivot('can_manage')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function phoneNumbers(): MorphToMany
    {
        return $this->morphToMany('App\PhoneNumber', 'callable');
    }

    /**
     * Retrieve the friendly, display name for a user.
     *
     * @return string
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->first_name . ' ' . substr($this->last_name, 0, 1) . '.';
    }
}
