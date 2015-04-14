<?php
include_once "modul/user/config/admin.login_config.php";
include_once "lang/login.".Rimo::$_config->ADMIN_NYELV_VAR.".php";
Rimo::__addConfig()->set($config);
Rimo::__loadController("loginOut");
?>