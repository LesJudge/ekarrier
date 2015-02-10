<?php
include_once "modul/menu/config/". Rimo::$_config->PAGE_NAME.".show_config.php";
Rimo::__addConfig()->set($config);
Rimo::__loadController("show");
?>