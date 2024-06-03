<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController; 
    use SilverStripe\Control\Director;
    use SilverStripe\View\Requirements;

    class PageController extends ContentController
    { 
        private static $allowed_actions = [];

        protected function init() {
            parent::init(); 
            Requirements::javascript("//code.jquery.com/jquery-3.6.3.min.js");
            Requirements::javascript("//cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js");
            Requirements::javascript("//cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js");
            Requirements::javascript("//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js");
            Requirements::javascript("public/js/script.js");
            Requirements::css("//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css");
            Requirements::css("//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css");
            Requirements::css("//cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css");
            Requirements::css("public/css/charts.css");
            Requirements::css("public/css/all.min.css");
        }
    }
}



