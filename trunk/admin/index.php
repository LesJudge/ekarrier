<?php
ob_start();
//error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_WARNING | E_USER_ERROR | E_COMPILE_ERROR);

//error_reporting(E_ALL);

ini_set('display_errors', 1);
chdir('..');
require 'vendor/autoload.php';

Rimo::init();
// DependencyInjection
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Gregwar\Cache\Options);
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Gregwar\Cache\Cache);
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Gregwar\Cache\Adapter);
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Smarty\SmartyProvider);

Rimo::getConfig()->set(require 'admin/admin.config.php');
include_once 'page/admin/lang/' . Rimo::$_config->ADMIN_NYELV_VAR . '.php';
try{    
    Rimo::initSiteFrame();
    $translate = Rimo::__loadPublic('model', 'nyelv_Translate', 'nyelv');
    Rimo::$translate = $translate;
    Rimo::__loadSiteElement('user', 'loginout');
    if (UserLoginOut_Controller::$_id) {
        
        Rimo::__loadSiteElement('nyelv', 'select');
        Rimo::__loadSiteElement('menu', 'show');
        if(isset($_REQUEST['m'])) {
            Rimo::__loadModul($_REQUEST['m']);
        }
    }
} catch(Exception_Load_error $e) {
    Rimo::$_site_frame->assign('ErrorMessage', $e->getMessage());
}
Rimo::$_site_frame->display('page/admin/view/admin.index.tpl');
ob_flush();
//Rimo::__addSession();
//Rimo::$_site_frame = new Smarty;
//Rimo::$_site_frame->assign("DOMAIN_ADMIN",  Rimo::$_config->DOMAIN_ADMIN);
//Rimo::$_site_frame->assign("DOMAIN",  Rimo::$_config->DOMAIN);
//Rimo::$_site_frame->assign("PAGE_CHARSET",  Rimo::$_config->PAGE_CHARSET);