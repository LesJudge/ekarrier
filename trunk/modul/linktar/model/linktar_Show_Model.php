<?php
class Linktar_Show_Model extends Model
{
    
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    
    public function getLinks()
    {
        try
        {
            $query="SELECT * FROM linktar WHERE linktar_aktiv=1 AND linktar_torolt=0";
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }
        catch(Exception_MYSQL_Null_Rows $e)
        {
            return false;
        }
    }
    
}