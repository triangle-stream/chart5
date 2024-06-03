<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\AssetAdmin\Forms\UploadField; 
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;

class iTunesItem extends DataObject {

    private static $db = [
        'wrapperType'   => 'Varchar',
        'artistType'   => 'Varchar',
        'artistLinkUrl'   => 'Text',
        'artistId'   => 'Varchar',
        'amgArtistId'   => 'Varchar',
        'primaryGenreName'   => 'Varchar',
        'primaryGenreId'   => 'Varchar',
        'collectionType'   => 'Varchar',
        'collectionId'   => 'Varchar',
        'collectionName'   => 'Text',
        'collectionCensoredName'   => 'Text',
        'artistViewUrl'   => 'Text',
        'collectionViewUrl'   => 'Text',
        'collectionPrice'   => 'Varchar',
        'collectionExplicitness'   => 'Varchar',
        'trackCount'   => 'Varchar',
        'copyright'   => 'Varchar',
        'country'   => 'Varchar',
        'currency'   => 'Varchar',
        'releaseDate'   => 'Varchar',
        'kind'   => 'Varchar',
        'trackId'   => 'Varchar',
        'artistName'   => 'Text',
        'trackName'   => 'Text',
        'trackCensoredName'   => 'Text',
        'trackViewUrl'   => 'Text',
        'previewUrl'   => 'Text',
        'artworkUrl60'   => 'Text',
        'artworkUrl100'   => 'Text',
        'trackPrice'   => 'Varchar',
        'trackExplicitness'   => 'Varchar',
        'discCount'   => 'Varchar',
        'discNumber'   => 'Varchar',
        'trackCount'   => 'Varchar',
        'trackNumber'   => 'Varchar',
        'trackTimeMillis'   => 'Varchar'
    ];

    private static $summary_fields = [
        'wrapperType' => 'wrapperType',
        'artistName' => 'artistName',
        'trackName' => 'trackName',
        'collectionName' => 'collectionName'
    ];
    
}