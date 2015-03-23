<?php
/*
return array(
    'SESSION_NAME' => 'admin',
    'PAGE_NAME' => 'admin',
    'SITE_TIPUS' => 1,
    'AktivSelectValues' => array(
        1 => array('Nem', 'Igen'),
        2 => array('Nem', 'Igen')
    ),
    'CMSAllapot' => array(
        1 => array('--Válasszon állapotot--', 'Megjelenik', 'Nem jelenik meg'),
        2 => array('--Válasszon állapotot--', 'Megjelenik', 'Nem jelenik meg')
    ),
    'HONAP' => array(
	1 => 'Január',
	2 => 'Február',
	3 => 'Március',
	4 => 'Április',
	5 => 'Május',
	6 => 'Június',
	7 => 'Július',
	8 => 'Augusztus',
	9 => 'Szeptember',
	10 => 'Október',
	11 => 'November',
	12 => 'December'
    )
);*/

$config["SESSION_NAME"] = "admin";
$config["PAGE_NAME"] = "admin";
$config["SITE_TIPUS"] = 1;
$config["AktivSelectValues"][1] = array(0=>"Nem", 1=>"Igen");
$config["AktivSelectValues"][2] = array(0=>"Nem", 1=>"Igen");
$config["CMSAllapot"][1] = array(0=>"--Válasszon állapotot--", 1=>"Megjelenik", 2=>"Nem jelenik meg");
$config["CMSAllapot"][2] = array(0=>"--Válasszon állapotot--", 1=>"Megjelenik", 2=>"Nem jelenik meg");
$config["HONAP"] = array(
	1=>"Január",
	2=>"Február",
	3=>"Március",
	4=>"Április",
	5=>"Május",
	6=>"Június",
	7=>"Július",
	8=>"Augusztus",
	9=>"Szeptember",
	10=>"Október",
	11=>"November",
	12=>"December"
);
Rimo::__addConfig()->set($config);
?>