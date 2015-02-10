<?php
include_once "modul/".Rimo::$_config->APP_PATH."/controller/master_user_loginout.php";

class UserLoginOut_Site_Controller extends UserLoginOut_Controller
{
    public function __show()
    {
        parent::__show();
        if(!is_array(self::$_rights)) {
            self::$_rights["rigths_where"]=" modul_function_id=0 ";
            self::$_rights["jogcsoport_where"]=" jogcsoport_id=0 ";
        }

        if(!self::$_id) {
            Rimo::$_site_frame->assign("LoginForm", $this->__generateForm("modul/user/view/site.user.login.tpl"));
        }
        else {
            $menu=Rimo::__loadPublic('model', 'menu', 'menu');
            $userMenu = $menu->loadTree(2, self::$_rights['jogcsoport_where']);
            $this->_view->assign('userMenu', $userMenu);
            Rimo::$_site_frame->assign("LogoutForm", $this->__generateForm("modul/user/view/site.user.logout.tpl"));
        }
    }

}