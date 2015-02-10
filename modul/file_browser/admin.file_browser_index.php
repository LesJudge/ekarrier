<?php
include_once "modul/file_browser/config/". Rimo::$_config->PAGE_NAME.".config.php";
include_once "modul/file_browser/lang/".Rimo::$_config->ADMIN_NYELV_VAR.".php";
Rimo::__addConfig()->set($config);
UserLoginOut_Controller::verifyControllerAccess($_REQUEST["al"]);
Rimo::__loadController(); 
?>