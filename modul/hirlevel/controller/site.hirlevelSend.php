<?php
include_once "library/lib.phpmailer.php";
class HirlevelSend_Site_Controller extends RimoController {
    public $_name = "HirlevelKuldes";
    private $proba = false;
    
    public function __construct($proba=false) {
        $this->proba = $proba;
        $this->__loadModel("_Send");
        $this->__run();
    }
    
    public function __show(){
        try{
            $mailer = new RimoMailer(true);
            $obj = $this->_model->loadKikuldendo(Rimo::$_config->HKuldo_MAX_ELEM, $this->proba);
            $start = strtotime('now');
            $sikeres = array();
            while($level = $obj->query_fetch_array()){
                try{
                    $mailer->ClearAddresses();
                    $mailer->ClearAttachments();
                    $mailer->Sender = $level["hirlevel_felado_email"];
                    $mailer->SetFrom($level["hirlevel_felado_email"], $level["hirlevel_felado_nev"]);
                    $mailer->Subject = $level["hirlevel_targy"];
                    
                    $mailer->IsHTML(true);
                    $mailer->Body = $level["hirlevel_kikuldendo_tartalom"];
                    $mailer->AddAddress($level["hirlevel_user_email"]);
                    $mailer->Send();
                    
                    try{
                        $this->_model->_DB->prepare("BEGIN")->query_execute();
                        $this->_model->setKikuldve($level);  
                        $sikeres[$level['hirlevel_id']] = $sikeres[$level['hirlevel_id']] + 1;  
                        $this->_model->_DB->prepare("COMMIT")->query_execute();
                    }catch(Exception_MYSQL $e){
                        $this->_model->_DB->prepare("ROLLBACK")->query_execute();
                        echo $e->getMessage()."<br>";
                    }
                }
                catch (phpmailerException $e) {
                    $this->_model->updateKikuldendo($level["hirlevel_kikuldendo_id"]);
                    echo $e->getMessage()."<br>";
                }
                if (strtotime('now') - $start >= Rimo::$_config->HKuldo_MAX_TIME){
                    break;
                }
            }
            foreach ($sikeres as $hirlevel_id => $kikuldve)
            {
                 $this->_model->setSikeres($hirlevel_id, $kikuldve);
            }
        } 
        catch(Exception $e){
            echo $e->getMessage()."<br>";
        }
        die();
    }
}
?>