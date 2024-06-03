<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\AssetAdmin\Forms\UploadField; 
    use SilverStripe\Assets\Image;

    class Page extends SiteTree
    {
        private static $db = [];

        private static $has_one = [
            'Image' => Image::class
        ];

        private static $owns = [
            'Image',
        ];

        public function updateCMSFields(FieldList $fields) {
            // Image Field 
            $fields->addFieldToTab('Root.Main', UploadField::create('Image'),'');  
            return $fields;
        }
    }
}
