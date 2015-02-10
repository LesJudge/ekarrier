<?php
include_once 'page/admin/controller/admin.list.php';

class {$modulnevUpper}{$modelnev}_Admin_Controller extends Admin_List{
    
    protected $_multiple_lang = {$multilang}; // Nyelvesítés.
    protected $_verify_event_manual = {$manual_validation}; // Kézi validálás.
    public $_name = '{$modelnev}_List';
    
    public function __construct(){
        $this->__loadModel('{$modelnev}_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/{$modulnev}/view/admin.{$modulnev}_{$modelnev}_list.tpl'));
    }

    public function onClick_Filter(){
        $this->setWhereInput('{$tablanev}_nev LIKE \'%:item%\'', 'FilterSzuro');
        if($this->getItemValue('FilterStatus')==1)
            $this->setWhereInput('{$tablanev}_aktiv=1', 'FilterStatus');
        elseif($this->getItemValue('FilterStatus')==2)
            $this->setWhereInput('{$tablanev}_aktiv=0', 'FilterStatus');
        else 
            unset($_SESSION[$this->_name]['FilterStatus']);
    }
}
?>