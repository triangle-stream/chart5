<?php   
use SilverStripe\Admin\ModelAdmin;

class ClassificaItemAdmin extends ModelAdmin {
    private static $managed_models = [
        ClassificaItem::class
    ];

    private static $url_segment = 'classifica-item';

    private static $menu_title = 'Posizioni Classifica';
}
