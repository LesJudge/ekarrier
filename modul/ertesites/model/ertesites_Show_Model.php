<?php

class ertesites_Show_Model extends Model
{
    
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
    }
    
    public static function model()
    {
        return new self;
    }
    
    public function getUnreadMessages(){
        $query = "SELECT COUNT(ugyfel_attr_uzenetek_id) AS cnt
                    FROM ugyfel_attr_uzenetek
                    WHERE ugyfel_attr_uzenetek_torolt = 0 AND uzenet_elolvasva = 0
                    ";
        
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getUnreadComments(){
        $query = "SELECT
                    (SELECT COUNT(kompetencia_hozzaszolas_id) FROM kompetencia_hozzaszolas WHERE kompetencia_hozzaszolas_torolt = 0 AND checked =0)
                  +
                    (SELECT COUNT(pozicio_hozzaszolas_id) FROM pozicio_hozzaszolas WHERE pozicio_hozzaszolas_torolt = 0 AND checked =0)
                  +
                    (SELECT COUNT(tevekenysegikor_hozzaszolas_id) FROM tevekenysegikor_hozzaszolas WHERE tevekenysegikor_hozzaszolas_torolt = 0 AND checked =0)
                  +
                    (SELECT COUNT(szektor_hozzaszolas_id) FROM szektor_hozzaszolas WHERE szektor_hozzaszolas_torolt = 0 AND checked =0)
                   AS cnt ";
        
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getUnreadLinks(){
        $query = "SELECT COUNT(ugyfel_attr_linkek_id) AS cnt
                    FROM ugyfel_attr_linkek
                    WHERE ugyfel_attr_linkek_torolt = 0 AND checked = 0
                    ";
        
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getUnreadOpinions(){
        $query = "SELECT COUNT(szakertovelemenye_id) AS cnt
                    FROM szakertovelemenye
                    WHERE szakertovelemenye_torolt = 0 AND megvalaszolva = 0
                    ";
        
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getUnreadForumTopics(){
        $query = "SELECT COUNT(forum_id) AS cnt
                    FROM forum
                    WHERE forum_torolt = 0 AND checked = 0
                    ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getUnreadForumComments(){
        $query = "SELECT COUNT(forum_hozzaszolas_id) AS cnt
                    FROM forum_hozzaszolas
                    WHERE forum_hozzaszolas_torolt = 0 AND checked = 0
                    ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    public function getUnreadComps(){
        $query = "SELECT COUNT(kompetencia_id) AS cnt
                    FROM kompetencia
                    WHERE kompetencia_torolt = 0 AND checked = 0 AND tipus = 'ugyfel'
                    ";
        return $this->_DB->prepare($query)->query_select()->query_result_array();
    }
    
    
}
