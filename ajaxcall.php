<?php
ini_set("display_errors",0);
define('','Nincs megjelenítendő elem!');
include_once 'Rimo.php';
include_once 'site.config.php';
Rimo::__addConfig();
//include_once 'page/admin/lang/'.Rimo::$_config->ADMIN_NYELV_VAR.'.php';
Rimo::__addSession();
Rimo::$_site_frame=new Smarty;
Rimo::$_site_frame->assign('DOMAIN_ADMIN',Rimo::$_config->DOMAIN_ADMIN);
Rimo::$_site_frame->assign('DOMAIN',Rimo::$_config->DOMAIN);
Rimo::$_site_frame->assign('PAGE_CHARSET',Rimo::$_config->PAGE_CHARSET);
try
{
        $translate=Rimo::__loadPublic('model','nyelv_Translate','nyelv');
        Rimo::$translate=$translate;
        if($_REQUEST['m'])
        {
                Rimo::__loadModul($_REQUEST['m']);
        }
        else
        {
                header('HTTP/1.0 500');
                exit;
        }
}
catch(Exception_Load_error $e)
{
        echo $e->getMessage();
        //header('HTTP/1.0 500');
        //Rimo::$_site_frame->assign('ErrorMessage',$e->getMessage());
}