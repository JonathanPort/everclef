<?php

namespace App\Services\LyricsService\Providers;

use App\Services\LyricsService\LyricsInterface;
use App\Services\LyricsService\Lyric;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;


class ChartLyrics implements LyricsInterface
{

    private const SEARCH_BASE_ENDPOINT = 'http://api.chartlyrics.com/apiv1.asmx/SearchLyric';
    private const LYRICS_BASE_ENDPOINT = 'http://api.chartlyrics.com/apiv1.asmx/GetLyric';


    public function search(string $query) : Collection
    {

        $response = Http::get($this->searchEndpoint($query));

        $results = new \SimpleXMLElement($response->body());

        $arr = [];

        foreach ($results->SearchLyricResult as $res) {

            $lyric = new Lyric();
            $lyric->title = (string) $res->Song;
            $lyric->artist = (string) $res->Artist;
            $lyric->href = '?lyricId=' . $res->LyricId . '&lyricCheckSum=' . $res->LyricChecksum;

            $arr[] = $lyric;

        }

        return collect($arr);

    }


    public function getLyrics(string $href) : Lyric
    {

        $response = Http::get($this->lyricsEndpoint($href));

        $res = new \SimpleXMLElement($response->body());

        $lyric = new Lyric();
        $lyric->title = (string) $res->LyricSong;
        $lyric->artist = (string) $res->LyricArtist;
        $lyric->href = '?lyricId=' . $res->LyricId . '&lyricCheckSum=' . $res->LyricChecksum;
        $lyric->lyrics = (string) $res->Lyric;

        return $lyric;

    }


    private function lyricsEndpoint(string $href)
    {

        return self::LYRICS_BASE_ENDPOINT . $href;

    }

    private function searchEndpoint(string $query)
    {

        return self::SEARCH_BASE_ENDPOINT . '?artist=' . $query . '&song=' . $query;

    }

}
