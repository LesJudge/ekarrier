 <?php
 require 'modul/seo/model/seo_Site_Model.php';
 require 'page/all/model/page.list_model.php';

class UgyfeluzenetekShow_Site_Controller extends Page_Edit
{

        public $_name="UgyfeluzenetekShow";

        public function __construct()
        {
            $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
            $this->__loadModel("_Show");
            parent::__construct();
            $this->__addParams($this->_model->_params);
            $this->__addEvent('BtnAddUzenet', 'addUzenet');
            $this->__addEvent('BtnDelUzenet', 'deleteUzenet');
            
            $this->__run();
              
        }

        public function __show()
        {
                parent::__show();
                try
                {        
                        $lId = Rimo::$_config->SITE_NYELV_ID;
                        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
                        
                        //Üzenetek
                        $messages = $this->_model->getUzenetek($clientId,$lId);
                        $this->_view->assign('messages',$messages);
                        

                        
                        Rimo::$_site_frame->assign('PageName',"Üzeneteim");
                        Rimo::$_site_frame->assign('site_title',"Üzeneteim");
                        Rimo::$_site_frame->assign('site_description',"Üzeneteim");
                        Rimo::$_site_frame->assign('site_keywords',"Üzeneteim");
                        Rimo::$_site_frame->assign('Content',$this->__generateForm('modul/ugyfeluzenetek/view/site.ugyfeluzenetek_show.tpl'));
                }
                catch(Exception_MYSQL $e)
                {
                        throw new Exception_404();
                }
        }
        
    public function onClick_addUzenet() {
        try{
            if(!empty($_REQUEST['message']))
            {
                $this->_model->addUzenet((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $_REQUEST['message']);
                throw new Exception_Form_Message('Üzenet elküldve!');
            }
            else
            {
                throw new Exception_Form_Error("Írjon be szöveget!");
            }
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        
    }
    
    public function onClick_deleteUzenet() {
        try{
            if((int)$_REQUEST['delMessageID'] < 0)
            {
                
                throw new Exception_Form_Error("Hiba történt!");
            }
            else
            {
             $this->_model->deleteUzenet((int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id), $_REQUEST['delMessageID']);
                throw new Exception_Form_Message('Sikeresen törölve!');
            }
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error("Hiba történt!");
        }
        
    }
    
}

?>