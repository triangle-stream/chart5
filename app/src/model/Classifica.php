<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\AssetAdmin\Forms\UploadField; 
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File; 
use SilverStripe\Forms\CheckboxField;

class Classifica extends DataObject {

    private static $db = [
        'Settimana'     => 'Varchar',
        'Anno'          => 'Varchar',
        'Descrizione'   => 'Varchar', 
        'ChartID'       => 'Varchar',
        'ChartNation'   => 'Enum("Italia,International")',
        'Posizioni'     => 'Int',
        'Status'        => 'Enum("Live,Review,Build")',
        'ChartType'     => 'Enum("Locale,International,Mastering","Locale")',
        'ChartPeriod'   => 'Enum("Actual,Past,Next")'
    ];

    private static $defaults = [
        'Status' => 'Review'
    ];

    private static $has_one = [
        'Immagine' => Image::class,
        'ChartPlan' => ChartPlan::class,
        'XMLChart' => XMLChart::class
    ]; 

    private static $many_many = [
        'ClassificaItems' => ClassificaItem::class
    ]; 

    private static $summary_fields = [
        'ID' => 'ID',
        'ChartType' => 'ChartType',
        'Settimana' => 'Settimana',
        'Descrizione' => 'Descrizione',
        'Anno' => 'Anno'
    ];

    private static $casting = [
        'WeeAnno' => 'Varchar',
    ];

    public function getWeeAnno() 
    {
        return 'Week '. $this->Settimana . ' - '. $this->Anno;
    }
    
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
        $fields->addFieldToTab('Root.Main', TextField::create('ChartID', 'Chart ID'));
        $fields->addFieldToTab('Root.Main', NumericField::create('Posizioni', 'Quante posizioni ha la Classifica?'));
        $fields->addFieldToTab('Root.Main', TextField::create('Settimana', 'Settimana del'));
        $fields->addFieldToTab('Root.Main', TextField::create('Descrizione', 'Descrizione breve classifica'));
        $fields->addFieldToTab('Root.Main', UploadField::create('Immagine', 'Immagine della pagina')); 
        return $fields;
    }
}