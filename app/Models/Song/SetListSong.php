<?php

namespace App\models\Song;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\OwnedByUser;
use App\Models\Song\SetList;

class SetListSong extends Model
{

    use OwnedByUser;

    public $userIdColumnName = 'set_list_songs.user_id';

    protected $fillable = ['user_id', 'song_id', 'set_list_id'];


    public function setList()
    {
        return $this->belongsTo(SetList::class);
    }

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
