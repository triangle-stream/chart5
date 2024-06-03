<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

use SilverStripe\Dev\BuildTask;
use SilverStripe\Dev\CsvBulkLoader;

class ChartWork extends BuildTask {

    private static $allowed_actions = [
        'index',
        'clear'
    ];

    protected $title = 'ChartWork Update';

    protected $description = 'Build task for ChartWork';

    public function run($request) {      
        $date = new DateTime();
        $year = 2023; 
        $week = 2;
        $last_week = 1; 
        $next_week = 3; 
        $this->buildThisWeekLocal($year,$last_week,$week,$next_week);
        $this->syncByGenre($year,$last_week,$week,$next_week);
        echo "VERIFICARE LE CANZONI IN NEW NEW (Generi) e mettere le charts in Review";
    }

    public function updateSong($titleid,$artistid,$title_name,$artist_name , $etichetta , $distributore , $isAlbum) {
        if ($isAlbum == false ) {
            $hashedTitleid = md5($title_name);
            $hashedArtistid = md5($artist_name);
            $Song = SongItem::get()->filter(array("titleid" => "$hashedTitleid" , "artistid" => "$hashedArtistid" , "isAlbum" => false))->first();
        }
        if ($isAlbum == true )  {
            $hashedTitleid = md5($title_name.$isAlbum);
            $hashedArtistid = md5($artist_name.$isAlbum);
            $Song = SongItem::get()->filter(array("titleid" => "$hashedTitleid" , "artistid" => "$hashedArtistid" , "isAlbum" => true))->first();
        }
        if ($Song) {
            $Song->titleid = $hashedTitleid;
            $Song->artistid = $hashedArtistid;
            $Song->title_single = $title_name;
            $Song->artist_name = $artist_name;
            $Song->songFP = $hashedArtistid.$hashedTitleid;
            $Song->label = $etichetta;
            $Song->imprint = $distributore;
            $Song->isAlbum = $isAlbum;
            $Song->write();
            return $Song->ID;
        } else {
            $createSong = SongItem::create();
            $createSong->titleid = $hashedTitleid;
            $createSong->artistid = $hashedArtistid;
            $createSong->title_single = $title_name;
            $createSong->artist_name = $artist_name;
            $createSong->songFP = $hashedArtistid.$hashedTitleid;
            $createSong->label = $etichetta;
            $createSong->imprint = $distributore;
            $createSong->imprint = $distributore;
            $createSong->genre = 'NoTag';
            $createSong->subgenre = 'NoTag';
            $createSong->isAlbum = $isAlbum;
            $createSong->write();
            return $createSong->ID;
        }
    }

    public function getSongGenre($titleid,$artistid,$isAlbum = null) {
        if ($isAlbum) {
            $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid" , "isAlbum" => $isAlbum))->first();
        } else {
            $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid"))->first();
        }
        return $Song->genre;
    }

    public function getSongSubGenre($titleid,$artistid,$isAlbum = null ) {
        if ($isAlbum) {
            $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid" , "isAlbum" => $isAlbum))->first();
        } else {
            $Song = SongItem::get()->filter(array("titleid" => "$titleid" , "artistid" => "$artistid"))->first();
        }
        return $Song->subgenre;
    }

    public function buildThisWeekLocal($year,$last_week,$week,$next_week) {
        $ChartPlanThis = ChartPlan::get()->filter(array("Year" => "$year" , "Week" => "$week" , "ChartStatus" => "Setup"))->first();
        echo "prende il piano chart della settimana corrente che e setuppato\r\n" ;
        // crea tutte le chart che ci servono
        if ($ChartPlanThis) {
            $isNew = null;
            echo "crea le charts locale\r\n";
            $ChartPlanType = ChartPlanType::get()->filter(array("ChartTypeDefine" => "Locale"));
            foreach ($ChartPlanType as $masterChart) {
                $chartList = Classifica::get()->filter(array("Settimana" => "$week" ,"Anno" => "$year", "ChartID" => "$masterChart->ChartID"));
                    if ($chartList->count() > 0) {
                        echo "esiste già una charts $masterChart->ChartID\r\n";
                        $chart = $chartList->first();
                        $ClassificaItemToRemove = $chart->ClassificaItems();
                        foreach ($ClassificaItemToRemove as $toRemove) {
                            echo "elimina Posizioni charts $masterChart->ChartID\r\n";
                            $chart->ClassificaItems()->remove($toRemove);
                        }
                        if ($masterChart->ChartSourceType == 'File') {
                            echo "la charts è da importare da un file\r\n";
                            $csvArray = $this->ImportCSV2Array("$masterChart->ChartSource" . $week . ".csv");
                            $countLocal = 0;
                            foreach ($csvArray as $row) {
                                echo "importo posizioni\r\n";
                                $hashedTitleid = md5($row["TITOLO"]);
                                $hashedArtistid = md5($row["ARTISTA"]);
                                $title_name = $row["TITOLO"];
                                $artist_name = $row["ARTISTA"];
                                $rank = $row["RANK"];
                                if ($row["LAST"]) {
                                    if ($row["LAST"] == "NEW") {
                                        $last_week = 0;
                                        $peak = $rank;
                                        $isNew = 1;
                                    } else {
                                        $row["LAST"];
                                    }
                                }
                                /*if ($row["ON"]) {
                                   $week_on = $row["ON"];
                                }*/
                                if ($row["ETICHETTA"]) {
                                    $etichetta = $row["ETICHETTA"];
                                }
                                if ($row["DISTRIBUTORE"]) {
                                    $distributore = $row["DISTRIBUTORE"];
                                }
                                print_r($hashedTitleid);
                                print_r('<<<<<<<');
                                print_r($hashedArtistid);
                                print_r($title_name);
                                print_r($artist_name);
                                print_r('-------');
                                if ($masterChart->ChartGenre == 1 || $masterChart->ChartID == 'hot100') {
                                    $SongID = $this->updateSong($hashedTitleid, $hashedArtistid, $title_name, $artist_name, $etichetta, $distributore , false);
                                }
                                if ($masterChart->ChartID == 'album100-local'  || $masterChart->ChartID == 'vynil30-local') {
                                    $SongID = $this->updateSong($hashedTitleid, $hashedArtistid, $title_name, $artist_name, $etichetta, $distributore , true);
                                }
                                $Song = SongItem::get()->byID($SongID);
                                $ClassItem = ClassificaItem::create();
                                $ClassItem->chart_code = $chart->ChartID;
                                $ClassItem->chart_size = $chart->Posizioni;
                                $ClassItem->chart_date = $chart->Settimana;
                                //$ClassItem->previous_chart_date =  52; //magio
                                $ClassItem->previous_chart_date = $chart->Settimana - 1;
                                $ClassItem->next_chart_date = $chart->Settimana + 1;
                                $ClassItem->rank = $rank;
                                $ClassItem->titleid = $Song->titleid;
                                $ClassItem->title_single = $Song->title_single;
                                $ClassItem->artistid = $Song->artistid;
                                $ClassItem->artist_name = $Song->artist_name;
                                $ClassItem->label = $etichetta;
                                $ClassItem->imprint = $distributore;
                                $ClassItem->last_week = $last_week;
                                if ($isNew == 1) {
                                    $ClassItem->peak_rank = $peak;
                                    $ClassItem->peak_date = $week;
                                }
                                //$ClassItem->weeks_on_chart = $week_on;
                                $ClassItem->write();
                                //$ClassItem->Classificas()->add($chart);
                                $chart->ClassificaItems()->add($ClassItem);
                            }
                        }
                    } else {
                        echo "non esiste già una charts $masterChart->ChartID\r\n";
                        $chart = Classifica::create();
                        $chart->Settimana = $week;
                        $chart->Anno = $year;
                        $chart->Descrizione = $masterChart->Descrizione;
                        $chart->ChartID = $masterChart->ChartID;
                        $chart->ChartNation = $masterChart->ChartNation;
                        $chart->Posizioni = $masterChart->Posizioni;
                        $chart->Status = 'Build';
                        $chart->ChartType = $masterChart->ChartTypeDefine;
                        $chart->ChartPeriod = 'Actual';
                        $chart->ChartPlanID = $ChartPlanThis->ID;
                        $chart->write();
                        $ChartPlanThis->Classificas()->add($chart);
                        if ($masterChart->ChartSourceType == 'File') {
                            $csvArray = $this->ImportCSV2Array("$masterChart->ChartSource" . $week . ".csv");
                            echo "la charts è da importare da un file\r\n";
                            $countLocal = 0;
                            foreach ($csvArray as $row) {
                                $hashedTitleid = md5($row["TITOLO"]);
                                $hashedArtistid = md5($row["ARTISTA"]);
                                $title_name = $row["TITOLO"];
                                $artist_name = $row["ARTISTA"];
                                $rank = $row["RANK"];
                                if ($row["LAST"]) {
                                    if ($row["LAST"] == "NEW") {
                                        $last_week = 0;
                                        $peak = $rank;
                                        $isNew = 1;
                                    } else {
                                        $row["LAST"];
                                    }
                                }
                                /*if ($row["ON"]) {
                                    $week_on = $row["ON"];
                                }*/
                                if ($row["ETICHETTA"]) {
                                    $etichetta = $row["ETICHETTA"];
                                }
                                if ($row["DISTRIBUTORE"]) {
                                    $distributore = $row["DISTRIBUTORE"];
                                }
                                if ($masterChart->ChartGenre == 1 || $masterChart->ChartID == 'hot100') {
                                    $SongID = $this->updateSong($hashedTitleid, $hashedArtistid, $title_name, $artist_name, $etichetta, $distributore , false);
                                }
                                if ($masterChart->ChartID == 'album100-local'  || $masterChart->ChartID == 'vynil30-local') {
                                    $SongID = $this->updateSong($hashedTitleid, $hashedArtistid, $title_name, $artist_name, $etichetta, $distributore , true);
                                }
                                $Song = SongItem::get()->byID($SongID);
                                echo "importo posizioni\r\n";
                                $ClassItem = ClassificaItem::create();
                                $ClassItem->chart_code = $chart->ChartID;
                                $ClassItem->chart_size = $chart->Posizioni;
                                $ClassItem->chart_date = $chart->Settimana;
                                //$ClassItem->previous_chart_date =  52; //magio
                                $ClassItem->previous_chart_date = $chart->Settimana - 1;
                                $ClassItem->next_chart_date = $chart->Settimana + 1;
                                $ClassItem->rank = $rank;
                                $ClassItem->titleid = $Song->titleid;
                                $ClassItem->title_single = $Song->title_single;
                                $ClassItem->artistid = $Song->artistid;
                                $ClassItem->artist_name = $Song->artist_name;
                                $ClassItem->label = $etichetta;
                                $ClassItem->imprint = $distributore;
                                $ClassItem->last_week = $last_week;
                                if ($isNew == 1) {
                                    $ClassItem->peak_rank = $peak;
                                    $ClassItem->peak_date = $week;
                                }
                                $ClassItem->write();
                                //$ClassItem->Classificas()->add($chart);
                                $chart->ClassificaItems()->add($ClassItem);
                            }
                       }
                    }
                    $masterChart->Status = 'Build';
                    $masterChart->write();
                    echo "la charts è buildata\r\n";
                }
            $ChartPlanThis->ChartStatus = 'Build';
            $ChartPlanThis->write();
            echo "la charts è buildata\r\n";
        }
    }

    public function syncByGenre($year,$last_week,$week,$next_week) {
        $ChartPlanThis = ChartPlan::get()->filter(array("Year" => "$year" , "Week" => "$week" , "ChartStatus" => "Build"))->first();
        if ($ChartPlanThis) {
            $ChartPlanType = ChartPlanType::get()->filter(array("ChartTypeDefine" => "Locale"));
            foreach ($ChartPlanType as $masterChart){
                echo "sincronizzo i generi \r\n";
                $chartList = Classifica::get()->filter(array("Settimana" => "$week" , "Anno" => "$year", "ChartID" => "$masterChart->ChartID"));
                if($masterChart->ChartID == 'hot100') {
                    $countPos = 1;
                    $chart = $chartList->first();
                    $ClassificaItemToRemove = $chart->ClassificaItems()->sort('rank');
                    foreach ($ClassificaItemToRemove as $toRemove) {
                        if ($countPos > $masterChart->Posizioni) {
                            $chart->ClassificaItems()->remove($toRemove);
                        }
                        $countPos++;
                    }
                }
                if($masterChart->ChartID == 'top50ita-local') {
                    $countPos = 1;
                    $chart = $chartList->first();
                    $ClassificaItemToGenreRank= $chart->ClassificaItems()->sort('rank');
                    foreach ($ClassificaItemToGenreRank as $toRank) {
                        $genre = $this->getSongGenre($toRank->titleid,$toRank->artistid);
                        if ($genre == 'Italiana') {
                            $toRank->genre_rank = $countPos;
                            $toRank->write();
                            $countPos++;
                        }
                        if ($countPos > $masterChart->Posizioni) {
                        break;
                        }
                    }
                }
                if($masterChart->ChartID == 'rock50-local') {
                    $countPos = 1;
                    $chart = $chartList->first();
                    $ClassificaItemToGenreRank= $chart->ClassificaItems()->sort('rank');
                    foreach ($ClassificaItemToGenreRank as $toRank) {
                        $genre = $this->getSongGenre($toRank->titleid,$toRank->artistid);
                        $subGenre = $this->getSongSubGenre($toRank->titleid,$toRank->artistid);
                        if ($genre == 'Rock' OR $subGenre == 'Rock') {
                            $toRank->genre_rank = $countPos;
                            $toRank->write();
                            $countPos++;
                        }
                        if ($countPos > $masterChart->Posizioni) {
                            break;
                        }
                    }
                }
                if($masterChart->ChartID == 'electro50-local') {
                    $countPos = 1;
                    $chart = $chartList->first();
                    $ClassificaItemToGenreRank= $chart->ClassificaItems()->sort('rank');
                    foreach ($ClassificaItemToGenreRank as $toRank) {
                        $genre = $this->getSongGenre($toRank->titleid,$toRank->artistid);
                        $subGenre = $this->getSongSubGenre($toRank->titleid,$toRank->artistid);
                        if ($genre == 'Elettronica'  OR $subGenre == 'Elettronica') {
                            $toRank->genre_rank = $countPos;
                            $toRank->write();
                            $countPos++;
                        }
                        if ($countPos > $masterChart->Posizioni) {
                            break;
                        }
                    }
                }
                if($masterChart->ChartID == 'hiphop50-local') {
                    $countPos = 1;
                    $chart = $chartList->first();
                    $ClassificaItemToGenreRank= $chart->ClassificaItems()->sort('rank');
                    foreach ($ClassificaItemToGenreRank as $toRank) {
                        $genre = $this->getSongGenre($toRank->titleid,$toRank->artistid);
                        $subGenre = $this->getSongSubGenre($toRank->titleid,$toRank->artistid);
                        if ($genre == 'HipHop' OR $subGenre == 'HipHop') {
                            $toRank->genre_rank = $countPos;
                            $toRank->write();
                            $countPos++;
                        }
                        if ($countPos > $masterChart->Posizioni) {
                            break;
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
        if ($handle)
        {
            while (($row = fgetcsv($handle, 4096)) !== false)
            {
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