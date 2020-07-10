<?php

namespace CarroPublic\Follow;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'likeable_type',
        'likeable_id',
        'user_id',
    ];

    /**
     * Followable
     *
     * @return mixed
     */
    public function followable()
    {
        return $this->morphTo();
    }

    /**
     * Follower
     *
     * @return mixed
     */
    public function follower()
    {
        return $this->belongsTo($this->getAuthModelName(), 'user_id');
    }

    /**
     * Get auth model name
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected function getAuthModelName()
    {
        if (config('follow.user_model')) {
            return config('follow.user_model');
        }

        if (!is_null(config('auth.providers.users.model'))) {
            return config('auth.providers.users.model');
        }

        throw new Exception('Could not determine the follower model name.');
    }
}
