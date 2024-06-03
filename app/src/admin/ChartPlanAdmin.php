<?php   
use SilverStripe\Admin\ModelAdmin;

class ChartPlanAdmin extends ModelAdmin {
    private static $managed_models = array(
        ChartPlan::class
    );

    private static $url_segment = 'classifica-plan';

    private static $menu_title = 'Piano classifica';
}
