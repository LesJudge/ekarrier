<?php
$config=require 'modul/user_cim/config/site.config.php';
Rimo::__addConfig()->set($config);
Rimo::__loadController($_REQUEST['al']);