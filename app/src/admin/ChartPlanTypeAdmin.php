<?php   
use SilverStripe\Admin\ModelAdmin;

class ChartPlanTypeAdmin extends ModelAdmin {
    private static $managed_models = array(
        ChartPlanType::class
    );

    private static $url_segment = 'classifica-type';

    private static $menu_title = 'Classifica Type';
}
