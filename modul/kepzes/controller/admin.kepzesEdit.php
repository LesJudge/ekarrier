<?php
/**
 * @property Kepzes_Edit_Model $_model Model.
 * @property Smarty $_view Smarty.
 */
class KepzesEdit_Admin_Controller extends Admin_Edit
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'AdminKepzesEdit';
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->__loadModel('_Edit');
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
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/kepzes/view/admin.kepzes_edit.tpl'));
    }
}