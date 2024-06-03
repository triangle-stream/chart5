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

class ChartPlanType extends DataObject {

    private static $db = [
        'Descrizione' => 'Text', 
        'ChartID' => 'Text',
        'ChartNation' => 'Enum("Italia,International")',
        'Posizioni' => 'Int',
        'ChartSourceType' => 'Enum("File,FileXML,Url")',
        'ChartTypeDefine' => 'Enum("Locale,International,Mastering")',
        'ChartSource' => 'Text',
        'ChartGenre' => 'Boolean'
    ];

    private static $summary_fields = [
        'ChartID' => 'ChartID',
        'Descrizione' => 'Descrizione',
        'Posizioni' => 'Posizioni',
        'ChartGenre' => 'È di genere?'
    ];
    
}