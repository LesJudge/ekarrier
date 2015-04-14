<?php
include_once "modul/user/config/site.login_config.php";
Rimo::__addConfig()->set($config);
Rimo::__loadController("loginOut");
?>