<?php
class Email_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "email";
    public $_bindArray = array("email_felado_nev" => "TxtFeladoNev", 
                               "email_felado_email" => "TxtFeladoEmail", 
                               "email_targy" => "TxtTargy",
                               "email_tartalom" => "TxtTartalom"
    );

    public function __addForm(){
        parent::__addForm();
        $this->addItem("TxtFeladoNev")->_verify["string"] = true;
        $email = $this->addItem("TxtFeladoEmail");
		$email->_verify["string"] = true;
        $email->_verify["email"] = true;
        $this->addItem("TxtTargy")->_verify["string"] = true;
        $this->addItem("TxtTartalom")->_verify["string"] = true;
    }
    
    public function __editData(){
        $query = "
            SELECT email_valtozok
            FROM {$this->_tableName}
            WHERE email_id='{$this->modifyID}' AND 
                  nyelv_id='{$this->nyelvID}'
            LIMIT 1
        ";
        $data = $this->_DB->prepare($query)->query_select()->query_fetch_array();
        $valtozok = explode(";",$data["email_valtozok"]);
        foreach($valtozok AS $valt){
        	$data["valtozok"][] = array("nev"=>$valt);
        }
        return $data;
    }
    
    public function __update(){
        parent::__update();    
    }
    
    public function __insert(){
        parent::__insert();
    }
}
?>