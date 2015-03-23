<?php
abstract class UserLoginOut_Controller extends RimoController
{
    public static $_id;
    public static $_rights;
    public static $userData = array();
    public static $reservedRgs = array(
        'user' => 2,
        'company' => 3
    );

    public function __construct()
    {
        $this->_action_type = $_REQUEST;
        static::$_id = isset($_SESSION['user_data']['user_id']) ? $_SESSION['user_data']['user_id'] : null; // DEBUG
        static::$_rights = isset($_SESSION['user_rights']) ? $_SESSION['user_rights'] : null; // DEBUG
        $this->__loadModel('_Login');
        if (!static::$_id) { 
            $this->Login();   
        } else {
            $this->Logout();
        }      
    }
    
    private function Login()
    {
        $this->_model->loginForm();
        $this->_name = 'LoginForm';
        $this->__addParams($this->_model->_params);
        $this->__addScript(Create::JQUERY_verify($this->_params, 'BtnLogin', $this->_name));
        //$login = $this->__addEvent('BtnLogin', 'Login');
        $this->__addEvent('BtnLogin', 'Login');
        $this->__run();
        if (static::$_id) {
            $this->Logout();
        }
    }
    
    private function Logout()
    {
        $this->_name = 'LogoutForm';
        $login = $this->__addEvent('BtnLogout', 'Logout');
        $login = $this->__addEvent('BtnEdit', 'Edit');
        $this->__run();        
        if (!static::$_id) {
            $this->Login();
        }
    }
    
    //TODO: user adatok kirakása máshogy (array_key)
    public function __show()
    {
        if (static::$_id) {
            $user = $this->_model->loadUser(static::$_id);
            // EDIT
            $userData = array();
            $userData['username'] = $user['user_fnev'];
            //$userData['firstname']=$user['user_knev'];
            //$userData['lastname']=$user['user_vnev'];
            $userData['email'] = $user['user_email'];
            static::$userData=$userData;
            // END EDIT
            $this->_view->assign("felhasznalonev",$user["user_fnev"]);  
            $this->_view->assign("user_id",self::$_id);  
        }
    }

    protected function onClick_Login()
    {
        try {
            static::$_rights = $_SESSION['user_rights'] = array(
                'rigths_where' => ' modul_function_id=0 ',
                'jogcsoport_where' =>  ' jogcsoport_id=0 '
            );
            
            if(Rimo::$_config->SITE_TIPUS == 2){
                if($_SESSION['type']=="mv"){
                    $user = $this->_model->login($this->getItemValue('TxtFnev'), $this->getItemValue('PassJelszo'),"mv");
                }elseif($_SESSION['type']=="ma"){
                    $user = $this->_model->login($this->getItemValue('TxtFnev'), $this->getItemValue('PassJelszo'),'ma');
                }else{
                    $user = $this->_model->login($this->getItemValue('TxtFnev'), $this->getItemValue('PassJelszo'),'');
                }
            }else{
                $user = $this->_model->login($this->getItemValue('TxtFnev'), $this->getItemValue('PassJelszo'),'');
            }
            
            //$user = $this->_model->login($this->getItemValue('TxtFnev'), $this->getItemValue('PassJelszo'));
            $rights =  $this->_model->loadRights($user[0]);			
            if ($user['user_aktiv'] == 0 || $user['user_torolt'] == 1 || $user['user_megerositve'] == 0) {
                throw new Exception_Form_Error($this->_translate->__('Felhasználónév és vagy a jelszó nem megfelelő'));
            }
            $_SESSION['user_data'] = $user;            
            static::$_id = $user[0];
            static::$_rights = $_SESSION['user_rights'] = $rights;
            $this->_model->modifyUser(static::$_id);
            if (Rimo::$_config->SITE_TIPUS == 2) {
                if($_SESSION['type'] == "mv")
                {
                    header('Location: ' . Rimo::$_config->DOMAIN . 'fooldal/');
                }
                if($_SESSION['type'] == "ma")
                {
                    header('Location: ' . Rimo::$_config->DOMAIN . 'profil/');
                }
            }
        } catch (Exception_MYSQL_Null_Rows $e) {  	
            throw new Exception_Form_Error($this->_translate->__('Felhasználónév és vagy a jelszó nem megfelelő'));
        }
    }

    protected function onClick_Logout()
    {
        static::$_id = 0;
        static::$_rights = array();
        session_destroy();
        unset($_SESSION);
        static::$_rights = $_SESSION['user_rights'] = array(
            'rigths_where' => ' modul_function_id=0 ',
            'jogcsoport_where' => ' jogcsoport_id=0 '
        );
    }
    
    public static function verifyControllerAccess($modul_function_azon)
    {
        if (!self::$_rights['__loadController'][$_REQUEST['m']][$modul_function_azon]) {
            throw Exception_Load::Create_Error('Controller_Access', '');
        }
    }
    
    public static function verifyFunctionAccess($modul_function_azon)
    {
        if (!self::$_rights['__loadController'][$_REQUEST['m']][$modul_function_azon]) {
            throw new Exception_Form_Error('Önnek nincs joga a kért művelet elvégzésére');
        }
    }
    
    public static function verifyJogcsoportAccess($jogcsoport_id)
    {
        if (!isset(self::$_rights['jogcsoport'][$jogcsoport_id]) && $jogcsoport_id != 0) {
            throw Exception_Load::Create_Error('Controller_Access', '');
        }
    }
}