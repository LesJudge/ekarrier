<?php
include_once "page/all/controller/page.edit.php";
include_once "page/admin/model/admin.edit_model.php";
include_once "modul/email/site.email.php";

class UserEmlekezteto_Site_Controller extends RimoController {
    public $_name = "UserEmlekezteto";
    
    public function __construct() {
    	$this->_action_type = $_REQUEST;
        $this->__loadModel("_Emlekezteto");
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, "BtnSave", $this->_name));
        $this->__addEvent("BtnSave","Send");
        $this->__run();
    }
    
    public function __show(){
        parent::__show();
        try{
        	$tartalom_show_model = $this->__loadPublicModel("tartalom","_Show");
            $data = $tartalom_show_model->getTartalomFromID(7);
            Rimo::$_site_frame->assign("Indikator", array(1=>array("nev"=>$data[0]["tartalom_cim"])));
            Rimo::$_site_frame->assign("PageName", $data[0]["tartalom_cim"]);
            $this->_view->assign("jelszoemlekezteto_oldal",$data[0]["tartalom_tartalom"]);
            Rimo::$_site_frame->assign("site_title",$data[0]["tartalom_cim"]);
            Rimo::$_site_frame->assign("site_description",$data[0]["tartalom_leiras"]);
            Rimo::$_site_frame->assign("site_keywords",$data[0]["tartalom_meta_kulcsszo"]);
            
            Rimo::$_site_frame->assign("Content", $this->__generateForm("modul/user/view/site.emlekezteto.tpl"));  
        }
        catch(Exception_MYSQL $e){
            throw new Exception_404();
        }
    }
    
    public function onClick_Send(){
    	try{
			$user_data = $this->_model->getUser();   	
	    	$characters = "0123456789qwertzuioplkjhgfdsayxcvbnm,_QWERTZUIOPASDFGHJKLYXCVBNM";
	    	$string = "";    
	    	for ($i = 0; $i < 8; $i++) {
	        	$string .= $characters[mt_rand(0, strlen($characters))];
	    	}
	    	$user_data["user_jelszo"] = $string; 
	    	$this->sendEmail($user_data);
	    	$this->_model->updateUserPW($user_data["user_id"], $user_data["user_jelszo"]);   
	    	throw new Exception_Form_Message($this->_translate->__("Sikeres jelszóemlékeztető küldés"));
  		}catch(Exception_MYSQL_Null_Rows $e){
  			throw new Exception_Form_Error($this->_translate->__("Az e-mail cím nem szerepel a rendszerünkben"));
  		}
  		catch(phpmailerException $e){
  			throw new Exception_Form_Error($this->_translate->__("Sikertelen jelszóemlékeztető küldés"));
  		}
    }
    
    private function sendEmail($user_data){
    	$mailer = new RimoMailerFromDB($this->_model->_DB);
   	    $mailer->emailFromDB(2);
   	    $mailer->BodyTPL->assign("felhasznalonev", $user_data["user_fnev"]);
   	    $mailer->BodyTPL->assign("jelszo", $user_data["user_jelszo"]);
   	    $mailer->BodyTPL->assign("vezetek_nev", $user_data["user_vnev"]);
   	    $mailer->BodyTPL->assign("kereszt_nev", $user_data["user_knev"]);
   	    $mailer->AddAddress($user_data["user_email"]);
   	    $mailer->Send();
    }
    
}
?>