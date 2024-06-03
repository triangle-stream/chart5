<?php

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\AssetAdmin\Forms\UploadField; 
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_HTMLProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Forms\GridField\GridField_SaveHandler;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;


class XMLChart extends Page {
    private static $db = array(
    );

    private static $has_one = array(
        'Image' => Image::class
    );

    private static $has_many = array(
        'Classificas' => Classifica::class
    );
    private static $owns = [
        'Classificas',
        'Image'
    ]; 

    public function getCMSFields() {
        // Get existing fields
        $fields = parent::getCMSFields(); 
        $fields->removeFieldFromTab("Root.Main","Content");
        $fields->addFieldToTab('Root.Main', UploadField::create('Image'),''); 
    	// Classifica 
        $fields->addFieldToTab('Root.Classifica', GridField::create(
            'Classificas',
            'Classificas',
            $this->Classificas(),
            GridFieldConfig_RecordEditor::create()
        )); 
        return $fields;
    }
}

