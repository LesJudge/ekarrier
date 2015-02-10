<?php
class En_Show_Model extends Model {
    public function __construct(){
        $this->addDB("MYSQL_DB");
        
    }
    
    public function getMunkakorokById($id){
        try{
          $query="SELECT munkakor_nev, munkakor_link
                  FROM munkakor
                  INNER JOIN ugyfel_attr_munkakor ON ugyfel_attr_munkakor.munkakor_id = munkakor.munkakor_id
                  WHERE ugyfel_attr_munkakor.ugyfel_id = " . mysql_real_escape_string($id) . " AND munkakor.munkakor_aktiv = 1 AND munkakor.munkakor_torolt = 0";
            
            return $this->_DB->prepare($query)->query_select()->query_result_array();
            
        }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
    }
    
    public function getMegjeloltekById($id){
        try{
          $query="SELECT allashirdetes.allashirdetes_id AS id, allashirdetes.megnevezes AS nev, allashirdetes.link AS link
                  FROM allashirdetes
                  INNER JOIN ugyfel_attr_allashirdetes_megjelolt ON ugyfel_attr_allashirdetes_megjelolt.allashirdetes_id = allashirdetes.allashirdetes_id
                  WHERE ugyfel_attr_allashirdetes_megjelolt.ugyfel_id = " . mysql_real_escape_string($id) . " AND allashirdetes.allashirdetes_aktiv = 1 AND allashirdetes.allashirdetes_torolt = 0";
            
            return $this->_DB->prepare($query)->query_select()->query_result_array();
            
        }catch(Exception_MYSQL_Null_Rows $e){
            
            }
            catch(Exception_MYSQL $e){
            
            }
    }
    
}
?>