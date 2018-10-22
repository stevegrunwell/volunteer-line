<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class PhoneNumber extends Model
{
    public function groups(): MorphToMany
    {
        return $this->morphedByMany('App\Group', 'callable');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany('App\User', 'callable');
    }
}
