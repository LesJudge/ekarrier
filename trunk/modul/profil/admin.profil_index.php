<?php
$config=require 'modul/profil/config/admin.config.php';
Rimo::__addConfig()->set($config);
UserLoginOut_Controller::verifyControllerAccess($_REQUEST['al']);
Rimo::__loadController($_REQUEST['al']);