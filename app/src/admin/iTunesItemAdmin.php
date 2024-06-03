<?php   
use SilverStripe\Admin\ModelAdmin;

class iTunesItemAdmin extends ModelAdmin {
    private static $managed_models = array(
        iTunesItem::class
    );

    private static $url_segment = 'itunes-item';

    private static $menu_title = 'iTunes Item';
}
