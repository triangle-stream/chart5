<?php

/**
 * A simple PHP class for searching iTunes Store content.
 * Read iTunes search documentation here:
 * https://www.apple.com/itunes/affiliates/resources/documentation/itunes-store-web-service-search-api.html
 */

namespace iTunesSearch;

class iTunes
{

    const search_url = 'https://itunes.apple.com/search?';
    const lookup_url = 'https://itunes.apple.com/lookup?';


    public static function search($data)
    {
        return self::get_data(self::search_url . http_build_query($data));
    }

    public static function lookup($data)
    {
        return self::get_data(self::lookup_url . http_build_query($data));
    }

    private static function get_data($url)
    {
        $content = file_get_contents($url);
        return json_decode($content);
    }
}
