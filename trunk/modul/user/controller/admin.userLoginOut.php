<?php
include_once "modul/".Rimo::$_config->APP_PATH."/controller/master_user_loginout.php";
class UserLoginOut_Admin_Controller extends UserLoginOut_Controller{
    public function __show(){
        parent::__show();
        if(!self::$_id){
            Rimo::$_site_frame->assign("LoginForm", $this->__generateForm("modul/user/view/adminuser.login.tpl"));
        }
        else{
            Rimo::$_site_frame->assign("LogoutForm", $this->__generateForm("modul/user/view/adminuser.logout.tpl"));
        }
    }
}
?>