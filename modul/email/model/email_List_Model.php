<?php
class Email_List_Model extends Admin_List_Model {
    public $_tableName = "email";
    public $_fields = "email_id AS ID, email_targy AS elso, email_felado_nev, 
                       email_felado_email
    ";
    
    public function __addForm(){
        parent::__addForm();
        $this->tableHeader = array(
            "email_targy" => array("label" => "Tárgy", "width" => 60),
            "email_felado_nev" => array("label" => "Feladó neve", "width" => 20),
            "email_felado_email" => array("label" => "Feladó e-mail címe", "width" => 20)
        );
    }
}
?>