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
   
    /*final public function __construct($session_name, $session_save_path)
    {
        session_save_path($session_save_path);
        session_name($session_name);
        session_start();
    }
    */
    
    
    /**
     * Path to save the sessions to
     * @var string
     */
    private $savePathRoot = '/tmp';

    /**
     * Save path of the saved path
     * @var string
     */
    private $savePath = '';

    /**
     * Salt for hashing the session data
     * @var string
     */
    private $key = '282edfcf5073666f3a7ceaa5e748cf8128bd53359b6d8269ba2450404face0ac';

    /**
     * Init the object, set up the session config handling
     *
     * @return null
     */
    public function __construct($session_name, $session_save_path)
    {
        session_set_save_handler(
            array($this, "open"), array($this, "close"),  array($this, "read"),
            array($this, "write"),array($this, "destroy"),array($this, "gc")
        );
        
        if(!is_dir($this->savePathRoot)){ 
               mkdir($this->savePathRoot,0755,true);
          }
register_shutdown_function('session_write_close');
$this->Gc((int)ini_get('session.gc_maxlifetime'));

        $this->savePathRoot = $session_save_path;
         session_start();
    }

    /**
     * Encrypt the given data
     *
     * @param mixed $data Session data to encrypt
     * @return mixed $data Encrypted data
     */
    private function encrypt($data)
    {
        $ivSize  = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv      = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $keySize = mcrypt_get_key_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $key     = substr(sha1($this->key), 0, $keySize);

        // add in our IV and base64 encode the data
        $data    = base64_encode(
            $iv.mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_CBC, $iv
            )
        );
        return $data;
    }

    /**
     * Decrypt the given session data
     *
     * @param mixed $data Data to decrypt
     * @return $data Decrypted data
     */
    private function decrypt($data)
    {
        $data    = base64_decode($data, true);

        $ivSize  = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $keySize = mcrypt_get_key_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $key     = substr(sha1($this->key), 0, $keySize);

        $iv   = substr($data, 0, $ivSize);
        $data = substr($data, $ivSize);

        $data = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_CBC, $iv
        );

        return $data;
    }

    /**
     * Set the key for the session encryption to use (default is set)
     *
     * @param string $key Key string
     * @return null
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Write to the session
     *
     * @param integer $id   Session ID
     * @param mixed   $data Data to write to the log
     * @return null
     */
    public function write($id, $data)
    {
        $path = $this->savePathRoot.'/'.$id;
        $data = $this->encrypt($data);

        file_put_contents($path, $data);
    }

    /**
     * Read in the session
     *
     * @param string $id Session ID
     * @return null
     */
    public function read($id)
    {
        $path = $this->savePathRoot.'/'.$id;
        $data = null;

        if (is_file($path)) {
            // get the data and extract the IV
            $data = file_get_contents($path);
            $data = $this->decrypt($data);
        }
        return $data;
    }

    /**
     * Open the session
     *
     * @param string $savePath  Path to save the session file locally
     * @param string $sessionId Session ID
     * @return null
     */
    public function open($savePath, $sessionId)
    {
        // open session, do nothing by default
    }

    /**
     * Close the session
     *
     * @return boolean Default return (true)
     */
    public function close()
    {
        return true;
    }

    /**
     * Perform garbage collection on the session
     *
     * @param int $maxlifetime Lifetime in seconds
     * @return null
     */
    public function gc($maxlifetime)
    {
        $path = $this->savePathRoot.'/*';

        foreach (glob($path) as $file) {
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                unlink($file);
            }
        }

        return true;
    }

    /**
     * Destroy the session
     *
     * @param string $id Session ID
     * @return null
     */
    public function destroy($id)
    {
        $path = $this->savePathRoot.'/'.$id;
        if (is_file($path)) {
            unlink($path);
        }
        return true;
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
