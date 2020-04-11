<?php

namespace App\Models\Song;

use App\Models\Song\Scopes\CoverScope;

class Cover extends Song
{

    protected static function boot()
    {

        parent::boot();

        static::addGlobalScope(new CoverScope);

        static::creating(function(Song $song) {

            $song->type = 'cover';

        });

        static::created(function(Song $song) {

            $song->addToRepertoire();

        });

    }


    public function link()
    {
        return route('cover.show', ['cover' => $this->id]);
    }

}
