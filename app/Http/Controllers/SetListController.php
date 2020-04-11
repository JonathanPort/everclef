<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song\SetList;
use App\Models\Song\SetListSong;
use App\Models\Song\Song;

class SetListController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $setLists = \Auth::user()->setLists();

        return view('app.set-lists.index')->with([
            'setLists' => $setLists->get()
        ]);

    }


    public function show(SetList $setList)
    {

        return view('app.set-lists.set-list')->with('setList', $setList);

    }


    public function create(Request $request)
    {

        $ids = $request->songs;

        if (! $ids) return redirect()
                        ->back()
                        ->with('error', trans('messages.set-list-create-error'));

        $setList = SetList::create(['name' => $request->name]);

        foreach ($ids as $id) {

            $song = Song::find($id);
            if (! $song) continue;

            $setList->songs()->create([
                'song_id' => $song->id
            ]);

        }

        return redirect()
                ->route('set-lists.show', ['setList' => $setList->id])
                ->with('success', trans('messages.set-list-create-success'));

    }


    public function update(SetList $setList, Request $request)
    {

        $ids = $request->songs;

        if (! $ids) return redirect()
                        ->back()
                        ->with('error', trans('messages.set-list-update-error'));

        $setList->update(['name' => $request->name]);

        $setList->songs()->delete();

        foreach ($ids as $id) {

            $song = Song::find($id);
            if (! $song) continue;

            $setList->songs()->create([
                'song_id' => $song->id
            ]);

        }

        return redirect()
                ->route('set-lists.show', ['setList' => $setList->id])
                ->with('success', trans('messages.set-list-create-success'));

    }


    public function delete(SetList $setList)
    {

        $setList->delete();

        return redirect()
                ->route('set-lists')
                ->with('success', trans('messages.set-list-delete-success'));

    }

}
