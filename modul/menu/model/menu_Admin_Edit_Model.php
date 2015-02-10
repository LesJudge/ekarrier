<?php
include_once "modul/kategoria/model/kategoria_Master_Edit_Model.php";
class Menu_Admin_Edit_Model extends Kategoria_Master_Edit_Model {    
     private $functionIDSets;
     public function __addForm() {
        $this->addItem("ChkAktiv")->_select_value = Rimo::$_config->AktivSelectValues[Rimo::$_config->ADMIN_NYELV_ID];
        $this->addItem("TxtCim")->_verify["string"] = true;
        $link = $this->addItem("TxtLink");       
        $parent = $this->addItem("SelParent");
        $parent->_select_value = $this->getParentSelectValues(true,"","menu_nev");
        
        $this->addItem("KategoriaLeft");
        $this->addItem("KategoriaRight");
        $this->addItem("KategoriaLevel");
        $this->_bindArray = array(
                                "menu_nev" => "TxtCim", 
                                "menu_link" => "TxtLink",
                                "admin_menu_aktiv" => "ChkAktiv",  
                                "baloldal" => "KategoriaLeft", 
                                "jobboldal" => "KategoriaRight",
                                "szint" => "KategoriaLevel"
        );
    }
    
    public function __newData() {
        parent::__newData();
        $this->_params["SelParent"]->_select_value = $this->getParentSelectValues(true, "", "menu_nev");
    }
    
    public function __update(){   
        parent::__update($this->functionIDSets);
    }
    
    public function __insert(){
        if($this->modifyID){
            parent::__insert($this->functionIDSets);
        }
        else{
            if($this->_params["SelParent"]->_value){
                $this->insertChildNode($this->_params["SelParent"]->_value,$this->functionIDSets);
            }
            else{
                $this->insertRootNode($this->functionIDSets);
            }
        }  
    }
    
    public function verifyModulFunction($link){
        try{
            if($link){
                $data = explode("/",$link);
                $modul_azon = $data[0];
                $modul_function_azon = $data[1];
                $query = "
                    SELECT modul_function_id 
                    FROM modul_function 
                    WHERE modul_azon='{$modul_azon}' AND 
                          modul_function_azon='{$modul_function_azon}' AND 
                   	      site_tipus_id=1
                ";
                $this->functionIDSets = ",modul_function_id=".$this->_DB->prepare($query)->query_select()->query_fetch_array("modul_function_id");
            }
        }catch(Exception_MYSQL_Null_Rows $e){
            throw new Exception_Form_Error("A megadott linkhez nincs rendelve modul funkció!");
        } 
    }
}
?>