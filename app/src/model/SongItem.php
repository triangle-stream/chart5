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
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_HTMLProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Forms\GridField\GridField_SaveHandler;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;

class SongItem extends DataObject {

    private static $db = [
        'songFP' => 'Text',
        'titleid' => 'Text',
        'title_single' => 'Varchar',  // è il title nell'xml
        'artist_slug' => 'Varchar',
        'artistid' => 'Text',
        'artist_name' => 'Varchar',
        'imprint' => 'Varchar',
        'label' => 'Varchar',
        'feature_code' => 'Varchar',
        'genre' => 'Enum("Pop,Italiana,HipHop,Rock,Elettronica,NoTag")',
        'subgenre' => 'Enum("Pop,Italiana,HipHop,Rock,Elettronica,NoTag")',
        // dati dentro voce images poi sizes poi original di item
        'Width' => 'Varchar',
        'Height' => 'Varchar',
        'Peak' => 'Int',
        'isAlbum' => 'Boolean',
        'hasItunes' => 'Boolean',
        'hasLookup' => 'Boolean',
        // END - dati dentro voce images di item
    ];

    private static $has_one = [
        // dati dentro voce images poi sizes poi original di item
        'iTunesItem' => iTunesItem::class,
    ];

    private static $summary_fields = [
        'title_single' => 'Titolo',
        'artist_name' => 'Artista',
        'genre' => 'Genere',
        'subgenre' => 'SubGenere',
        'isAlbum' => 'isAlbum',
        'titleid' => 'titleid',
        'artistid' => 'artistid',
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

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);
        // $gridFieldName is generated from the ModelClass, eg if the Class 'Product'
        // is managed by this ModelAdmin, the GridField for it will also be named 'Product'
        $gridFieldName = $this->sanitiseClassName($this->modelClass);
        $gridField = $form->Fields()->fieldByName($gridFieldName);
        // modify the list view.
        $gridField->getConfig()->addComponent(new GridFieldFilterHeader());
        return $form;
    }
}