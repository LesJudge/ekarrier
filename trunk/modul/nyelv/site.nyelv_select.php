<?php
include_once "modul/nyelv/config/". Rimo::$_config->PAGE_NAME.".select_config.php";
Rimo::__addConfig()->set($config);
Rimo::__loadController("select");
?>