<?php
require 'page/admin/controller/admin.edit.php';
require 'page/admin/model/admin.edit_model.php';

class NyelvtudasSzintedit_Admin_Controller extends Admin_Edit
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'AdminNyelvtudasSzintEdit';
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->__loadModel('_SzintEdit');
        parent::__construct();
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnSave', $this->_name));
        $this->__run();
    }
    /**
     * Render.
     */
    public function __show()
    {
        parent::__show();
        $this->_view->assign('recordStatus', $this->_model->modifyID > 0);
        Rimo::$_site_frame->assign(
            'Form',
            $this->__generateForm('modul/nyelvtudas/view/admin.nyelvtudas_szint_edit.tpl')
        );
    }
}