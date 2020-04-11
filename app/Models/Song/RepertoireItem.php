<?php

namespace App\Models\Song;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\OwnedByUser;

class RepertoireItem extends Model
{

    use OwnedByUser;

    protected $fillable = ['user_id', 'song_id'];

    public $userIdColumnName = 'repertoire_items.user_id';

    public function song()
    {

        $song = $this->belongsTo(Cover::class);

        if ($song->first()) {
            $song = $this->belongsTo(Cover::class);
        } else {
            $song = $this->belongsTo(Original::class);
        }

        return $song;
    }

}
