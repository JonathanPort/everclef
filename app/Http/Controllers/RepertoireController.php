<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song\RepertoireItem;
use Auth;
use Str;

class RepertoireController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {

        $order = $request->order;
        $orderby = $request->orderby;
        $type = $request->type;
        $artist = $request->artist;
        $tag = $request->tag;

        $repertoire = Auth::user()->repertoireItems()
            ->join('songs', 'repertoire_items.song_id', '=', 'songs.id');

        if ($type) $repertoire->where('songs.type', $type);

        if ($artist) $this->artistFilter($artist, $repertoire);

        if ($tag) $this->tagFilter($tag, $repertoire);

        if ($orderby) {
            $repertoire->orderby('songs.' . $orderby, $order);
        } else {
            $repertoire->orderby('repertoire_items.created_at', 'desc');
        }

        return view('app.repertoire.index')->with([
            'repertoire' => $repertoire->get()
        ]);

    }


    private function tagFilter(string $tag, $query)
    {

        $query->join('song_song_tag as p', 'songs.id', '=', 'p.song_id');

        if (! Str::contains($tag, '|')) {

            $tag = \Auth::user()->tags()->where('name', $tag)->first();

            if ($tag) $query->where('p.song_tag_id', $tag->id);

        } else  {

            $query->where(function ($q) use ($tag) {

                $i = 0;
                foreach (explode('|', $tag) as $t) {

                    $t = \Auth::user()->tags()->where('name', $t)->first();

                    if ($t) {

                        if ($i === 0) {
                            $q->where('p.song_tag_id', $t->id);
                        } else {
                            $q->orWhere('p.song_tag_id', $t->id);
                        }

                    }

                    $i++;

                }

            });

        }

    }


    private function artistFilter(string $artist, $query)
    {
        if (! Str::contains($artist, '|')) {

            $query->where('songs.artist', $artist);

        } else {

            $query->where(function ($q) use ($artist) {

                $i = 0;
                foreach (explode('|', $artist) as $a) {

                    if ($i === 0) {
                        $q->where('songs.artist', $a);
                    } else {
                        $q->orWhere('songs.artist', $a);
                    }

                    $i++;

                }

            });

        }

    }

}
