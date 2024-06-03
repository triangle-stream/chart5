<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

use SilverStripe\Dev\BuildTask;

class ChartWorkReSync extends BuildTask {

    private static $allowed_actions = [
        'index',
        'clear'
    ];

    protected $title = 'ChartWorkReSync Update';

    protected $description = 'Build task for ChartWork';

    public function run($request) {      
        $date = new DateTime();
        $year = 2023; 
        $week = 2;
        $last_week = 1; 
        $next_week = 3; 
        $this->syncByGenre($year,$last_week,$week,$next_week); 
        $this->creaXMLPress($year,$week,'hot100');
        $this->creaXMLPress($year,$week,'top50ita-local');
        $this->creaXMLPress($year,$week,'hiphop50-local');
        $this->creaXMLPress($year,$week,'rock50-local');
        $this->creaXMLPress($year,$week,'electro50-local');
        $this->creaXMLPress($year,$week,'album100-local');
        $this->creaXMLPress($year,$week,'vynil30-local'); 
        echo "RESYNC (Generi) EFFETTUATO e far partire la procedure di sincronizzazione dei picchi"; 
    }

    public function getSongGenre($titleid,$artistid,$isAlbum = null) {
        if ($isAlbum) {
            $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid" , "isAlbum" => $isAlbum))->first();
        } else {
            $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid"))->first();
        }
        return  $Song->genre;
    }

    public function getSongSubGenre($titleid,$artistid,$isAlbum = null) {
        if ($isAlbum) {
            $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid" , "isAlbum" => $isAlbum))->first();
        } else {
            $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid"))->first();
        }
        return  $Song->subgenre;
    }

    public function syncByGenre($year,$last_week,$week,$next_week) {
        $ChartPlanThis = ChartPlan::get()->filter(array("Year" => "$year" , "Week" => "$week" , "ChartStatus" => "Review"))->first() ;
        if ($ChartPlanThis) {
            $ChartPlanType = ChartPlanType::get()->filter(array("ChartTypeDefine" => "Locale"));
            foreach ($ChartPlanType as $masterChart){
                echo "sincronizzo i generi \r\n" ;
                $chartList = Classifica::get()->filter(array("Settimana" => "$week" , "Anno" => "$year", "ChartID" => "$masterChart->ChartID"));
                if($masterChart->ChartID == 'hot100') {
                    $countPos = 1 ;
                    $chart = $chartList->first();
                    $ClassificaItemToRemove = $chart->ClassificaItems()->sort('rank') ;
                    foreach ($ClassificaItemToRemove as $toRemove) {
                        if ($countPos > $masterChart->Posizioni) {
                            $chart->ClassificaItems()->remove($toRemove);
                        }
                        $countPos++ ;
                    }
                }
                if($masterChart->ChartID == 'top50ita-local') {
                    $countPos = 1 ;
                    $chart = $chartList->first();
                    $ClassificaItemToGenreRank= $chart->ClassificaItems()->sort('rank') ;
                    foreach ($ClassificaItemToGenreRank as $toRank) {
                        $genre = $this->getSongGenre($toRank->titleid,$toRank->artistid) ;
                        if ($genre == 'Italiana') {
                            $toRank->genre_rank = $countPos ;
                            $toRank->write();
                            $countPos++ ;
                        }
                        if ($countPos > $masterChart->Posizioni) {
                        break;
                        }
                    }
                }
                if($masterChart->ChartID == 'rock50-local') {
                    $countPos = 1 ;
                    $chart = $chartList->first();
                    $ClassificaItemToGenreRank= $chart->ClassificaItems()->sort('rank') ;
                    foreach ($ClassificaItemToGenreRank as $toRank) {
                        $genre = $this->getSongGenre($toRank->titleid,$toRank->artistid) ;
                        $subGenre = $this->getSongSubGenre($toRank->titleid,$toRank->artistid) ;
                        if ($genre == 'Rock' OR $subGenre == 'Rock' ) {
                            $toRank->genre_rank = $countPos ;
                            $toRank->write();
                            $countPos++ ;
                        }
                        if ($countPos > $masterChart->Posizioni) {
                            break;
                        }
                    }
                }
                if($masterChart->ChartID == 'electro50-local') {
                    $countPos = 1 ;
                    $chart = $chartList->first();
                    $ClassificaItemToGenreRank= $chart->ClassificaItems()->sort('rank') ;
                    foreach ($ClassificaItemToGenreRank as $toRank) {
                        $genre = $this->getSongGenre($toRank->titleid,$toRank->artistid) ;
                        $subGenre = $this->getSongSubGenre($toRank->titleid,$toRank->artistid) ;
                        if ($genre == 'Elettronica'  OR $subGenre == 'Elettronica') {
                            $toRank->genre_rank = $countPos ;
                            $toRank->write();
                            $countPos++;
                        }
                        if ($countPos > $masterChart->Posizioni) {
                            break;
                        }
                    }
                }
                if($masterChart->ChartID == 'hiphop50-local') {
                    $countPos = 1 ;
                    $chart = $chartList->first();
                    $ClassificaItemToGenreRank= $chart->ClassificaItems()->sort('rank') ;
                    foreach ($ClassificaItemToGenreRank as $toRank) {
                        $genre = $this->getSongGenre($toRank->titleid,$toRank->artistid) ;
                        $subGenre = $this->getSongSubGenre($toRank->titleid,$toRank->artistid) ;
                        if ($genre == 'HipHop' OR $subGenre == 'HipHop' ) {
                            $toRank->genre_rank = $countPos ;
                            $toRank->write();
                            $countPos++ ;
                        }
                        if ($countPos > $masterChart->Posizioni) {
                            break;
                        }
                    }
                }
            }
        }
    }

    public function creaXMLPress($year,$week,$chart) {
        $previousChartDate = $week -1 ;
        $nextChartDate= $week +1 ;
        $Classifica = Classifica::get()->filter(array("Anno" => "$year" , "Settimana" => "$week" , "ChartID" => "$chart"))->first() ;
        if($Classifica->ChartID == 'top50ita-local' ||  $Classifica->ChartID == 'hiphop50-local' ||  $Classifica->ChartID == 'rock50-local' ||  $Classifica->ChartID == 'electro50-local') {
            $posizioniClassificaElimina = $Classifica->ClassificaItems();
            foreach ($posizioniClassificaElimina as $posizioni){
                if ($posizioni->genre_rank == 0) {
                    $posizioni->delete();
                }
                // magio
                if ($posizioni->genre_rank >= 51) {
                    $posizioni->delete();
                }
            }
        }
        $posizioniClassifica = $Classifica->ClassificaItems();
        echo "creo classifica \r\n" ;
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
        /*if ($string == 0 OR $string == null)  {
            $string = '-' ;
        }*/
        return $string;
    }
}