<?php

namespace App\Helpers;

use App\Models\Song\SetList;

class SetListHelper
{


    /**
     * Pass collections to build JSON array to be read by SetListMaker.js
     * module. Three scenarios:
     *
     * 1. Empty array or nothing passed through = New Set List
     * 2. Collection passed through = New Set List from collection
     * 3. SetListSong Collection passed through = Update Set List
     *
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public static function buildSetListMakerDataForJS($data = [])
    {

        $update = false;
        $setList = false;

        if (! $data) {

            // New setlist
            $songs = collect([]);

        } else {

            // Existing or pre filled
            $songs = [];

            foreach ($data as $d) {

                $song = new \StdClass();

                switch (class_basename($d)) {
                    case 'RepertoireItem':
                        $song->id = $d->song->id;
                        $song->title = $d->song->title;
                        $song->artist = $d->song->artist;
                        break;
                    case 'Song':
                        $song->id = $d->id;
                        $song->title = $d->title;
                        $song->artist = $d->artist;
                        break;
                    case 'SetListSong':
                        $song->id = $d->song->id;
                        $song->title = $d->song->title;
                        $song->artist = $d->song->artist;
                        $update = $d->set_list_id;

                        if (! $setList) $setList = SetList::find($d->set_list_id);

                        break;
                }

                $songs[] = $song;

            }

            $songs = collect($songs);

        }

        return json_encode([
            'update' => $update ? true : false,
            'formHref' => $update ? route('set-list.update', ['setList' => $setList->id]) : route('set-list.create'),
            'songs' => $songs,
            'name' => $setList ? $setList->name : false
        ]);

    }

}
