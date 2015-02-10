<?php
$config=require 'modul/kompetencia/config/admin.config.php';
Rimo::__addConfig()->set($config);
UserLoginOut_Controller::verifyControllerAccess($_REQUEST['al']);
Rimo::__loadController($_REQUEST['al']);