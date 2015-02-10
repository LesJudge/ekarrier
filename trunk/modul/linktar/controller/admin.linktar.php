<?php
include_once 'page/admin/controller/admin.list.php';
/**
 * Linktár Admin List controller.
 */
class Linktar_Admin_Controller extends Admin_List{
    
    protected $_multiple_lang = false; // Nyelvesítés.
    protected $_verify_event_manual = false; // Kézi validálás.
    public $_name = 'LinktarList';
    
    public function __construct(){
        $this->__loadModel('_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/linktar/view/admin.linktar_list.tpl'));
    }

    public function onClick_Filter(){
        $this->setWhereInput('linktar_cim LIKE \'%:item%\'', 'FilterSzuro');
        if($this->getItemValue('FilterStatus')==1)
            $this->setWhereInput('linktar_aktiv=1', 'FilterStatus');
        elseif($this->getItemValue('FilterStatus')==2)
            $this->setWhereInput('linktar_aktiv=0', 'FilterStatus');
        else 
            unset($_SESSION[$this->_name]['FilterStatus']);
    }
}
?>