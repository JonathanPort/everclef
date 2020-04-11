<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use PHPHtmlParser\Dom;
use Str;

class AZLyricsService
{

    private const SEARCH_BASE_ENDPOINT = 'https://search.azlyrics.com/';
    private const LYRICS_BASE_ENDPOINT = 'https://www.azlyrics.com/lyrics/';

    public function search(string $query)
    {

        $response = Http::get($this->searchEndpoint($query));
        $dom = new Dom;

        $dom->load($response->body());

        $trs = $dom->find('tr');

        $matches = [];
        $criteria = self::LYRICS_BASE_ENDPOINT;

        foreach ($trs as $tr) {

            $match = new AZLyric;

            $tr = (new Dom)->load($tr->innerHtml);

            $aTags = $tr->find('a');

            if ($aTags->count()) {
                $href = $aTags[0]->href;
                $href = str_replace(self::LYRICS_BASE_ENDPOINT, '', $href);
                $href = str_replace('.html', '', $href);
                $match->href = $href;
            }

            $bTags = $tr->find('b');

            if ($bTags->count()) {
                $match->artist = isset($bTags[0]) ? $bTags[0]->text : false;
                $match->title = isset($bTags[1]) ? $bTags[1]->text : false;
            }

            if ($match->href && $match->title && $match->artist) {
                $matches[] = $match;
            }

        }

        return collect($matches);

    }


    public function getLyrics(string $href)
    {

        $response = Http::get($this->lyricsEndpoint($href));

        $dom = new Dom;

        $dom->load($response->body());

        $div = $dom->find('div.col-xs-12.col-lg-8.text-center');

        if (! isset($div[0])) return false;

        $div = (new Dom)->load($div[0]->innerHtml);

        $divs = $div->find('div');

        if (! isset($divs[4])) return false;

        return $divs[4]->innerHtml;

    }


    private function lyricsEndpoint(string $href)
    {

        return self::LYRICS_BASE_ENDPOINT . $href . '.html';

    }

    private function searchEndpoint(string $query)
    {

        return self::SEARCH_BASE_ENDPOINT . 'search.php?q=' . $query . '&w=songs&p=1';

    }

}


class AZLyric
{

    public $title = null;
    public $artist = null;
    public $album = null;
    public $href = null;
    public $lyrics = null;

}