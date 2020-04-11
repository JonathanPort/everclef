<?php

namespace App\models\Song;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\OwnedByUser;
use App\Models\Song\SetListSong;

class SetList extends Model
{

    use OwnedByUser;

    public $userIdColumnName = 'set_lists.user_id';

    protected $fillable = ['user_id', 'name'];


    public function addSongs($songs)
    {

        $setListSongs = [];

        foreach ($songs as $s) {

            $setListSongs[] = SetListSong::create([
                'song_id' => $s->id,
                'set_list_id' => $this->id
            ]);

        }

        return collect($setListSongs);

    }


    public function songs()
    {
        return $this->hasMany(SetListSong::class);
    }

}
