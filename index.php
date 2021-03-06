<?php
ob_start();
require 'vendor/autoload.php';
error_reporting(E_ALL ^ E_DEPRECATED);
//error_reporting(E_ALL);
ini_set("display_errors",0);
include_once "site.config.php";

//require_once 'RimoConfig.php';
//require_once 'Rimo.php';
Rimo::init();
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Smarty\SmartyProvider);
Rimo::initSiteFrame();
require 'modul/infobox/model/infobox_Site_Model.php';
//Rimo::getConfig()->set(require 'site.config.php');
//Rimo::__addConfig();
//define('', 'Nincs megjelenítendő elem!');
//include_once 'page/admin/lang/'.Rimo::$_config->ADMIN_NYELV_VAR.'.php';
include_once 'page/admin/lang/hu.php';


try {
    $translate=Rimo::__loadPublic('model', 'nyelv_Translate', 'nyelv');
    Rimo::$translate=$translate;
    $translate->translateFormMessage();

    //try {
        Rimo::__loadSiteElement('user', 'loginout');
        Rimo::__loadSiteElement('menu', 'show');
        Rimo::__loadSiteElement('hirlevel', 'feliratkozas');
    //} catch (Exception $e) {
    //    echo '<pre>', print_r($e->getTrace(), true), '</pre>';
    //    echo $e->getMessage();
    //}
    $menu=Rimo::__loadPublic('model','menu','menu');
    
    
    
    /**
     * @todo Gergő - Kérlek, ellenőrizd, hogy így is jó-e!
     */
    
    if(!$_SESSION['type']){
        if($_REQUEST['type']){
            $_SESSION['type'] = $_REQUEST['type'];
        }
    }
    
    if((isset($_SESSION['type']) && $_SESSION['type']=='ma')){
        Rimo::$_config->MASTER_TPL = 'page/all/view/page.ma.index.tpl';
       
    }
    
    $footer = 3;
    
    if(isset($_SESSION['type']) && $_SESSION['type'] == 'ma'){
        $footer = 60;
    }
    
    $footerMenu=$menu->loadTree($footer, UserLoginOut_Site_Controller::$_rights['jogcsoport_where']);
    Rimo::$_site_frame->assign('footerMenu',$footerMenu);
    
    //Nem akartam minden modellbe berakni a vizsgálatot, ezért van ez itt
    //Itt vannak felsorolva, hogy milyen modulok érhetők el login nélkül
    //Azt is lehet, h. a modul csak az egyik controllejét engedélyezzük pl 'ceg'=>'edit', ha összeset, akkor 'tartalom'=>''
    //Ha nincs benne a tömbben a betölteni kivánt modul, akkor a session type alapján a reg. oldalra dob (cég vagy álláskereső)
    
    $allowedModuls = array('tartalom'=>'',
                      'hir'=>'',
                      'user'=>'',
                      'ceg'=>'edit',
                      'kompetenciarajzkereso'=>'',
                      'szolgaltatas'=>'',
                      'allashirdetes'=>'',
                      'munkakor'=>'',
                      'tevekenysegikor'=>'list',
                      'kompetencia'=>'show'
                       );
    
    if($_REQUEST['m']) {
        if(!array_key_exists($_REQUEST['m'], $allowedModuls)){
            if(!UserLoginOut_Site_Controller::$_id){
                if($_SESSION['type']=='mv'){
                    throw new Exception_RegRequiredMV;
                }
                if($_SESSION['type']=='ma'){
                    throw new Exception_RegRequiredMA;
                }
                    throw new Exception_RegRequiredMV;
            }
        }else{
            if($allowedModuls[$_REQUEST['m']] !== '' && $allowedModuls[$_REQUEST['m']] != $_REQUEST['al']){
                if(!UserLoginOut_Site_Controller::$_id){
                    if($_SESSION['type']=='mv'){
                        throw new Exception_RegRequiredMV;
                    }
                    if($_SESSION['type']=='ma'){
                        throw new Exception_RegRequiredMA;
                    }
                        throw new Exception_RegRequiredMV;
                }    
            }    
        }
        
        Rimo::__loadModul($_REQUEST['m']);
    }
	
	$banner = Rimo::__loadPublic("model","banner_ShowBox_List","banner");
	Rimo::$_site_frame->assign("bgBannerList", $banner->getBannerList(5,"RAND()",1));
	
    
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


/**
 * @todo Gergő - Kérlek, nézd meg, hogy így is megfelelően működik-e!
 */


if(!$_SESSION['type'] || $_REQUEST['type']=='cl'){
    
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
// Strict standars error.
//Rimo::$_site_frame->assignByRef('lang', $translate->translate(9999));

//if(isset( Rimo::$_config->logoIndacators[$_REQUEST['m']] )){
  //  $logoIndicator = Rimo::$_config->logoIndacators[$_REQUEST['m']][$_REQUEST['al']];
    
    $value = (int)Rimo::$_config->logoIndacators[$_REQUEST['m']][$_REQUEST['al']] > 0 ? (int)Rimo::$_config->logoIndacators[$_REQUEST['m']][$_REQUEST['al']] : 0;
    Rimo::$_site_frame->assign('logoIndicator', $value);
    Rimo::$_site_frame->assign('logoIndicatorText', Rimo::$_config->indicatorText[$value]);
//}


Rimo::$_site_frame->assign('lang', $translate->translate(9999));
Rimo::$_site_frame->assign('FBLike',Rimo::$_config->FB_LIKEBOX);

Rimo::$_site_frame->display(Rimo::$_config->MASTER_TPL);
ob_flush();