<?php

namespace App\Services\LyricsService\Providers;

use App\Services\LyricsService\LyricsInterface;
use App\Services\LyricsService\Lyric;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use PHPHtmlParser\Dom;


class AZLyrics implements LyricsInterface
{

    private const SEARCH_BASE_ENDPOINT = 'https://search.azlyrics.com/';
    private const LYRICS_BASE_ENDPOINT = 'https://www.azlyrics.com/lyrics/';

    public function search(string $query) : Collection
    {

        $response = Http::get($this->searchEndpoint($query));
        $dom = new Dom;

        $dom->load($response->body());

        $trs = $dom->find('tr');

        $matches = [];

        foreach ($trs as $tr) {

            $match = new Lyric;

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

                $match->title = str_replace('"', '', $match->title);

                $matches[] = $match;
            }

        }

        return collect($matches);

    }


    public function getLyrics(string $href) : Lyric
    {

        $response = Http::get($this->lyricsEndpoint($href));

        $dom = new Dom;

        $dom->load($response->body());

        $div = $dom->find('div.col-xs-12.col-lg-8.text-center');

        if (! isset($div[0])) return false;

        $div = (new Dom)->load($div[0]->innerHtml);

        $divs = $div->find('div');

        if (! isset($divs[4])) return false;

        $lyric = new Lyric;

        $lyric->lyrics = $this->formatLyrics($divs[4]->innerHtml);

        return $lyric;

    }


    private function lyricsEndpoint(string $href)
    {

        return self::LYRICS_BASE_ENDPOINT . $href . '.html';

    }

    private function searchEndpoint(string $query)
    {

        return self::SEARCH_BASE_ENDPOINT . 'search.php?q=' . $query . '&w=songs&p=1';

    }


    private function formatLyrics(string $lyrics)
    {

        $lyrics = str_replace('<br /> <br />', '|break|', $lyrics);

        $lyrics = str_replace('<br />', '<pre class="new-line"></pre>', $lyrics);

        $lyrics = str_replace('|break|', '<br>', $lyrics);

        return $lyrics;

    }

}
