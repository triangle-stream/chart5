<?php
use SilverStripe\Dev\CsvBulkLoader;

class SongItemCsvBulkLoader extends CsvBulkLoader {
    public $columnMap = [
        'ARTISTA' => '->generateArtistFP',
        'TITOLO' => '->generateTitleFP',  // è il title nell'xml
        'GENERE' => "genre",
    ];

    public static function generateArtistFP(&$obj, $val, $record) {
        $hashedSongFP = md5($val);
        $obj->artist_name = $val;
        $obj->artistid = $hashedSongFP;
    }

    public static function generateTitleFP(&$obj, $val, $record) {
        $hashedSongFP = md5($val);
        $obj->titleid = $hashedSongFP;
        $obj->title_single = $val; 
    }  
}