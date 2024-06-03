<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

use SilverStripe\Dev\BuildTask;

class ChartWorkPeak extends BuildTask {

    private static $allowed_actions = [
        'index',
        'clear'
    ];

    protected $title = 'ChartWorkPeak Update';

    protected $description = 'Build task for ChartWork';

    public function run($request) {      
        $date = new DateTime();
        $year = 2023; 
        $week = 2;
        $last_week = 1; 
        $next_week = 3; 
        $this->syncPeak($year,$week);
        echo "RESYNC (PICCHI) EFFETTUATO verificare le posizioni e mettere le charts in live e associarle alla pagina" ;
    }

    public function updateSong($titleid,$artistid,$title_name,$artist_name , $etichetta , $distributore , $isAlbum) {
        if ($isAlbum == false ) {
            $hashedTitleid = md5($title_name) ;
            $hashedArtistid = md5($artist_name) ;
            $Song = SongItem::get()->filter(array("titleid" => "$hashedTitleid" , "artistid" => "$hashedArtistid"))->first() ;
        }
        if ($isAlbum == true )  {
            $hashedTitleid = md5($title_name.$isAlbum) ;
            $hashedArtistid = md5($artist_name.$isAlbum) ;
            $Song = SongItem::get()->filter(array("titleid" => "$hashedTitleid" , "artistid" => "$hashedArtistid"))->first() ;
        }

        if ($Song) {
            $Song->titleid = $hashedTitleid ;
            $Song->artistid = $hashedArtistid ;
            $Song->title_single = $title_name ;
            $Song->artist_name = $artist_name ;
            $Song->songFP = $hashedArtistid.$hashedTitleid ;
            $Song->label = $etichetta ;
            $Song->imprint = $distributore ;
            $Song->isAlbum = $isAlbum ;
            $Song->write();
            return  $Song->ID ;
        } else {
            $createSong = new SongItem() ;
            $createSong->titleid = $hashedTitleid ;
            $createSong->artistid = $hashedArtistid ;
            $createSong->title_single = $title_name ;
            $createSong->artist_name = $artist_name ;
            $createSong->songFP = $hashedArtistid.$hashedTitleid ;
            $createSong->label = $etichetta ;
            $createSong->imprint = $distributore ;
            $createSong->imprint = $distributore ;
            $createSong->genre = 'NoTag' ;
            $createSong->subgenre = 'NoTag' ;
            $createSong->write();
            return  $createSong->ID ;
        }
    }

    public function getSongGenre($titleid,$artistid) {
        $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid"))->first();
        return  $Song->genre ;
    }

    public function getSongSubGenre($titleid,$artistid) {
        $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid"))->first();
        return  $Song->subgenre ;
    }

    public function syncPeak($year,$week) {
        $ChartPlanThis = ChartPlan::get()->filter(array("Year" => "$year" , "Week" => "$week" , "ChartStatus" => "Review"))->first() ;
        if ($ChartPlanThis) {
            $ChartPlanType = ChartPlanType::get()->filter(array("ChartTypeDefine" => "Locale")) ;
            foreach ($ChartPlanType as $masterChart){
                if ($masterChart->ChartGenre == false) {
                    echo "sincronizzo i picchi \r\n";
                    $chartList = Classifica::get()->filter(array("Settimana" => "$week" , "Anno" => "$year" ,"ChartID" => "$masterChart->ChartID"));
                    $chart = $chartList->first();
                    $ClassificaItemToCheckPeak = $chart->ClassificaItems()->sort('rank') ;
                    foreach ($ClassificaItemToCheckPeak as $toCheck) {
                        $oldItem2Week = null ;
                        $WeekAgo = null ;
                        $oldItem = null ;
                        //$oldItem = ClassificaItem::get()->filter(array("chart_date" => "52", "chart_code" => "$toCheck->chart_code", "titleid" => "$toCheck->titleid", "artistid" => "$toCheck->artistid"))->first(); //magio
                        $oldItem = ClassificaItem::get()->filter(array("chart_date" => "$toCheck->previous_chart_date", "chart_code" => "$toCheck->chart_code", "titleid" => "$toCheck->titleid", "artistid" => "$toCheck->artistid"))->first();

                        if ($oldItem) {
                            echo"esiste vecchio \r\n" ;
                            //$WeekAgo = 52; //magio
                            $WeekAgo = $toCheck->previous_chart_date - 1 ;
                            $oldItem2Week = ClassificaItem::get()->filter(array("chart_date" => "$WeekAgo" , "chart_code" => "$toCheck->chart_code" , "titleid" => "$toCheck->titleid" , "artistid" => "$toCheck->artistid"))->first();
                            if($oldItem2Week){
                                $toCheck->two_weeks = $oldItem2Week->rank ;
                            }
                            if ($oldItem->peak_rank > $toCheck->rank) {
                                $toCheck->peak_rank = $toCheck->rank ;
                                $toCheck->peak_date = $toCheck->chart_date ;
                                //$toCheck->two_weeks = $oldItem2Week->rank ;
                            }
                            if ($oldItem->peak_rank < $toCheck->rank) {
                                $toCheck->peak_rank = $oldItem->peak_rank  ;
                                //$toCheck->two_weeks = $oldItem2Week->rank ;
                            }
                            if ($oldItem->peak_rank == $toCheck->rank) {
                                $toCheck->peak_rank = $oldItem->peak_rank  ;
                                //$toCheck->two_weeks = $oldItem2Week->rank ;
                            }

                            $toCheck->weeks_on_chart = $oldItem->weeks_on_chart + 1  ;
                            $toCheck->last_week = $oldItem->rank ;
                            $toCheck->write();
                        } else {
                            echo"nonesiste vecchio \r\n" ;
                            $toCheck->peak_rank = $toCheck->rank  ;
                            $toCheck->peak_date = $week  ;
                            $toCheck->weeks_on_chart = 1  ;
                            $toCheck->write();
                        }
                    }
                }

                if ($masterChart->ChartGenre == true) {
                    echo "sincronizzo i picchi genere \r\n";
                    $chartList = Classifica::get()->filter(array( "Anno" => "$year" ,"Settimana" => "$week" , "ChartID" => "$masterChart->ChartID"));
                    $chart = $chartList->first();
                    $ClassificaItemToCheckPeak = $chart->ClassificaItems()->sort('genre_rank') ;
                    foreach ($ClassificaItemToCheckPeak as $toCheck) {
                        $oldItem2Week = null ;
                        $WeekAgo = null ;
                        $oldItem = null ;
                        //$oldItem = ClassificaItem::get()->filter(array("chart_date" => "52", "chart_code" => "$toCheck->chart_code", "titleid" => "$toCheck->titleid", "artistid" => "$toCheck->artistid"))->first(); //magio
                        $oldItem = ClassificaItem::get()->filter(array("chart_date" => "$toCheck->previous_chart_date", "chart_code" => "$toCheck->chart_code", "titleid" => "$toCheck->titleid", "artistid" => "$toCheck->artistid"))->first();
                        if ($oldItem) {
                            echo"esiste vecchio \r\n" ;
                            //$WeekAgo = 52; //magio
                            $WeekAgo = $toCheck->previous_chart_date - 1 ;
                            $oldItem2Week = ClassificaItem::get()->filter(array("chart_date" => "$WeekAgo" , "chart_code" => "$toCheck->chart_code" , "titleid" => "$toCheck->titleid" , "artistid" => "$toCheck->artistid"))->first();
                            if($oldItem2Week){
                                $toCheck->two_weeks = $oldItem2Week->genre_rank ;
                            }
                            if ($oldItem->peak_rank > $toCheck->genre_rank) {
                                $toCheck->peak_rank = $toCheck->genre_rank ;
                                $toCheck->peak_date = $toCheck->chart_date ;
                                //$toCheck->two_weeks = $oldItem2Week->rank ;
                            }
                            if ($oldItem->peak_rank < $toCheck->genre_rank) {
                                $toCheck->peak_rank = $oldItem->peak_rank  ;
                                //$toCheck->two_weeks = $oldItem2Week->rank ;
                            }
                            if ($oldItem->peak_rank == $toCheck->genre_rank) {
                                $toCheck->peak_rank = $oldItem->peak_rank  ;
                                //$toCheck->two_weeks = $oldItem2Week->rank ;
                            }
                            $toCheck->weeks_on_chart = $oldItem->weeks_on_chart + 1  ;
                            $toCheck->last_week = $oldItem->genre_rank ;
                            $toCheck->write();
                        } else {
                            echo"nonesiste vecchio \r\n" ;
                            $toCheck->peak_rank = $toCheck->genre_rank  ;
                            $toCheck->peak_date = $week  ;
                            $toCheck->weeks_on_chart = 1  ;
                            $toCheck->write();
                        }
                    }
                }
            }
        }
    }

    function ImportCSV2Array($filename) {
        $row = 0;
        $col = 0;

        $handle = @fopen($filename, "r");
        if ($handle) {
            while (($row = fgetcsv($handle, 4096)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }
                foreach ($row as $k=>$value) {
                    $results[$col][$fields[$k]] = $value;
                }
                $col++;
                unset($row);
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() failn";
            }
            fclose($handle);
        }
        return $results;
    }

    function ImportXML2Array($filename) {
        $file = file_get_contents($filename);
        $file = Convert::xml2array($file);
        //Debug::show($file); // $file is now just a PHP array
        return $file;
    }

    function sanitizeName($string) {
        $string = str_replace ("&", "&amp;", "$string") ; 
        $string = str_replace ("'", "’", "$string") ;
        $string = str_replace ('—', "-", "$string") ;
        return $string;
    }

    function MamiSanitizeName($string) {
        $string = str_replace ("&", "&amp;", "$string") ; 
        $string = str_replace ("'", "’", "$string") ;
        $string = str_replace ('—', "-", "$string") ;
        $string =  strtolower($string) ;
        $string =  ucwords($string) ;
        return $string;
    }

    function peakRank($string) {
        if ($string == 0 OR $string == null)  {
            $string = '-' ;
        }
        return $string;
    }
}