<?php

namespace App\Models\Song;

trait CanBeAddedToRepertoire
{

    public function addToRepertoire()
    {

        $existing = RepertoireItem::where('song_id', $this->id)->first();

        if ($existing) throw new \Exception('Song already exists in Repertoire.');

        return RepertoireItem::create([
            'song_id' => $this->id,
            'user_id' => \Auth::id()
        ]);

    }


    // removeFromRepertoire

}
