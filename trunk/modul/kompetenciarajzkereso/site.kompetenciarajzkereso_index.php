<?php
$config = require 'modul/' . basename(__DIR__) . '/config/site.config.php';
Rimo::__addConfig()->set($config);
Rimo::__loadController($_REQUEST['al']);