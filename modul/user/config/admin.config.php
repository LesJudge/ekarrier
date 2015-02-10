<?php
$config["APP_PATH"] = "user";
$config["APP_LINK"] = array(
    "" => "user",
    "edit" => "user",
    "jogcsoport" => "user/jogcsoport",
    "jogcsoportedit" => "user/jogcsoport",
    'ugyfel' => 'user/ugyfel',
    'ugyfeledit' => 'user/ugyfel',
    'ugyfelesetnaplo' => 'user/ugyfelesetnaplo',
    'ugyfeldokumentum' => 'user/ugyfeldokumentum'
);
$config["SALT"] = md5("http://localhost/rimo86zugzu/a9(D]p'5j%;k");
$config["NemSelectValues"][1] = array(
    0 => "Nő",
    1 => "Férfi"
);
$config['ugyfelFlashKey'] = 'userUgyfel';
