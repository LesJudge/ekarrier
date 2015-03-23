<?php
$config["PAGE_NAME"] = "site";
$config["SITE_TIPUS"] = "2";
$config["SESSION_DIR"] = "session/site";
$config["MASTER_TPL"] = "page/all/view/page.index.tpl";
$config["AktivSelectValues"] = array(
        1 => array(
            0 => 'Nem',
            1 => 'Igen'
        ),
        2 => array(
            0 => 'Nem',
            1 => 'Igen'
        )
    );
Rimo::__addConfig()->set($config);
/*
return array(
    'PAGE_NAME' => 'site',
    'SITE_TIPUS' => 2,
    'SESSION_DIR' => 'session/site',
    'MASTER_TPL' => 'page/all/view/page.index.tpl',
    'AktivSelectValues' => array(
        1 => array(
            0 => 'Nem',
            1 => 'Igen'
        ),
        2 => array(
            0 => 'Nem',
            1 => 'Igen'
        )
    )
);*/
?>