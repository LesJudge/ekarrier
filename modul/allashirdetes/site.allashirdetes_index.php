<?php
$config = require 'modul' . DIRECTORY_SEPARATOR . 'allashirdetes' . DIRECTORY_SEPARATOR . 'moduleStartup.php';
Rimo::__addConfig()->set($config);
Rimo::__loadController($_REQUEST['al']);