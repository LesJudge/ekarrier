<?php
include_once "library/lib.phpmailer.php";
include_once "library/lib.mysql_db.php";
class RimoMailerFromDB extends RimoMailer {
	private $database;
	private $emailData;
	private $emailID;
	private $emailCimzett;
	private $nyelvID;
	public $BodyTPL;
	
	public function __construct($db, $nyelv_id="site_nyelv_id", $exceptions=true){
		$this->database = $db;
		$this->BodyTPL = new Smarty();
		if($nyelv_id==="site_nyelv_id")
			$this->nyelvID = Rimo::$_config->SITE_NYELV_ID;
		else
			$this->nyelvID = $nyelv_id;
		parent::__construct($exceptions);
	}
	
	private function loadEmail(){
		try{
        	$query = "
        		SELECT email_felado_nev, 
					   email_felado_email, 
					   email_targy, 
					   email_tartalom 
			    FROM email 
				WHERE email_id={$this->emailID} AND 
					  nyelv_id=".$this->nyelvID." 
		  	    LIMIT 1
			";
        	$this->emailData = $this->database->prepare($query)->query_select()->query_fetch_array();
		}
		catch(Exception_MYSQL $e){
			throw new phpmailerException("Nem található az e-mail sablon!");
		}
	}
	
	public function emailFromDB($email_id){
		$this->emailID = $email_id;
		$this->loadEmail();
		$this->emailData["email_tartalom"] = str_replace("modul/file_browser/upload/",Rimo::$_config->DOMAIN."modul/file_browser/upload/",$this->emailData["email_tartalom"]);
		//$this->Sender = $this->emailData["email_felado_email"];
        $this->SetFrom($this->emailData["email_felado_email"], $this->emailData["email_felado_nev"]);
        $this->Subject = $this->emailData["email_targy"];
	}
	
	/**
   * Adds a "To" address. Csak 1-et adj hozzá, hogy tudjon logolni.
   * @param string $address
   * @param string $name
   * @return boolean true on success, false if address already used
   */
	public function AddAddress($address, $name = '') {
    	if(parent::AddAddress($address,$name)){
    		$this->emailCimzett = $address;
    	}
  	}
	
	public function Send($basedir=""){
		$body = $this->BodyTPL->fetch('string:'.$this->emailData["email_tartalom"]);
        
		//$this->MsgHTML($body, $basedir); BUGOS A csatolt doksinál freemail esetében
		
        $this->IsHTML(true);
        $this->Body = $body;
        //$this->ContentType = 'multipart/alternative';
		try	{
			parent::Send();
			$this->log("",$body);
		}catch (phpmailerException $e) {
        	$this->log($e->getMessage(),$body);
        	throw $e;
        }
	}
	
	private function log($error="", $body=""){
		$query = "
			INSERT INTO email_log 
			SET 
				email_id={$this->emailID}, 
				email_log_cimzett='{$this->emailCimzett}',
				email_log_tartalom='".mysql_real_escape_string($body)."',
				email_log_kuldes_datum=now(),
				email_log_error='{$error}'
		";
		$this->database->prepare($query)->query_insert();
	}
}
?>