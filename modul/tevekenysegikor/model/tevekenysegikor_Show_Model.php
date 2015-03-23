<?php
/**
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
//class Munkakor_ShowMunkakor_Model extends Model
class Tevekenysegikor_Show_Model extends Page_Edit_Model
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
        $this->addItem('BtnAddTevekenysegikor');
        $this->addItem('BtnRemoveTevekenysegikor');
    }
    
    
    public function findTevkorByUrl($url, $lId)
    {
        $query = "SELECT mk.munkakor_kategoria_id AS ID,
                         mk.kategoria_full_link AS Link,
                         mk.kategoria_cim AS Cim,
                         mk.kategoria_leiras AS Leiras,
                         mk.kategoria_meta_kulcsszo AS kategoria_meta_kulcsszo
                 FROM munkakor_kategoria mk
                 WHERE mk.kategoria_full_link = '" . mysql_real_escape_string($url) . "' AND
                       mk.nyelv_id = " . (int) $lId . " AND
                       mk.munkakor_kategoria_aktiv = 1 AND
                       mk.munkakor_kategoria_torolt = 0
                 LIMIT 1";
        
        return $this->_DB->prepare($query)->query_select()->query_fetch_array();
    }
    
    public function findMunkakorokByID($id)
    {
        $query = "SELECT m.munkakor_id AS MkID,
                         m.munkakor_nev AS Nev,
                         m.munkakor_link AS Link
                 FROM munkakor m
                 INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = m.munkakor_id
                 WHERE mak.munkakor_attr_kategoria_id = ".(int)$id
                 ;
        
        return $this->_DB->prepare($query)->query_select()->query_result_array();
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
                          a.allashirdetes_id, a.megnevezes, a.link, a.ellenorzott/*, cm.cim_megye_nev*/, m.munkakor_nev AS munkakorNev
                      FROM
                          allashirdetes a
                      /*INNER JOIN cim_megye cm ON a.cim_megye_id = cm.cim_megye_id*/
                      INNER JOIN allashirdetes_attr_munkakor aam ON a.allashirdetes_id = aam.allashirdetes_id
                      INNER JOIN munkakor m ON m.munkakor_id = aam.munkakor_id
                      INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                      INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                      
                      WHERE
                          a.lejarati_datum > '" . date('Y-m-d') . "' AND 
                          mk.munkakor_kategoria_id = " . (int)$jobId . " AND 
                          a.allashirdetes_aktiv = 1 AND 
                          a.allashirdetes_torolt = 0
                      LIMIT " . $this->getOffersLimit();

            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function findMarkersByJobId($jobId)
    {
        
        //összesítve hozza azokat az ügyfeleket akik az adott tev.kört megjelölték vagy a tevkör alá besorolt munkakörhöz kapcsolodó álláshirdetéseket megjelölték
        try {
            $query = "SELECT 
                          ugyfel_id AS uID, kompetenciarajz_id AS krID
                      FROM
                          ugyfel_attr_tevkor
                      WHERE
                          tevkor_id = ".(int)$jobId."
                     UNION
                     
                     SELECT
                        uaam.ugyfel_id AS uID, uaam.kompetenciarajz_id AS krID
                     FROM ugyfel_attr_allashirdetes_megjelolt uaam
                     WHERE uaam.ugyfel_id IN
                     (
                        SELECT uaam2.ugyfel_id
                        FROM ugyfel_attr_allashirdetes_megjelolt uaam2
                        INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = uaam2.allashirdetes_id
                        INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                        INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                        WHERE mk.munkakor_kategoria_id = ".(int)$jobId."
                      
                        )
                      "
                      ;
            
           
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function findFeladatok($id)
    {
        try {
            $query = "SELECT 
                        aaf.feladat
                      FROM allashirdetes_attr_feladat aaf
                      INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = aaf.allashirdetes_id
                      INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                      INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                      WHERE mk.munkakor_kategoria_id = ".(int)$id."
                      GROUP BY aaf.feladat";
            
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function findElvarasok($id)
    {
        try {
            $query = "SELECT 
                        aae.elvaras
                      FROM allashirdetes_attr_elvaras aae
                      INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = aae.allashirdetes_id
                      INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                      INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                      WHERE mk.munkakor_kategoria_id = ".(int)$id."
                      GROUP BY aae.elvaras";
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function findKompetenciak($id)
    {
        try {
            $query = "SELECT 
                        k.kompetencia_nev AS nev
                      FROM allashirdetes_attr_kompetencia aak
                      INNER JOIN allashirdetes_attr_munkakor aam ON aam.allashirdetes_id = aak.allashirdetes_id
                      INNER JOIN munkakor_attr_kategoria mak ON mak.munkakor_id = aam.munkakor_id
                      INNER JOIN munkakor_kategoria mk ON mk.munkakor_kategoria_id = mak.munkakor_attr_kategoria_id
                      INNER JOIN kompetencia k ON k.kompetencia_id = aak.kompetencia_id
                      WHERE mk.munkakor_kategoria_id = ".(int)$id."
                      GROUP BY k.kompetencia_id";
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        } catch (Exception_MYSQL_Null_Rows $emnr) {
            return array();
        }
    }
    
    public function updateViewed($jobId, $lId)
    {
        $query = "UPDATE munkakor_kategoria SET kategoria_megtekintve = kategoria_megtekintve+1
                  WHERE munkakor_kategoria_id = " . (int)$jobId . " AND
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

    public function addTevekenysegikor($uID, $tvID, $krID){
        try{
            $query = "INSERT INTO ugyfel_attr_tevkor
                      SET ugyfel_id = ".(int)$uID.", tevkor_id = ".(int)$tvID.", kompetenciarajz_id = ".(int)$krID.", jeloles_date = NOW()
                      ON DUPLICATE KEY UPDATE
                      kompetenciarajz_id =".(int)$krID.", jeloles_date = NOW()"
                        ;
            return $this->_DB->prepare($query)->query_execute();
        }catch(Exception_MYSQL_Null_Rows $e){
        }
        catch(Exception_MYSQL $e){
        }
    }
    
     public function removeTevekenysegikor($uID, $tvID){
            $query = "DELETE FROM ugyfel_attr_tevkor
                      WHERE ugyfel_id = ".(int)$uID." AND tevkor_id = ".(int)$tvID;
        
            return $this->_DB->prepare($query)->query_execute();
    }
    
    public function checkIfMarkedByUgyfel($uID, $tvID)
    {
        try{

            $query = "SELECT kr.kompetenciarajz_nev AS nev
                        FROM ugyfel_attr_tevkor uat
                        INNER JOIN kompetenciarajz kr ON kr.kompetenciarajz_id = uat.kompetenciarajz_id
                        WHERE uat.ugyfel_id = ".(int)$uID." AND uat.tevkor_id = ".(int)$tvID."
                        LIMIT 1
                        ";
        
            return $this->_DB->prepare($query)->query_select()->query_fetch_array();    
        }catch(Exception_MYSQL_Null_Rows $e){
            return false;
        }
    }


    public function findKompetenciaRajzokByUgyfelID($id)
    {
        try{
            $query = "
                    SELECT kompetenciarajz_id AS ID, kompetenciarajz_nev AS nev
                    FROM kompetenciarajz
                    WHERE ugyfel_id = ".(int)$id    
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }    
    }
 
    public function validateMarking($uID, $tvID, $krID)
       {
           if(empty($uID) || (int)$uID < 1
              || empty($tvID) || (int)$tvID < 1)
           {
             return "Hiba történt!";  
           }else if (empty($krID) || (int)$krID < 1)
           {
             return "Válasszon kompetenciarajzot!";
           }else
           {
               return true;
           }
       }
    
    public function addComment($uID, $tvID, $comment, $type){
       
            $query = "INSERT INTO tevekenysegikor_hozzaszolas
                      SET ugyfel_id = ".(int)$uID.", tevekenysegikor_id = ".(int)$tvID.", hozzaszolas = '".mysql_real_escape_string($comment)."', type = '". mysql_real_escape_string($type)."', bekuldes_date = NOW(),
                          tevekenysegikor_hozzaszolas_aktiv = 0, tevekenysegikor_hozzaszolas_torolt = 0, checked = 0
                     ";
        
            return $this->_DB->prepare($query)->query_insert();
    }
    
    public function findCommentsByTevkorID($id,$type)
    {
        try{
            $query = "
                    SELECT th.hozzaszolas AS text,
                           th.bekuldes_date AS bekuldve,  
                            CONCAT(u.vezeteknev, ' ', u.keresztnev) AS nev
                    FROM tevekenysegikor_hozzaszolas th
                    INNER JOIN ugyfel u ON u.ugyfel_id = th.ugyfel_id
                    WHERE th.tevekenysegikor_id = ".(int)$id."
                          AND th.tevekenysegikor_hozzaszolas_aktiv = 1
                          AND th.tevekenysegikor_hozzaszolas_torolt = 0
                          AND u.ugyfel_aktiv = 1
                          AND u.ugyfel_torolt = 0
                          AND th.type = '". mysql_real_escape_string($type)."'
                            "
                    ;
            return $this->_DB->prepare($query)->query_select()->query_result_array();
        }catch(Exception_MYSQL_Null_Rows $e){
            return array();
        }    
    }
       
       
}