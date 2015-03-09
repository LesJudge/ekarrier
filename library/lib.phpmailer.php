<?php
/**
 * RimoMailer
 * 
 * @package FrameWork
 * @subpackage Library
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class RimoMailer extends PHPMailer {
    public function __construct($exceptions = false){
        parent::__construct($exceptions);
        $this->CharSet = Rimo::$_config->MAIL_CHARSET;
        if(Rimo::$_config->MAIL_SMTP)
        {
            $this->IsSMTP();
            $this->Host = Rimo::$_config->MAIL_HOST;
            $this->Port = Rimo::$_config->MAIL_PORT;
            $this->SMTPAuth = Rimo::$_config->MAIL_SMTP_AUTH;
            $this->Username = Rimo::$_config->MAIL_USER;
            $this->Password = Rimo::$_config->MAIL_PASS;
            //$this->SMTPDebug = 1;
            $this->Helo="Hello";
            //$this->SMTPSecure ="tls";
            //$this->ContentType =" multipart/mixed";
            //$this->SMTPSecure ="ssl";
        }
    }
}