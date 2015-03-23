<?php
include_once "page/admin/controller/admin.list.php";

class KompetenciaCommentlist_Admin_Controller extends Admin_List
{

        public $_name='KompetenciaCommentList';
        public $_multiple_lang = false;

        public function __construct()
        {
                $this->__loadModel('_Comment_List');
                parent::__construct();
                $this->__addParams($this->_model->_params);
                $this->__run();
        }

        public function __show()
        {
                parent::__show();
                Rimo::$_site_frame->assign('Form', $this->__generateForm('modul/kompetencia/view/admin.kompetencia_comment_list.tpl'));
        }

        public function onClick_Filter()
        {
                $nameFilter="k.kompetencia_nev LIKE '%:item%' OR 
                             ugyf.vezeteknev LIKE '%:item%' OR
                             ugyf.keresztnev LIKE '%:item%'
                                ";
                $this->setWhereInput($nameFilter,'FilterSzuro');
                // Státusz filter
                $filterStatus=$this->getItemValue('FilterStatus');
                switch($filterStatus)
                {
                        case 1:
                                $this->setWhereInput('kompetencia_hozzaszolas_aktiv=1','FilterStatus');
                                break;
                        case 2:
                                $this->setWhereInput('kompetencia_hozzaszolas_aktiv=0','FilterStatus');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterStatus']);
                                break;
                }
                
                $filterChecked=$this->getItemValue('FilterChecked');
                switch($filterChecked)
                {
                        case 1:
                                $this->setWhereInput('kompetencia_hozzaszolas.checked = 0','FilterChecked');
                                break;
                        case 2:
                                $this->setWhereInput('kompetencia_hozzaszolas.checked = 1','FilterChecked');
                                break;
                        default:
                                unset($_SESSION[$this->_name]['FilterChecked']);
                                break;
                }
        }

        
        protected function onClick_Publish(){
        UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]);
        try {
            $this->_model->__modifyRowStatusz("aktiv", $this->_events["BtnPublish"]->_value);
            throw new Exception_Form_Message(LANG_AdminList_msg_publikalas);
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
             throw new Exception_Form_Error($e->getMessage());
        }
    }
   
    protected function onClick_Unpublish(){
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]);
         try {
              $this->_model->__modifyRowStatusz("aktiv", $this->_events["BtnUnpublish"]->_value);
             throw new Exception_Form_Message(LANG_AdminList_msg_visszavonas);
         }catch(Exception_MYSQL_Null_Affected_Rows $e){
             throw new Exception_Form_Error($e->getMessage());
        }
    }
    
    protected function onClick_MultiplePublish(){
        UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]);
        if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try{
                    $this->_model->__modifyRowStatuszWithValue("aktiv", $val, 1);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_publikalas);
        }
    }
 
    protected function onClick_MultipleUnpublish(){
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]);
         if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try{
                    $this->_model->__modifyRowStatuszWithValue("aktiv", $val, 0);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_visszavonas);
        }
    }
    
    protected function onClick_MultipleDelete(){
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]);
         if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try {
                    $this->_model->__modifyRowStatuszWithValue("torolt", $val, 1);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_torles);
        }
    }
}