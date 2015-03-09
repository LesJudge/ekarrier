<?php
// Könyvtár váltás Rimo módra.
chdir('../../../');
// Hibaüzenetek.
error_reporting(E_ALL ^ E_DEPRECATED);
// Vendor
require 'vendor/autoload.php';
// Rimo init.
Rimo::init();
Rimo::$pimple->register(new \Uniweb\Library\DependencyInjection\Smarty\SmartyProvider);
Rimo::initSiteFrame();
Rimo::getConfig()->set(array(
    'PAGE_NAME' => 'admin',
    'SITE_TIPUS' => 1,
    'APP_LINK' => array(
        'slim' => 'slim'
    )
));
$translate = Rimo::__loadPublic('model', 'nyelv_Translate', 'nyelv');
Rimo::$translate = $translate;
Rimo::__loadSiteElement('user', 'loginout');

$app = new Slim\Slim(array(
    'debug' => false,
    'cookies.secret_key' => '10s&l^p(f1g$l==3fa*93t1=7vf#i1##liftvo%0x#zx9okal%c710'
));

//var_dump(UserLoginOut_Controller::$_id);

// Cím kereső.
require 'controller/find.php';
// Run!
$app->run();