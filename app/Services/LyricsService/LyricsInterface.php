<?php

namespace App\Services\LyricsService;

use App\Services\LyricsService\Lyric;
use Illuminate\Support\Collection;

interface LyricsInterface
{

    public function search(string $query): Collection;

    public function getLyrics(string $href): Lyric;

}
