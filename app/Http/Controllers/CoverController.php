<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
use App\Services\AZLyricsService;
use Illuminate\Http\Request;
use App\Models\Song\Cover;
use App\Models\Song\Original;
use Tag;
use Str;

class CoverController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {

        $order = $request->order;
        $orderby = $request->orderby;
        $artist = $request->artist;
        $tag = $request->tag;

        $covers = Cover::query();

        if ($artist) $this->artistFilter($artist, $covers);

        if ($tag) $this->tagFilter($tag, $covers);

        if ($orderby) {
            $covers->orderby($orderby, $order);
        } else {
            $covers->orderby('created_at', 'desc');
        }

        return view('app.covers.index')->with([
            'covers' => $covers->get()
        ]);

    }


    private function tagFilter(string $tag, $query)
    {

        if ($tag === 'null') return false;

        return $query->whereHas('tags', function ($q) use ($tag) {

            if (! Str::contains($tag, '|')) {
                $q->where('name', $tag);
            } else {
                $q->whereIn('name', explode('|', $tag));
            }

        });

    }


    private function artistFilter(string $artist, $query)
    {

        if ($artist === 'null') return false;

        if (! Str::contains($artist, '|')) {

            return $query->where('artist', $artist);

        } else {

            return $query->where(function ($q) use ($artist) {

                $i = 0;
                foreach (explode('|', $artist) as $a) {

                    if ($i === 0) {
                        $q->where('artist', $a);
                    } else {
                        $q->orWhere('artist', $a);
                    }

                    $i++;

                }

            });

        }

    }


    public function showCoverView(Cover $cover)
    {
        return view('app.covers.cover')->with('cover', $cover);
    }

    public function showCreateView()
    {
        return view('app.covers.create');
    }


    public function create(SongRequest $request)
    {

        $request->validated();

        $cover = Cover::create($request->all());

        $tags = Tag::parseTagifyInput($request->tags);

        if ($tags) $cover->updateTags($tags);

        return redirect()->route('cover.show', ['cover' => $cover->id])
            ->with('success', trans('messages.cover-create-success'));

    }


    public function showEditView(Cover $cover)
    {
        return view('app.covers.create')->with('cover', $cover);
    }


    public function edit(Cover $cover, SongRequest $request)
    {

        $request->validated();

        $cover->update($request->all());

        $tags = Tag::parseTagifyInput($request->tags);

        if ($tags) $cover->updateTags($tags);

        return redirect()->route('cover.show', ['cover' => $cover->id])
            ->with('success', trans('messages.cover-edit-success'));

    }


    public function delete(Cover $cover)
    {

        $cover->delete();

        return redirect()->back()->with('success', trans('messages.cover-delete-success'));

    }


    public function lyricsSearch(Request $request)
    {

        $service = new AZLyricsService();

        return response()->json($service->search($request->searchQuery));

    }


    public function getLyrics(Request $request)
    {

        $service = new AZLyricsService();

        return response()->json($service->getLyrics($request->href));

    }

}
