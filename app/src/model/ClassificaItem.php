<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField; 
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;

class ClassificaItem extends DataObject {

    private static $db = [
        // intro - dati presenti solo una volta all'inizio dell'xml
        'feed_name'             => 'Text',
        'feed_datetime'         => 'Text', 
        'copyright'             => 'Text', 
        'chart_code'            => 'Text', 
        'chart_name'            => 'Text', 
        'chart_type'            => 'Text', 
        'chart_size'            => 'Int',  
        'chart_date'            => 'Text',  
        'previous_chart_date'   => 'Text',  
        'next_chart_date'       => 'Text', 
        // item - Dati dentro 'items'
        'rank'                  => 'Int',  
        'titleid'               => 'Text',  
        'title_single'          => 'Text',  // è il title nell'xml
        'artist_slug'           => 'Text',  
        'artistid'              => 'Text',  
        'artist_name'           => 'Text',  
        'imprint'               => 'Text',  
        'label'                 => 'Text',  
        'feature_code'          => 'Text',
        // dati dentro voce history di item
        'debut_date'            => 'Int',
        'debut_rank'            => 'Int',
        'peak_date'             => 'Int',
        'peak_rank'             => 'Int',
        'last_week'             => 'Int',
        'two_weeks'             => 'Int',
        'weeks_on_chart'        => 'Int',
        're_entry'              => 'Text',
        // END - dati dentro voce history di item
        // dati dentro voce bullets di item
        'bullet'                => 'Boolean',
        'bullet_desc'           => 'Boolean',
        'bullet_lw'             => 'Boolean',
        'bullet_2w'             => 'Boolean',
        // END - dati dentro voce bullets di item
        // dati dentro voce awards di item
        'hotshot_debut'         => 'Boolean',
        'airplay_gainer'        => 'Boolean',
        'digital_sales_gainer'  => 'Boolean',
        'greatest_gainer'       => 'Boolean',
        'heatseeker_graduate'   => 'Boolean',   
        'pacesetter'            => 'Boolean',
        'streaming_gainer'      => 'Boolean',
        // END - dati dentro voce awards di item
        // dati dentro voce images poi sizes poi original di item
        'Width'                 => 'Text',
        'Height'                => 'Text',
        'genre_rank'            => 'Int',
        // ITUNES - dati dentro voce images di item
        'artworkUrl100'         => 'Text',
        'previewUrl'            => 'Text',
        'trackViewUrl'          => 'Text',
        'trackId'               => 'Varchar',
        'collectionViewUrl'     => 'Text'
        // END - dati dentro voce images di item
    ];

    private static $has_one = [
        // dati dentro voce images poi sizes poi original di item
        'Name' => Image::class, 
    ]; 

    private static $owns = [
        'Name',
    ];

    private static $summary_fields = [
        'chart_name' => 'ID',
        'rank' => 'rank',
        'genre_rank' => 'genre_rank',
        'title_single' => 'title_single',
        'artist_name' => 'artist_name',
    ];
    
    public function canView($member = null) 
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canEdit($member = null) 
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canDelete($member = null) 
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function canCreate($member = null, $context = []) 
    {
        return Permission::check('CMS_ACCESS_CMSMain', 'any', $member);
    }

    public function getCMSFields(){
        $fields = parent::getCMSFields();   
        // intro - dati presenti solo una volta all'inizio dell'xml
        $fields->addFieldToTab('Root.Main', TextField::create('feed_name', 'feed_name'));
        $fields->addFieldToTab('Root.Main', TextField::create('feed_datetime', 'feed_datetime'));
        $fields->addFieldToTab('Root.Main', TextField::create('copyright', 'copyright'));
        $fields->addFieldToTab('Root.Main', TextField::create('chart_code', 'chart_code')); 
        $fields->addFieldToTab('Root.Main', TextField::create('chart_name', 'chart_name')); 
        $fields->addFieldToTab('Root.Main', TextField::create('chart_type', 'chart_type'));
        $fields->addFieldToTab('Root.Main', NumericField::create('chart_size', 'chart_size'));  
        $fields->addFieldToTab('Root.Main', TextField::create('chart_date', 'chart_date')); 
        $fields->addFieldToTab('Root.Main', TextField::create('previous_chart_date', 'previous_chart_date'));
        $fields->addFieldToTab('Root.Main', TextField::create('next_chart_date', 'next_chart_date'));
        // item - Dati dentro 'items'
        $fields->addFieldToTab('Root.Main', NumericField::create('rank', 'rank')); 
        $fields->addFieldToTab('Root.Main', TextField::create('titleid', 'title_id')); 
        $fields->addFieldToTab('Root.Main', TextField::create('title_single', 'title'));  
        $fields->addFieldToTab('Root.Main', TextField::create('artist_slug', 'artist_slug')); 
        $fields->addFieldToTab('Root.Main', TextField::create('artistid', 'artist_id')); 
        $fields->addFieldToTab('Root.Main', TextField::create('artist_name', 'artist_name'));  
        $fields->addFieldToTab('Root.Main', TextField::create('imprint', 'imprint'));  
        $fields->addFieldToTab('Root.Main', TextField::create('label', 'label'));  
        $fields->addFieldToTab('Root.Main', TextField::create('feature_code', 'feature_code'));
        $fields->addFieldToTab('Root.Main', TextField::create('debut_date', 'debut_date'));
        $fields->addFieldToTab('Root.Main', TextField::create('peak_date', 'peak_date'));
        // dati dentro voce history di item
        $fields->addFieldToTab('Root.Main', NumericField::create('peak_rank', 'peak_rank'));
        $fields->addFieldToTab('Root.Main', NumericField::create('last_week', 'last_week'));
        $fields->addFieldToTab('Root.Main', NumericField::create('two_weeks', 'two_weeks'));
        $fields->addFieldToTab('Root.Main', NumericField::create('weeks_on_chart', 'weeks_on_chart'));
        $fields->addFieldToTab('Root.Main', TextField::create('re_entry', 're_entry'));
        // END - dati dentro voce history di item
        // dati dentro voce bullets di item
        $fields->addFieldToTab('Root.Main', CheckboxField::create('bullet', 'bullet'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('bullet_desc', 'bullet_desc'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('bullet_lw', 'bullet_lw'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('bullet_2w', 'bullet_2w'));
        // END - dati dentro voce bullets di item
        // dati dentro voce awards di item
        $fields->addFieldToTab('Root.Main', CheckboxField::create('hotshot_debut', 'hotshot_debut'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('airplay_gainer', 'airplay_gainer'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('digital_sales_gainer', 'digital_sales_gainer'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('greatest_gainer', 'greatest_gainer'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('heatseeker_graduate', 'heatseeker_graduate'));  
        $fields->addFieldToTab('Root.Main', CheckboxField::create('pacesetter', 'pacesetter'));
        $fields->addFieldToTab('Root.Main', CheckboxField::create('streaming_gainer', 'streaming_gainer'));
        // END - dati dentro voce awards di item
        // dati dentro voce images poi sizes poi original di item
        $fields->addFieldToTab('Root.Main', $IMGupload = UploadField::create('Name', 'immagine del singolo')); 
        $fields->addFieldToTab('Root.Main', TextField::create('Width', 'Width'));
        $fields->addFieldToTab('Root.Main', TextField::create('Height', 'Height'));
        // END - dati dentro voce images di item
        $IMGupload->setFolderName('AlbumArt');
        $IMGupload->getValidator()->setAllowedExtensions(array('jpg','jpeg','png','gif'));
        // Return Fields
        return $fields;
    }
}