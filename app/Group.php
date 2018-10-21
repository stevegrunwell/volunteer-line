<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $casts = [
        'created_by' => 'int',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Define the association to the Group model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany;
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
