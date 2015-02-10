<?php
class Hirlevel_Probauser_Edit_Model extends Admin_Edit_Model {
    public $_tableName = "hirlevel_probauser";
    public $_bindArray = array("hirlevel_probauser_nev" => "TxtNev", 
                               "hirlevel_probauser_email" => "TxtEmail"
    );

    public function __addForm(){
        parent::__addForm();
        $this->addItem("TxtNev")->_verify["string"] = true;
        $email = $this->addItem("TxtEmail");
        $email->_verify["string"] = true;
        $email->_verify["email"] = true;
        $email->_verify["unique"] = array("table"=>"hirlevel_probauser","field"=>"hirlevel_probauser_email", "modify"=>$this->modifyID, "DB"=>$this->_DB);
    }
}
?>