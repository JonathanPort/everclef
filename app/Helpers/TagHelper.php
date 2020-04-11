<?php

namespace App\Helpers;

class TagHelper
{

    public static function sanitize(string $tag)
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $tag);
    }


    public static function parseTagifyInput(string $input = null)
    {

        $input = $input ? json_decode($input) : null;

        if ($input) {

            $arr = [];
            foreach ($input as $tag) $arr[] = self::sanitize($tag->value);

            $input = $arr;

        }

        return $input;

    }

}