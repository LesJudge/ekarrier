<?php
class Tartalom_List_Model extends Admin_List_Model {
    public $_tableName = "tartalom";
    public $_fields = "tartalom_id AS ID, tartalom_cim AS elso, kiemelt, tartalom_megtekintve, 
                       tartalom_aktiv AS Aktiv, tartalom_default
    ";
    public $tableHeader  = array(
            "tartalom_cim" => array("label" => "Cím", "width" => 80),
            "kiemelt" => array("label" =>"Kiemelt", "width" =>10),
            "tartalom_megtekintve" => array("label" => "Megtekintve", "width" => 10),
            "tartalom_aktiv" => array("label" => "Közzétéve", "width" => 8)
    );
  
  	public function __addForm(){
  		parent::__addForm();
  		$this->_params["TxtSort"]->_value = "tartalom_cim__ASC";
        
  	}
    
    public function updateMenuStatusz($id, $val){
        try{
            $query = "
                UPDATE menu 
                SET menu_aktiv=$val
                WHERE kapcsolodo_id='tart__{$id}' AND 
                      nyelv_id=".Rimo::$_config->ADMIN_NYELV_ID
            ;
            $this->_DB->prepare($query)->query_update();
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
        }
    }
    
    public function deleteRow($id){
        $query = "
            UPDATE `{$this->_tableName}` 
            SET {$this->_tableName}_torolt=1
            WHERE {$this->_tableName}_id=".mysql_real_escape_string($id)." AND 
                  {$this->_tableName}_default=0
        ";
        if ($this->nyelvID) $query .= " AND nyelv_id={$this->nyelvID}";
        $query .= " LIMIT 1 ";
        $this->_DB->prepare($query)->query_update();
    }
}
?>