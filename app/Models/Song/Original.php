<?php

namespace App\Models\Song;

use App\Models\Song\Scopes\OriginalScope;

class Original extends Song
{

    protected static function boot()
    {

        parent::boot();

        static::addGlobalScope(new OriginalScope);

        static::creating(function(Song $song) {

            $song->type = 'original';

            if (! $song->written_on) $song->written_on = \Carbon\Carbon::now();

        });

    }


    public function getArtistAttribute()
    {
        return \Auth::user()->name;
    }

    public function setArtistAttribute()
    {
        return \Auth::user()->name;
    }

}
