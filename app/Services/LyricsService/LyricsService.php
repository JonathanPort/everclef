<?php

namespace App\Services\LyricsService;

use App\Services\LyricsService\Providers\AZLyrics;
use App\Services\LyricsService\Providers\ChartLyrics;

class LyricsService
{

    public static function provider(string $provider)
    {

        $providers = [
            'AZLyrics' => AZLyrics::class,
            'ChartLyrics' => ChartLyrics::class,
        ];


        if (! array_key_exists($provider, $providers)) {

            throw new \Exception('No provider found with key: ' . $provider);

        }

        return new $providers[$provider]();

    }

}
