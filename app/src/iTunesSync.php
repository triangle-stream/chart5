<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

use SilverStripe\Dev\BuildTask;
use iTunesSearch\iTunes;

class iTunesSync extends BuildTask {

    private static $allowed_actions = [
        'index',
        'clear'
    ];

    protected $title = 'iTunes Update';

    protected $description = 'Build task for iTunes';

    public function run($request) {
        $date = new DateTime();
        $year = 2023; 
        $week = 2;
        $last_week = 1; 
        $next_week = 3; 
        echo "Lookup sulle classifiche della settimana per import dati iTunes "; 
        $this->getItemFromChartsAndCheckItunes($year,$week);
    }

    public function getItemFromChartsAndCheckItunes($year,$week) {
        $ChartPlanThis = ChartPlan::get()->filter(array("Year" => "$year" , "Week" => "$week" , "ChartStatus" => "Live"))->first() ;
        if ($ChartPlanThis) {
            foreach ($ChartPlanThis->Classificas() as $masterChart){
                $chartList = Classifica::get()->filter(array("Settimana" => "$week" , "Anno" => "$year", "ChartID" => "$masterChart->ChartID" ,"ChartType" => "Locale"))->first();
                echo "verifico item in classifica  $masterChart->ChartID \r\n";
                $ClassificaItemToItunes = $chartList->ClassificaItems() ;
                foreach ($ClassificaItemToItunes as $checkItunes) {
                    echo "verifico item in classifica  $masterChart->ChartID \r\n";
                    $Song = SongItem::get()->filter(array("titleid" => "$checkItunes->titleid" , "artistid" => "$checkItunes->artistid"))->first();
                    $strTitle = $checkItunes->title_single;
                    $strTitle = str_replace(' ', '+', $strTitle); 
                    echo "ecco titolo $strTitle di $masterChart->ChartID \r\n";
                    if ($Song) {
                        echo "esiste brano \r\n";
                        if($Song->hasLookup != true) {
                            echo "brano mai verificato con iTunes \r\n" ;
                            if ($checkItunes->isAlbum == true) { 
                                $entity = 'album' ;
                                echo "album \r\n" ;
                            } else {
                                $entity =  'song' ; echo "song \r\n" ;
                            };
                            $result = iTunes::search(array( 
                                "term" => "$strTitle", 
                                "entity" => "$entity",
                                "country" => "IT",
                                "media" => "music"
                            ));
                            echo "chiamata api a iTunes \r\n" ;
                            sleep(3) ;
                            $once = 0 ;
                            if ($result->results != '') {
                                foreach ($result->results as $data) {
                                    echo "ciclo  iTunes \r\n" ;
                                    if ($entity == 'song') {
                                        $iTunesRef = iTunesItem::get()->filter(array("trackId" => "$data->trackId"))->first() ;

                                        if($iTunesRef) {
                                            echo "referenza iTunes già presente aggiorno \r\n" ;
                                            $iTunesRef->wrapperType = $data->wrapperType ;
                                            $iTunesRef->artistType = $data->artistType ;
                                            $iTunesRef->artistLinkUrl = $data->artistLinkUrl ;
                                            $iTunesRef->artistId = $data->artistId ;
                                            $iTunesRef->amgArtistId = $data->amgArtistId ;
                                            $iTunesRef->primaryGenreName = $data->primaryGenreName ;
                                            $iTunesRef->primaryGenreId = $data->primaryGenreId ;
                                            $iTunesRef->collectionType = $data->collectionType ;
                                            $iTunesRef->collectionId = $data->collectionId ;
                                            $iTunesRef->collectionName = $data->collectionName ;
                                            $iTunesRef->collectionCensoredName = $data->collectionCensoredName ;
                                            $iTunesRef->artistViewUrl = $data->artistViewUrl ;
                                            $iTunesRef->collectionViewUrl = $data->collectionViewUrl ;
                                            $iTunesRef->collectionPrice = $data->collectionPrice ;
                                            $iTunesRef->collectionExplicitness = $data->collectionExplicitness ;
                                            $iTunesRef->trackCount = $data->trackCount ;
                                            $iTunesRef->copyright = $data->copyright ;
                                            $iTunesRef->country = $data->country ;
                                            $iTunesRef->currency = $data->currency ;
                                            $iTunesRef->releaseDate = $data->releaseDate ;
                                            $iTunesRef->kind = $data->kind ;
                                            $iTunesRef->trackId = $data->trackId ;
                                            $iTunesRef->artistName = $data->artistName ;
                                            $iTunesRef->trackName = $data->trackName ;
                                            $iTunesRef->trackCensoredName = $data->trackCensoredName ;
                                            $iTunesRef->trackViewUrl = $data->trackViewUrl ;
                                            $iTunesRef->previewUrl = $data->previewUrl ;
                                            $iTunesRef->artworkUrl60 = $this->artworkSSL($data->artworkUrl60) ;
                                            $iTunesRef->artworkUrl100 = $this->artworkSSL($data->artworkUrl100) ;
                                            $iTunesRef->trackPrice = $data->trackPrice ;
                                            $iTunesRef->trackExplicitness = $data->trackExplicitness ;
                                            $iTunesRef->discCount = $data->discCount ;
                                            $iTunesRef->discNumber = $data->discNumber ;
                                            $iTunesRef->trackCount = $data->trackCount ;
                                            $iTunesRef->trackNumber = $data->trackNumber ;
                                            $iTunesRef->trackTimeMillis = $data->trackTimeMillis ;
                                            $iTunesRef->write();
                                            echo "aggiorno referenza iTunes $iTunesRef->ID  \r\n" ;
                                            $Song->hasLookup = true ;
                                            if ($this->iTunesVerifyArtist($iTunesRef->artistName,$Song->artist_name) == true  && $once == 0)  {
                                                $Song->iTunesItemID = $iTunesRef->ID ;
                                            }
                                            $Song->write();
                                            echo "setta lookup ok su $Song->ID \r\n" ;
                                        } else {
                                            $newItunes = new iTunesItem() ;
                                            $newItunes->wrapperType = $data->wrapperType ;
                                            $newItunes->artistType = $data->artistType ;
                                            $newItunes->artistLinkUrl = $data->artistLinkUrl ;
                                            $newItunes->artistId = $data->artistId ;
                                            $newItunes->amgArtistId = $data->amgArtistId ;
                                            $newItunes->primaryGenreName = $data->primaryGenreName ;
                                            $newItunes->primaryGenreId = $data->primaryGenreId ;
                                            $newItunes->collectionType = $data->collectionType ;
                                            $newItunes->collectionId = $data->collectionId ;
                                            $newItunes->collectionName = $data->collectionName ;
                                            $newItunes->collectionCensoredName = $data->collectionCensoredName ;
                                            $newItunes->artistViewUrl = $data->artistViewUrl ;
                                            $newItunes->collectionViewUrl = $data->collectionViewUrl ;
                                            $newItunes->collectionPrice = $data->collectionPrice ;
                                            $newItunes->collectionExplicitness = $data->collectionExplicitness ;
                                            $newItunes->trackCount = $data->trackCount ;
                                            $newItunes->copyright = $data->copyright ;
                                            $newItunes->country = $data->country ;
                                            $newItunes->currency = $data->currency ;
                                            $newItunes->releaseDate = $data->releaseDate ;
                                            $newItunes->kind = $data->kind ;
                                            $newItunes->trackId = $data->trackId ;
                                            $newItunes->artistName = $data->artistName ;
                                            $newItunes->trackName = $data->trackName ;
                                            $newItunes->trackCensoredName = $data->trackCensoredName ;
                                            $newItunes->trackViewUrl = $data->trackViewUrl ;
                                            $newItunes->previewUrl = $data->previewUrl ;
                                            $newItunes->artworkUrl60 = $this->artworkSSL($data->artworkUrl60) ;
                                            $newItunes->artworkUrl100 = $this->artworkSSL($data->artworkUrl100) ;
                                            $newItunes->trackPrice = $data->trackPrice ;
                                            $newItunes->trackExplicitness = $data->trackExplicitness ;
                                            $newItunes->discCount = $data->discCount ;
                                            $newItunes->discNumber = $data->discNumber ;
                                            $newItunes->trackCount = $data->trackCount ;
                                            $newItunes->trackNumber = $data->trackNumber ;
                                            $newItunes->trackTimeMillis = $data->trackTimeMillis ;
                                            $newItunes->write();
                                            echo "scrivi referenza iTunes $newItunes->ID  \r\n" ;
                                            $Song->hasLookup = true ;
                                            if ($this->iTunesVerifyArtist($newItunes->artistName,$Song->artist_name) == true && $once == 0)  {
                                                $Song->iTunesItemID = $newItunes->ID ;
                                            }
                                            $Song->write();
                                            echo "setta lookup ok su $Song->ID \r\n" ;
                                    }
                                } else {
                                    $iTunesRef = iTunesItem::get()->filter(array("collectionId" => "$data->collectionId" ))->first() ;
                                        if($iTunesRef) {
                                            echo "referenza iTunes già presente aggiorno \r\n" ;
                                            $iTunesRef->wrapperType = $data->wrapperType ;
                                            $iTunesRef->artistType = $data->artistType ;
                                            $iTunesRef->artistLinkUrl = $data->artistLinkUrl ;
                                            $iTunesRef->artistId = $data->artistId ;
                                            $iTunesRef->amgArtistId = $data->amgArtistId ;
                                            $iTunesRef->primaryGenreName = $data->primaryGenreName ;
                                            $iTunesRef->primaryGenreId = $data->primaryGenreId ;
                                            $iTunesRef->collectionType = $data->collectionType ;
                                            $iTunesRef->collectionId = $data->collectionId ;
                                            $iTunesRef->collectionName = $data->collectionName ;
                                            $iTunesRef->collectionCensoredName = $data->collectionCensoredName ;
                                            $iTunesRef->artistViewUrl = $data->artistViewUrl ;
                                            $iTunesRef->collectionViewUrl = $data->collectionViewUrl ;
                                            $iTunesRef->collectionPrice = $data->collectionPrice ;
                                            $iTunesRef->collectionExplicitness = $data->collectionExplicitness ;
                                            $iTunesRef->trackCount = $data->trackCount ;
                                            $iTunesRef->copyright = $data->copyright ;
                                            $iTunesRef->country = $data->country ;
                                            $iTunesRef->currency = $data->currency ;
                                            $iTunesRef->releaseDate = $data->releaseDate ;
                                            $iTunesRef->kind = $data->kind ;
                                            $iTunesRef->trackId = $data->trackId ;
                                            $iTunesRef->artistName = $data->artistName ;
                                            $iTunesRef->trackName = $data->trackName ;
                                            $iTunesRef->trackCensoredName = $data->trackCensoredName ;
                                            $iTunesRef->trackViewUrl = $data->trackViewUrl ;
                                            $iTunesRef->previewUrl = $data->previewUrl ;
                                            $iTunesRef->artworkUrl60 = $this->artworkSSL($data->artworkUrl60) ;
                                            $iTunesRef->artworkUrl100 = $this->artworkSSL($data->artworkUrl100) ;
                                            $iTunesRef->trackPrice = $data->trackPrice ;
                                            $iTunesRef->trackExplicitness = $data->trackExplicitness ;
                                            $iTunesRef->discCount = $data->discCount ;
                                            $iTunesRef->discNumber = $data->discNumber ;
                                            $iTunesRef->trackCount = $data->trackCount ;
                                            $iTunesRef->trackNumber = $data->trackNumber ;
                                            $iTunesRef->trackTimeMillis = $data->trackTimeMillis ;
                                            $iTunesRef->write();
                                            echo "aggiorno referenza iTunes $iTunesRef->ID  \r\n" ;
                                            $Song->hasLookup = true ;
                                            if ($this->iTunesVerifyArtist($iTunesRef->artistName,$Song->artist_name) == true && $once == 0)  {
                                                $Song->iTunesItemID = $iTunesRef->ID ;
                                            }
                                            $Song->write();
                                        } else {
                                            $newItunes = new iTunesItem() ;
                                            $newItunes->wrapperType = $data->wrapperType ;
                                            $newItunes->artistType = $data->artistType ;
                                            $newItunes->artistLinkUrl = $data->artistLinkUrl ;
                                            $newItunes->artistId = $data->artistId ;
                                            $newItunes->amgArtistId = $data->amgArtistId ;
                                            $newItunes->primaryGenreName = $data->primaryGenreName ;
                                            $newItunes->primaryGenreId = $data->primaryGenreId ;
                                            $newItunes->collectionType = $data->collectionType ;
                                            $newItunes->collectionId = $data->collectionId ;
                                            $newItunes->collectionName = $data->collectionName ;
                                            $newItunes->collectionCensoredName = $data->collectionCensoredName ;
                                            $newItunes->artistViewUrl = $data->artistViewUrl ;
                                            $newItunes->collectionViewUrl = $data->collectionViewUrl ;
                                            $newItunes->collectionPrice = $data->collectionPrice ;
                                            $newItunes->collectionExplicitness = $data->collectionExplicitness ;
                                            $newItunes->trackCount = $data->trackCount ;
                                            $newItunes->copyright = $data->copyright ;
                                            $newItunes->country = $data->country ;
                                            $newItunes->currency = $data->currency ;
                                            $newItunes->releaseDate = $data->releaseDate ;
                                            $newItunes->kind = $data->kind ;
                                            $newItunes->trackId = $data->trackId ;
                                            $newItunes->artistName = $data->artistName ;
                                            $newItunes->trackName = $data->trackName ;
                                            $newItunes->trackCensoredName = $data->trackCensoredName ;
                                            $newItunes->trackViewUrl = $data->trackViewUrl ;
                                            $newItunes->previewUrl = $data->previewUrl ;
                                            $newItunes->artworkUrl60 = $this->artworkSSL($data->artworkUrl60) ;
                                            $newItunes->artworkUrl100 = $this->artworkSSL($data->artworkUrl100) ;
                                            $newItunes->trackPrice = $data->trackPrice ;
                                            $newItunes->trackExplicitness = $data->trackExplicitness ;
                                            $newItunes->discCount = $data->discCount ;
                                            $newItunes->discNumber = $data->discNumber ;
                                            $newItunes->trackCount = $data->trackCount ;
                                            $newItunes->trackNumber = $data->trackNumber ;
                                            $newItunes->trackTimeMillis = $data->trackTimeMillis ;
                                            $newItunes->write();
                                            echo "scrivi referenza iTunes $newItunes->ID  \r\n" ;
                                            $Song->hasLookup = true ;
                                            if ($this->iTunesVerifyArtist($newItunes->artistName,$Song->artist_name) == true && $once == 0)  {
                                                $Song->iTunesItemID = $iTunesRef->ID ;
                                            }
                                            $Song->write();
                                            echo "setta lookup ok su $Song->ID \r\n" ;
                                        }
                                    }
                                $once++ ;
                            }

                        }
                    }

                } else {

                }

                $iTunesObj = $this->getItunesInfo($checkItunes->artistid,$checkItunes->titleid) ;
                $checkItunes->artworkUrl100 = $iTunesObj->artworkUrl100;
                $checkItunes->previewUrl = $iTunesObj->previewUrl;
                $checkItunes->trackViewUrl = $iTunesObj->trackViewUrl;
                $checkItunes->trackId = $iTunesObj->trackId;
                $checkItunes->collectionViewUrl = $iTunesObj->collectionViewUrl;
                $checkItunes->write();
                }
            }
        }
    }

    public function iTunesVerifyArtist($artistITUNES,$artistSONG) {
        $artistITUNES = strtolower($artistITUNES);
        $artistSONG = strtolower($artistSONG);
        $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
        $replace = explode(",","c,ae,oe,a',e',i',o',u',a',e',i',o',u',a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E',E',E,E,I,I,I,I,O',O',O,O,U',U',U,U,Y,C,AE,OE");
        $artistITUNES =  str_replace($search, $replace, $artistITUNES);
        $artistSONG =  str_replace($search, $replace, $artistSONG);
        if ($artistITUNES == $artistSONG || strpos($artistSONG, $artistITUNES) !== false) {
            return true ;
        } else {
            return false ;
        }
    }

    public function getItunesInfo($artist,$track) {
        $SongItem = SongItem::get()->filter(array("artistid" => "$artist" , "titleid" => "$track" ))->first() ;
        $iTunesData = iTunesItem::get()->byID($SongItem->iTunesItemID);
        return $iTunesData;
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
            return $Song->ID ;
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
            return $createSong->ID ;
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

    public function syncByGenre($year,$last_week,$week,$next_week) {
        $ChartPlanThis = ChartPlan::get()->filter(array("Year" => "$year" , "Week" => "$week" , "ChartStatus" => "Build"))->first() ;
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
                        $countPos++;
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
                            $countPos++;
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
                            $countPos++ ;
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
       return $file;
    }

    function sanitizeName($string) {
        $string = str_replace ("&", "&amp;", "$string") ; 
        $string = str_replace ("'", "’", "$string") ;
        $string = str_replace ('—', "-", "$string") ;
        return $string;
    }

    function artworkSSL($string) {
        if (strpos($string, "http://is1.mzstatic.com")===true) {
            return str_replace($string,"https://is1-ssl.mzstatic.com",$string);
        } elseif (strpos($string, "http://is2.mzstatic.com")===true) {
            return str_replace($string,"https://is2-ssl.mzstatic.com",$string);
        } elseif (strpos($string, "http://is3.mzstatic.com")===true) {
            return str_replace($string,"https://is3-ssl.mzstatic.com",$string);
        } elseif(strpos($string, "http://is4.mzstatic.com")===true) {
            return str_replace($string,"https://is4-ssl.mzstatic.com",$string);
        } elseif(strpos($string, "http://is5.mzstatic.com")===true) {
            return str_replace($string,"https://is5-ssl.mzstatic.com",$string);
        } elseif(strpos($string, "http://is6.mzstatic.com")===true) {
            return str_replace($string,"https://is6-ssl.mzstatic.com",$string);
        } elseif (strpos($string, "http://is7.mzstatic.com")===true) {
            return str_replace($string,"https://is7-ssl.mzstatic.com",$string);
        } elseif (strpos($string, "http://is8.mzstatic.com")===true) {
            return str_replace($string,"https://is8-ssl.mzstatic.com",$string);
        } elseif (strpos($string, "http://is9.mzstatic.com")===true) {
            return str_replace($string,"https://is9-ssl.mzstatic.com",$string);
        } else {
            return $string;
        }
    }
}