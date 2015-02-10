<?php 
$config["APP_PATH"] = "menu";
$config["APP_LINK"] = array(""=>"menu", "edit"=>"menu",
                            "admin"=>"menu/admin", "adminedit"=>"menu/admin"
                            );
if(strpos($_REQUEST["al"],"admin")!==false){
    $config["KT_TABLE"] = "admin_menu";    
}
else{
    $config["KT_TABLE"] = "menu";
    $config["MENU_DinamikusSelect"] = array(
                                        "Fix oldalak" => array(
                                                            "fix__1"=>"Galéria lista",
                                                            "fix__2"=>"GYIK"
                                                        ) 
    );
    $config["MENU_DinamikusLink"] = array(
                                        1=>"galeria/",
                                        2=>"gyik/"
    ); 
}
?>