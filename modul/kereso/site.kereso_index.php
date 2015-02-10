<?php
include_once "modul/kereso/config/site.config.php";
Rimo::__addConfig()->set($config);
Rimo::__loadController($_REQUEST["al"]);
?>