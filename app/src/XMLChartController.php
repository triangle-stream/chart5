<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\ArrayData;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\NumericField;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\RequiredFields;
    use SilverStripe\Forms\TextField;

    class XMLChartController extends PageController { 
        private static $allowed_actions = array(
            'WeekSelectForm'
        );

        public function init() {
            parent::init();
        }

        public function createDiv($num) {
            $num = Classifica::get("Posizioni");
            foreach( range(1,$num) as $item){
                echo 'pippo';
            }
            return $item;
        }

        public function getWeekAndYear() {
            return $this->Classificas()->Settimana . ' - ' . $this->Classificas()->Anno;
        }

        public function WeekSelectForm() {  
            $fields = new FieldList(
                DropdownField::create('Settimana', 'Settimana', $this->Classificas()->sort('ID','DESC')->map('ID', 'WeeAnno'))->setEmptyString('Seleziona la settimana')
            );
            $actions = new FieldList(
                FormAction::create("doWeekSelect")->setTitle("Seleziona")
            ); 
            $form = new Form($this, 'WeekSelectForm', $fields, $actions);
            return $form;
        }

        public function doWeekSelect($data, Form $form) {
            $Week = $data['Settimana'] ; 
            $Classifica = Classifica::get()->byID($Week);
            $WeekNumber = $Classifica->Settimana; 
            return $this->customise(new ArrayData(array(
                'Week' => $Week,
                'WeekNumber' => $WeekNumber
            )));
        }

        public function SingleClassifica($id) {
            $Classifica = Classifica::get()->byID($id);
            $ClassificaItems = $Classifica->ClassificaItems();
            return $ClassificaItems;
        }

        public function SingleClassificaFirst() {
            $Classifica = $this->Classificas()->last() ;
            $ClassificaItems = $Classifica->ClassificaItems();
            return $ClassificaItems;
        }

        public function SingleClassificaFirstWeek() {
            $Classifica = $this->Classificas()->last();
            return $this->customise(new ArrayData(array(
                'WeekNumber' => $Classifica->Settimana
            )));
        }

        public function firstDayOfWeek($week_no) {
            $dateNow = new DateTime(); 
            $year = $dateNow->format("Y"); 
            $date = new DateTime();
            $date->setISODate($year,$week_no);
            return $date->format('d/m/Y');
        }
    }
}
