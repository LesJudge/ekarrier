<?php
/**
 * MYSQL adtbáziskapcsolat kialakításáért felelős osztály.
 * 
 * @package FrameWork
 * @subpackage MYSQL
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class MYSQL_DB {
    /**
     * @var resource Adatbázis erőforrás.
     */
    public $dbResource;

    /**
     * Adatbázis kapcsolódás és karakterkódolás beállítása a {@link Rimo::$_config} alapján.
     */
    public function dbConnect() {
        $this->dbResource = mysql_connect(Rimo::$_config->MYSQL_DB_HOST, Rimo::$_config->MYSQL_DB_USER, Rimo::$_config->MYSQL_DB_PASS) or die('Adatbázis csatlakozási hiba!');
        mysql_query("SET NAMES " . Rimo::$_config->MYSQL_DB_CHARSET, $this->dbResource);
    }

    /**
     * Adatbázis kiválasztása a {@link Rimo::$_config} alapján.
     */
    public function dbSelectDb() {
        mysql_select_db(Rimo::$_config->MYSQL_DB_NAME, $this->dbResource) or die('Sikertelen adatbázis kiválasztás!');
    }

    /**
     * Lekérdezés előkészítő. Ha szükséges, akkor adatbáziskapcsolat kialakítása és adatbázis kiválasztása.  
     * 
     * @param string $query
     * @return MYSQL_Query
     */
    public function prepare($query) {
        if (!is_resource($this->dbResource)) {
            $this->dbConnect();
            $this->dbSelectDb();
        }
        return new MYSQL_Query($this->dbResource, $query);
    }

    /**
     * Adatbáziskapcsolat bezárása. A destruktor automatikusan meghívja.
     * 
     */
    public function db_close() {
        if(is_resource($this->dbResource)){
            mysql_close($this->dbResource);
            unset($this->dbResource);
        }
    }

    /**
     * Adatbáziskapcsolat automatikus bezárása.
     * @uses MYSQL_DB::db_close()
     */
    public function __destruct() {
        $this->db_close();
    }
}