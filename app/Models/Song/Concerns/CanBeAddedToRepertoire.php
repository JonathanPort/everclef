<?php

namespace App\Models\Song\Concerns;

use Illuminate\Support\Facades\Auth;
use App\Models\Song\RepertoireItem;

trait CanBeAddedToRepertoire
{

    public function addToRepertoire()
    {

        $existing = RepertoireItem::where('song_id', $this->id)->first();

        if ($existing) throw new \Exception('Song already exists in Repertoire.');

        return RepertoireItem::create([
            'song_id' => $this->id,
            'user_id' => Auth::id()
        ]);

    }


    // removeFromRepertoire

}
