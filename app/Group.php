<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Builder;
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
        return $this->belongsToMany(User::class)
            ->withPivot('can_manage')
            ->withTimestamps();
    }

    /**
     * Scope the query to groups the given user can manage.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeManageable(Builder $query): Builder
    {
        $userRelationshipLoaded = collect($query->getQuery()->joins)
            ->pluck('table')
            ->contains('group_user');

        return $query->when($userRelationshipLoaded, function ($query) {
            return $query->where('group_user.can_manage', true);
        });
    }
}
