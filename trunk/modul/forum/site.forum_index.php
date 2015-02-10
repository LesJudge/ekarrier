<?php
include_once "modul/forum/config/". Rimo::$_config->PAGE_NAME.".config.php";
Rimo::__addConfig()->set($config);
Rimo::__loadController($_REQUEST["al"]);
?>