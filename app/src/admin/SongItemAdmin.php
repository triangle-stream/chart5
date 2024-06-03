<?php
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDetailForm;


class SongItemAdmin extends ModelAdmin {
    private static $managed_models = [
        SongItem::class
    ];

    private static $model_importers = [
        'SongItem' => SongItemCsvBulkLoader::class
    ];

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);

        // $gridFieldName is generated from the ModelClass, eg if the Class 'Product'
        // is managed by this ModelAdmin, the GridField for it will also be named 'Product'

        $gridFieldName = $this->sanitiseClassName($this->modelClass);
        $gridField = $form->Fields()->fieldByName($gridFieldName);

        // modify the list view.   
        $gridField->getConfig()->addComponent(GridFieldFilterHeader::create());
        // $gridField->getConfig()->addComponent(GridFieldEditableColumns::create());
        $gridField->getConfig()->addComponent(new SaveAllButton()); //magio SaveAllButton
    

        return $form;
    }

    private static $url_segment = 'brani';

    private static $menu_title = 'Brani';
}
