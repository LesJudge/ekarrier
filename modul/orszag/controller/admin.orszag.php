<?php
include_once 'page/admin/controller/admin.list.php';

class Orszag_Admin_Controller extends Admin_List
{
    public $_name = 'OrszagList';
    
    protected $_multiple_lang = false;
    
    public function __construct()
    {
        $this->__loadModel('_List');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__run();
    }
    
    public function __show()
    {
        parent::__show();
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/orszag/view/admin.orszag_list.tpl'));
    }

    public function onClick_Filter()
    {
        $this->setWhereInput('nev LIKE \'%:item%\' OR kod LIKE \'%:item%\' ', 'FilterSzuro');
    }
}
