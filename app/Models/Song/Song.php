<?php

namespace App\Models\Song;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\OwnedByUser;
use App\Models\Song\Concerns\CanBeAddedToRepertoire;

class Song extends Model
{

    use CanBeAddedToRepertoire;
    use OwnedByUser;

    protected $fillable = [
        'user_id',
        'title',
        'artist',
        'album',
        'lyrics',
        'type',
        'written_on',
    ];

    protected $dates = ['written_on'];

    protected $table = 'songs';

    public $userIdColumnName = 'songs.user_id';


    public function tags()
    {
        return $this->belongsToMany(SongTag::class, 'song_song_tag', 'song_id');
    }


    public function scopeWhereHasTags($query, string $tags)
    {

        if ($tags === 'null') return $this;

        return $query->whereHas('tags', function ($q) use ($tags) {

            if (! \Str::contains($tags, '|')) {
                $q->where('name', $tags);
            } else {
                $q->whereIn('name', explode('|', $tags));
            }

        });

    }


    public function tagList(bool $toLower = false)
    {

        $tags = $this->tags()->get();

        $arr = [];

        foreach ($tags as $t) {

            if ($toLower) {
                $arr[] = strtolower($t->name);
            } else {
                $arr[] = $t->name;
            }

        }

        return $arr;

    }


    public function updateTags(array $tags)
    {

        // List of all user tags
        $userTags = \Auth::user()->tagList($toLower = true);

        // Remove all existing pivots
        $songTags = $this->tags()->get();
        foreach ($songTags as $t) $this->tags()->detach($t->id);


        // List of tags that should be inserted
        $new = [];
        foreach ($tags as $t) {

            $tl = strtolower($t);

            if (! in_array($tl, $userTags)) $new[] = $t;
        }

        // dd($new);
        // Insert new tags
        foreach ($new as $n) {

            $newTagRecords[] = SongTag::create([
                'name' => $n,
                'user_id' => \Auth::id()
            ]);

        }


        // Insert new tag pivots
        $tagsLower = [];
        foreach ($tags as $t) $tagsLower[] = strtolower($t);

        $songTags = \Auth::user()
                         ->tags()
                         ->whereIn('name', array_merge($tags, $tagsLower))
                         ->get();

        foreach ($songTags as $t) $this->tags()->attach($t);

    }


}
