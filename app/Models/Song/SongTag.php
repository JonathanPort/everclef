<?php

namespace App\Models\Song;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\OwnedByUser;

class SongTag extends Model
{

    use OwnedByUser;

    protected $fillable = ['name', 'user_id'];

    public $userIdColumnName = 'song_tags.user_id';


    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

}
