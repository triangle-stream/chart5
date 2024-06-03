<?php   
use SilverStripe\Admin\ModelAdmin;

class ClassificaAdmin extends ModelAdmin {
    private static $managed_models = [
        Classifica::class
    ];

    private static $url_segment = 'classifica';

    private static $menu_title = 'Classifica';
}
