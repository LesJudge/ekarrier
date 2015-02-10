<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
//class Munkakor_ShowMunkakor_Model extends Model
class Munkakor_ShowMunkakor_Model extends Page_Edit_Model
{
    /**
     * Maximálisan hány álláshirdetés jelenhet meg.
     * @var int
     */
    public $offersLimit = 5;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->addDB('MYSQL_DB');
        $this->__addForm();
    }
    
    public function __addForm() {
        parent::__addForm();
        $this->addItem('BtnAddMunkakor');
    }
    /**
     * URL alapján lekérdezi a munkakört.
     * @param string $url A munkakör URL-je.
     * @param int $lId Nyelvi azonosító
     * @return array
     * @throws Exception_MYSQL_Null_Rows
     */
    
    
    
    public function findJobByUrl($url, $lId)
    {
        $query = "SELECT m.munkakor_id,
                         m.munkakor_nev,
                         m.munkakor_link,
                         m.munkakor_leiras,
                         m.munkakor_meta_kulcsszo,
                         m.munkakor_tartalom,
                         m.munkakor_elvarasok
                 FROM munkakor m
                 WHERE m.munkakor_link = '" . mysql_real_escape_string($url) . "' AND
                       m.nyelv_id = " . (int) $lId . " AND
                       m.munkakor_aktiv = 1 AND
                       m.munkakor_torolt = 0
                 LIMIT 1";
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    /**
     * Munkakör azonosító alapján lekérdezi az álláshirdetéseket.
     * @param int $jobId => Munkakör azonosító
     * @return array
     */
    public function findOffersByJobId($jobId)
    {
        try {
            $query = "SELECT 
                          a.allashirdetes_id, a.megnevezes, a.link, a.ellenorzott/*, cm.cim_megye_nev*/
                      FROM
                          allashirdetes a
                      /*INNER JOIN cim_megye cm ON a.cim_megye_id = cm.cim_megye_id*/
                      INNER JOIN allashirdetes_attr_munkakor ahmm ON a.allashirdetes_id = ahmm.allashirdetes_id
                      WHERE
                          a.lejarati_datum > '" . date('Y-m-d') . "' AND 
                          ahmm.munkakor_id = " . (int)$jobId . " AND 
                          a.allashirdetes_aktiv = 1 AND 
                          a.allashirdetes_torolt = 0
                      LIMIT " . $this->getOffersLimit();
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function findFeladatok($jobId)
    {
        try {
            $query = "SELECT 
                          feladat
                      FROM
                          allashirdetes_attr_munkakor aam
                              INNER JOIN
                          allashirdetes_attr_feladat aaf ON aam.allashirdetes_id = aaf.allashirdetes_id
                      WHERE
                          aam.munkakor_id = " . (int)$jobId;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function findElvarasok($jobId)
    {
        try {
            $query = "SELECT 
                          elvaras
                      FROM
                          allashirdetes_attr_munkakor aam
                              INNER JOIN
                          allashirdetes_attr_elvaras aae ON aam.allashirdetes_id = aae.allashirdetes_id
                      WHERE
                          aam.munkakor_id = " . (int)$jobId;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    /**
     * Növeli eggyel a munkakör megtekintések számát.
     * @param int $jobId
     * @param int $lId
     * @return int
     * @throws Exception_MYSQL_Null_Affected_Rows
     */
    public function updateViewed($jobId, $lId)
    {
        $query = "UPDATE munkakor SET munkakor_megtekintve = munkakor_megtekintve+1
                  WHERE munkakor_id = " . (int)$jobId . " AND
                        nyelv_id = " . (int)$lId . "
                  LIMIT 1";
        return $this->_DB->prepare($query)->query_update();
    }
    /**
     * Visszatér a maximálisan megjeleníthető álláshirdetések számával.
     * @return int
     */
    public function getOffersLimit()
    {
        return $this->offersLimit;
    }

    public function addMunkakor($ugyfelID, $MkID){
        try{
        $query = "INSERT INTO ugyfel_attr_munkakor
                  SET ugyfel_id = ".$ugyfelID.", munkakor_id = ".$MkID;
        
        return $this->_DB->prepare($query)->query_execute();
        }catch(Exception_MYSQL_Null_Rows $e){
            
        }
        catch(Exception_MYSQL $e){
            
        }
    }
    
}