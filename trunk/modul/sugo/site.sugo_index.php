<?php
$config=require 'modul/sugo/config/site.config.php';
Rimo::__addConfig()->set($config);
Rimo::__loadController($_REQUEST['al']);