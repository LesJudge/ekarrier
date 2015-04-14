<?php
ob_start();
//error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_WARNING | E_USER_ERROR | E_COMPILE_ERROR);

//error_reporting(E_ALL);

ini_set('display_errors', 0);
chdir('..');
require 'vendor/autoload.php';
Rimo::init();
// DependencyInjection
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Gregwar\Cache\Options);
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Gregwar\Cache\Cache);
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Gregwar\Cache\Adapter);
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Smarty\SmartyProvider);

//Rimo::getConfig()->set(require 'admin/admin.config.php');
include_once "admin/admin.config.php";
Rimo::__addConfig();
include_once 'page/admin/lang/' . Rimo::$_config->ADMIN_NYELV_VAR . '.php';
try{    
    Rimo::initSiteFrame();
    $translate = Rimo::__loadPublic('model', 'nyelv_Translate', 'nyelv');
    Rimo::$translate = $translate;
    Rimo::__loadSiteElement('user', 'loginout');
    
    Rimo::__loadPublic('model', 'ertesites_Show', 'ertesites');
    
    try{
        $unreadMessages = ertesites_Show_Model::model()->getUnreadMessages();
        $unreadComments = ertesites_Show_Model::model()->getUnreadComments();
        $unreadLinks = ertesites_Show_Model::model()->getUnreadLinks();
        $unreadOpinions = ertesites_Show_Model::model()->getUnreadOpinions();
        $unreadForumTopics = ertesites_Show_Model::model()->getUnreadForumTopics();
        $unreadForumComments = ertesites_Show_Model::model()->getUnreadForumComments();
        $unreadComps = ertesites_Show_Model::model()->getUnreadComps();


        Rimo::$_site_frame->assign('urMessages', $unreadMessages[0]['cnt']);
        Rimo::$_site_frame->assign('urComments', $unreadComments[0]['cnt']);
        Rimo::$_site_frame->assign('urLinks', $unreadLinks[0]['cnt']);
        Rimo::$_site_frame->assign('urOpinions', $unreadOpinions[0]['cnt']);
        Rimo::$_site_frame->assign('urForumTopics', $unreadForumTopics[0]['cnt']);
        Rimo::$_site_frame->assign('urForumComments', $unreadForumComments[0]['cnt']);
        Rimo::$_site_frame->assign('urComps', $unreadComps[0]['cnt']);
    }catch(Exception_MYSQL $e){
        Rimo::$_site_frame->assign('notiferror', 'Hiba történt az értesítések lekérdezése közben!');
    }
    
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