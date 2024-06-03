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

class ChartPlan extends DataObject {

    private static $db = [
        'Week' => 'Varchar',
        'Year' => 'Varchar',
        'ChartStatus' => 'Enum("Setup,Build,Review,Live")',

    ];

    private static $has_many = [
        'Classificas' => Classifica::class
    ];

    private static $summary_fields = [
        'Week' => 'Week',
        'Year' => 'Year',
        'ChartStatus' => 'ChartStatus'
    ];
}