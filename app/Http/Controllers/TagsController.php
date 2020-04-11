<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song\SongTag;
use Tag;

class TagsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('app.tags.index')->with('tags', \Auth::user()->tags()->get());
    }


    public function showEditView(SongTag $tag)
    {
        return view('app.tags.edit')->with('tag', $tag);
    }


    public function edit(SongTag $tag, Request $request)
    {

        $request->validate([
            'tag' => 'required|string'
        ]);

        $tag->update($request->all());

        return redirect()->route('tags')
            ->with('success', trans('messages.tag-edit-success'));

    }

}
