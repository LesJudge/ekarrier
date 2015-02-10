<?php
define('ALLASHIRDETES_CONFIG_PATH', 'modul/' . basename(__DIR__) . '/config');
return array_merge(
    require ALLASHIRDETES_CONFIG_PATH . '/admin.config.php',
    require ALLASHIRDETES_CONFIG_PATH . '/commonConfig.php'
);