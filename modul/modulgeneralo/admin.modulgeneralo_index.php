<?php
require_once 'modul/modulgeneralo/config/'. Rimo::$_config->PAGE_NAME.'.config.php';
Rimo::__addConfig()->set($config);
UserLoginOut_Controller::verifyControllerAccess($_REQUEST['al']);
Rimo::__loadController($_REQUEST['al']);
?>