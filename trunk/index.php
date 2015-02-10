<?php
error_reporting(E_ERROR);
ini_set("display_errors",1);
require_once 'RimoConfig.php';
require_once 'Rimo.php';
$siteConfig = require 'site.config.php';
Rimo::init();
Rimo::getConfig()->set($siteConfig);
//define('', 'Nincs megjelenítendő elem!');
//include_once 'page/admin/lang/'.Rimo::$_config->ADMIN_NYELV_VAR.'.php';


try {
    $translate=Rimo::__loadPublic('model', 'nyelv_Translate', 'nyelv');
    Rimo::$translate=$translate;
    $translate->translateFormMessage();

    Rimo::__loadSiteElement('user', 'loginout');
    Rimo::__loadSiteElement('menu', 'show');
    Rimo::__loadSiteElement('hirlevel', 'feliratkozas');

    $menu=Rimo::__loadPublic('model','menu','menu');
    $footerMenu=$menu->loadTree(3, UserLoginOut_Site_Controller::$_rights['jogcsoport_where']);
    Rimo::$_site_frame->assign('footerMenu',$footerMenu);
    
    if(!$_SESSION['type']){
        if($_REQUEST['type']){
            $_SESSION['type']=$_REQUEST['type'];
        }
    }
    if((isset($_SESSION['type']) && $_SESSION['type']=='ma')){
        Rimo::$_config->MASTER_TPL = 'page/all/view/page.ma.index.tpl';
       
    }
    
    if($_REQUEST['m']) {
        Rimo::__loadModul($_REQUEST['m']);
    }
    
} catch(Exception_Load_error $e) {
    Rimo::$_site_frame->assign('ErrorMessage', $e->getMessage());
} catch(Exception_404 $e) {
    try {
        $tartalomObj=Rimo::__loadPublic('model', 'tartalom_Show', 'tartalom');
        $tartalom   =$tartalomObj->getTartalomFromID(1);
        Rimo::$_site_frame->assign('Indikator', array(1=>array('nev'=>$tartalom[0]['tartalom_cim'])));
        Rimo::$_site_frame->assign('PageName', $tartalom[0]['tartalom_cim']);
        Rimo::$_site_frame->assign('site_title', $tartalom[0]['tartalom_cim']);
        Rimo::$_site_frame->assign('site_description', $tartalom[0]['tartalom_leiras']);
        Rimo::$_site_frame->assign('site_keywords', $tartalom[0]['tartalom_meta_kulcsszo']);
        Rimo::$_site_frame->assign('Content', $tartalom[0]['tartalom_tartalom']);
    } catch(Exception $e) {

    }
}
$loggedIn=(UserLoginOut_Site_Controller::$_id > 0) ? true : false;
Rimo::$_site_frame->assign('loggedIn',$loggedIn);

Rimo::$_site_frame->assign('userData',  UserLoginOut_Site_Controller::$userData);
if (Rimo::$_config->MASTER_TPL === 'page/all/view/page.index.tpl') {
    /*Rimo::$_site_frame->assign(
        'userMenu',
        $menu->loadTree(2, UserLoginOut_Site_Controller::$_rights['jogcsoport_where'])
    );*/
}


if(!$_SESSION['type'] || $_REQUEST['type']=='cl'){
    require 'modul/infobox/model/infobox_Site_Model.php';
    $lId=Rimo::$_config->SITE_NYELV_ID;
    $munkavallaloInfo=infobox_Site_Model::model()->findInfoboxItemByKey('siteTypeSelectMunkavallInfobox',$lId);
    Rimo::$_site_frame->assign('munkavallaloInfo',$munkavallaloInfo);
    $munkaltatoInfo=infobox_Site_Model::model()->findInfoboxItemByKey('siteTypeSelectMunkaltatoInfobox',$lId);
    Rimo::$_site_frame->assign('munkaltatoInfo',$munkaltatoInfo);
    Rimo::$_config->MASTER_TPL="page/all/view/page.select.tpl";
    
    if($_REQUEST['type']=='cl'){
        unset($_SESSION['type']);
    }
}

/*
if(UserLoginOut_Site_Controller::$_id > 0){
    try{
        $clientId = (int)Rimo::getClientWebUser()->verify(UserLoginOut_Site_Controller::$_id);
    }catch(Exception $e){
    }
    try{
        $companyId = (int)Rimo::getCompanyWebUser()->verify(UserLoginOut_Site_Controller::$_id);
    }catch(Exception $e){
    }

    if($clientId){Rimo::$_site_frame->assign('loggedInMv',"1");}
    if($companyId){Rimo::$_site_frame->assign('loggedInMa',"1");}
}
*/



// Változók átadása a site frame-nek, site renderelése.
Rimo::$_site_frame->assignByRef('lang', $translate->translate(9999));
Rimo::$_site_frame->assign('FBLike',Rimo::$_config->FB_LIKEBOX);
Rimo::$_site_frame->display(Rimo::$_config->MASTER_TPL);
