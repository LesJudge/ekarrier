<?php
class NyelvtudasNyelvedit_Admin_Controller extends Admin_Edit
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'AdminNyelvtudasNyelvEdit';
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->__loadModel('_NyelvEdit');
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
            $this->__generateForm('modul/nyelvtudas/view/admin.nyelvtudas_nyelv_edit.tpl')
        );
    }
}