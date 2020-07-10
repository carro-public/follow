<?php

namespace CarroPublic\Follow\Traits;

trait HasFollows
{
    /**
     * Follows
     *
     * @return mixed
     */
    public function follows()
    {
        return $this->morphMany(config('follow.follow_class'), 'followable');
    }

    /**
     * Like
     */
    public function follow()
    {
        $this->follows()->firstOrCreate([
            'followable_type' => get_class(),
            'followable_id' => $this->id,
            'user_id' => auth()->user()->id
        ]);
    }

    /**
     * Unlike
     */
    public function unfollow()
    {
        $this->follows()->where([
            'followable_type' => get_class(),
            'followable_id' => $this->id,
            'user_id' => auth()->user()->id
        ])->delete();
    }
}
