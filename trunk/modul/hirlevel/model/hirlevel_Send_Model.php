<?php
class Hirlevel_Send_Model extends Model {
    private $proba = false;
    
    public function __construct(){
        $this->addDB("MYSQL_DB");
    }
    
    public function loadKikuldendo($limit, $proba){
        if($proba){
            $where = " hirlevel_proba=1 ";
        }
        else{
            $where = " hirlevel_kikuldendo_send_date<=now() ";
        }
        $query = "
            SELECT hirlevel_kikuldendo_id, 
                   hirlevel_id, 
                   hirlevel_targy, 
                   hirlevel_felado_nev, 
                   hirlevel_felado_email, 
                   hirlevel_proba, 
                   hirlevel_user_id, 
                   hirlevel_user_email,
                   hirlevel_kikuldendo_tartalom, 
                   hirlevel_kikuldendo_probalkozas, 
                   hirlevel_kikuldendo_create_date, 
                   hirlevel_kikuldendo_send_date
            FROM hirlevel_kikuldendo
            WHERE {$where}
            LIMIT 0,{$limit}
        ";
        return $this->_DB->prepare($query)->query_select();
    }
    
    public function setKikuldve($level){
        $query = "
            DELETE FROM hirlevel_kikuldendo WHERE hirlevel_kikuldendo_id={$level["hirlevel_kikuldendo_id"]} LIMIT 1
        ";
        $this->_DB->prepare($query)->query_execute();
        $query = "
            INSERT INTO hirlevel_kikuldve
            SET 
                hirlevel_kikuldendo_id={$level["hirlevel_kikuldendo_id"]},
                hirlevel_id={$level["hirlevel_id"]},
                hirlevel_targy='{$level["hirlevel_targy"]}',
                hirlevel_felado_nev='{$level["hirlevel_felado_nev"]}',
                hirlevel_felado_email='{$level["hirlevel_felado_email"]}',
                hirlevel_proba={$level["hirlevel_proba"]},
                hirlevel_user_id={$level["hirlevel_user_id"]},
                hirlevel_user_email='{$level["hirlevel_user_email"]}',
                hirlevel_kikuldendo_create_date='{$level["hirlevel_kikuldendo_create_date"]}',
                hirlevel_kikuldve_send_date=now()
        ";
        $this->_DB->prepare($query)->query_insert();
    }
    
    public function updateKikuldendo($kikuldendo_id){
        $query = "
            UPDATE hirlevel_kikuldendo
            SET hirlevel_kikuldendo_probalkozas=hirlevel_kikuldendo_probalkozas+1,
                hirlevel_kikuldendo_send_date=now()
            WHERE hirlevel_kikuldendo_id={$kikuldendo_id}
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
    }
    
    public function setSikeres($hirlevel_id, $kikuldve){
        $query = "
            UPDATE hirlevel
            SET hirlevel_kikuldve=hirlevel_kikuldve+{$kikuldve}	 	
            WHERE hirlevel_id={$hirlevel_id}
            LIMIT 1
        ";
        $this->_DB->prepare($query)->query_update();
    }
    
    
}
?>