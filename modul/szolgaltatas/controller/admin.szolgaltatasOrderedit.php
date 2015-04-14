<?php
/**
 * @property Szolgaltatas_Edit_Model $_model Model.
 * @property Smarty $_view Smarty.
 */
class SzolgaltatasOrderedit_Admin_Controller extends Admin_Edit
{
    /**
     * Controller neve.
     * @var string
     */
    public $_name = 'SzolgaltatasOrderEdit';
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->__loadModel('_Order_Edit');
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
        $this->_view->assign('cegnev', $this->_model->getName($this->_model->_params['SelCeg']->_value));
        
        $clients = $this->_model->getClients($this->_model->modifyID);
        
        $this->_view->assign('clients',$clients);
        //depr
        /*
        $folders = $this->_model->getFolders($this->_model->modifyID);
        $result = array();
        foreach($folders as $key=>$value){
            $result[] = $this->_model->getClientsByFolder($value['mappa_id'],$this->_model->modifyID);
        }
        $this->_view->assign('folders', $result);
        */
        
        $this->_view->assign('recordStatus', $this->_model->modifyID > 0);
        Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/szolgaltatas/view/admin.szolgaltatas_order_edit.tpl'));
    }
}