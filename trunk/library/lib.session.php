<?php

/**
 * Session
 * 
 * @package FrameWork
 * @subpackage Library
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class Session
{

    /**
     * @var int A session élettartama. 
     */
    protected $session_life_time;

    /**
     * Session mentési helyének és nevének beállítása, majd session indítása
     * 
     * @param mixed $session_name
     * @param mixed $session_save_path
     */
    final public function __construct($session_name, $session_save_path)
    {
        session_save_path($session_save_path);
        session_name($session_name);
        session_start();
    }

    /**
     * Session vizsgálat beállítása és futtatása a {@link Session::life()} függvény segítségével
     * 
     * @param string $session_life_time mp
     * 
     * @uses Session::life()
     */
    public function verify($session_life_time = "86400")
    {
        $this->session_life_time = $session_life_time;
        $this->life();
    }

    /**
     * Session lejáratának vizsgálata. 
     * Ha lejárt, akkor a $_SERVER['REQUEST_URI']- re dobjuk, ha nem, akkor az aktuális időre állítja az utolsó használatot.
     * 
     * @return void
     */
    private function life()
    {
        /*
        $time = time() - $_SESSION["last_used"];
        if ($time > $this->session_life_time AND $_SESSION["last_used"]) {
            session_destroy();
            unset($_SESSION);
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        } else {
            $_SESSION["last_used"] = time();
        }
        */
        /**
         * Módosítva: 2015-01-30
         */
        if (!array_key_exists('last_used', $_SESSION)) {
            $_SESSION['last_used'] = time();
        }
        $time = time() - $_SESSION["last_used"];
        if ($time > $this->session_life_time AND $_SESSION["last_used"]) {
            session_destroy();
            unset($_SESSION);
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        }
    }

}

class SessionDB extends Session
{

    public $db;

    private function life()
    {

        $time = time() - $_SESSION["last_used"];
        if ($time > $this->session_life_time AND $_SESSION["last_used"]) {
            $this->db->prepare("DELETE FROM session WHERE session_sid='" . session_id() . "' LIMIT 1")->query_execute();
            session_destroy();
            unset($_SESSION);
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
        } else {
            $_SESSION["last_used"] = time();
            try {
                $query = "
	        		UPDATE session 
					SET 
						session_last_used=" . $_SESSION["last_used"] . "
					WHERE session_id='" . session_id() . "' LIMIT 1
				";
                $this->db->prepare($query)->query_update();
            } catch (Exception_MYSQL_Null_Affected_Rows $e) {
                $query = "
	        		INSERT session 
					SET 
						session_last_used=" . $_SESSION["last_used"] . ",
						session_sid='" . session_id() . "'
				";
                $this->db->prepare($query)->query_update();
            }
        }
    }

}
