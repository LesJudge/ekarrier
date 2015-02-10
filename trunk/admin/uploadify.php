<?php
chdir('..');
include_once "Rimo.php";
include_once "admin/admin.config.php";
include_once "library/lib.static.php";
Rimo::__addConfig();
include_once "modul/file_browser/config/". Rimo::$_config->PAGE_NAME.".config.php";
Rimo::__addConfig()->set($config);
if (!empty($_FILES)) {
    try{
        $folder = str_replace(Rimo::$_config->UPLOADIFY_FILE_PATH,"",$_REQUEST['folder']);
        print Create::upload_file($_FILES['Filedata'], false, $folder);    
    }
    catch(Exception_Form_Error $e){
        echo $e->getMessage();
    }
    
    
    /*$file_name_array = explode('.', strrev($_FILES['Filedata']['name']), 2);
    $file_extension = strrev($file_name_array[0]);
    $file_value['name'] = Create::remove_accents(strrev($file_name_array[1])) . '.' . $file_extension;
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
    $targetFile = str_replace('', '/', $targetPath) . $file_value['name'];
    if (move_uploaded_file($_FILES['Filedata']["tmp_name"], $targetFile) !== false) {
        chmod($targetFile, 0777);
        echo $file_value['name'];
    }
    else  
    {
        echo 'Hiba a következő fájlnál: '.$file_value['name'];
    }*/
}
?>