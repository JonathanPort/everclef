<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevController extends Controller
{


    public function playground(Request $request)
    {

        $service = \App\Services\LyricsService\LyricsService::provider('ChartLyrics');

        $lyrics = $service->search('Kings of leon the end');
        $lyric = $service->getLyrics($lyrics[0]->href);

    }


}
