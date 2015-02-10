<?php
ob_start();
error_reporting(E_ERROR);
ini_set("display_errors", 1);

//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

chdir("..");
require_once 'RimoConfig.php';
include_once "Rimo.php";
include_once "admin/admin.config.php";
//Rimo::__addConfig();
include_once "page/admin/lang/".Rimo::$_config->ADMIN_NYELV_VAR.".php";
//Rimo::__addSession();
//Rimo::$_site_frame = new Smarty;
//Rimo::$_site_frame->assign("DOMAIN_ADMIN",  Rimo::$_config->DOMAIN_ADMIN);
//Rimo::$_site_frame->assign("DOMAIN",  Rimo::$_config->DOMAIN);
//Rimo::$_site_frame->assign("PAGE_CHARSET",  Rimo::$_config->PAGE_CHARSET);
Rimo::init();
try{
    
    $translate = Rimo::__loadPublic("model","nyelv_Translate","nyelv");
    Rimo::$translate = $translate;
    Rimo::__loadSiteElement("user", "loginout");
    if(UserLoginOut_Controller::$_id){
        Rimo::__loadSiteElement("nyelv", "select");
        Rimo::__loadSiteElement("menu", "show");
        if($_REQUEST["m"]){
            Rimo::__loadModul($_REQUEST["m"]);
        }
    }
}
catch(Exception_Load_error $e) {
    Rimo::$_site_frame->assign("ErrorMessage",$e->getMessage());
}

Rimo::$_site_frame->display("page/admin/view/admin.index.tpl");
ob_flush();