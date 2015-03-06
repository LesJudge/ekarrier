<?php

abstract class AttachableUserController extends Page_Edit
{
    /**
     * Felhasználó létrehozása.
     * @throws Exception_Form_Message
     * @throws Exception_Form_Error
     */
    public function onClick_New()
    {
        $this->verifyInputItem($this->_model->verifyPw());
        try {
            try {
                // Másolat a params tömbről. Erre azért van szükség, mert az Attach model overrideolhatja az értékeket!
                $params = $this->createEmailData($this->_model->_params);
                // Tranzakció indítása.
                $this->_model->_DB->prepare('BEGIN')->query_execute();
                // Felhasználó létrehozása.
                $this->_model->__insert();
                // Egyéb adatok mentése.
                $this->onSave_Other($this->_model->insertID);
                // Megerősítő link készítése.
                $params['megerosito_link'] = Rimo::$_config->DOMAIN . 'megerosites/' . md5($this->_model->insertID);
                // Regisztrációs e-mail küldése.
                $this->sendRegistrationEmail($params);
                // Tranzakció COMMIT.
                $this->_model->_DB->prepare('COMMIT')->query_execute();
                if (!$this->_model->modifyID) {
                    $this->formReset();
                    $this->onLoad_New();
                }
                else {
                    //throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel_lang);
                    throw new Exception_Form_Message();
                }
                if ($this->_model->nyelvID) {
                    throw new Exception_Form_Message();
                }
                else {
                    throw new Exception_Form_Message();    
                }
            } catch (Exception_MYSQL $e) {
                $this->_model->_DB->prepare('ROLLBACK')->query_execute();
                throw new Exception_Form_Error($this->getInsertFailMessage());
                //throw new Exception_Form_Error($e->getMessage());
            } catch (phpmailerException $pme) {
                $this->_model->_DB->prepare('ROLLBACK')->query_execute();
                throw new Exception_Form_Error($this->getUpdateSuccessMessage());
            }
        } catch(Exception_Form_Message $e) {
            $this->formReset(true);
            $this->onLoad_New();
            header('Location: '.Rimo::$_config->DOMAIN.'koszonjuk-regisztraciodat');
            throw new Exception_Form_Message($this->getInsertSuccessMessage());
        }
    }
    /**
     * Felhasználó adatok módosítása.
     * @throws Exception_Form_Message
     * @throws Exception_Form_Error
     */
    public function onClick_Modify()
    {
        if($this->getItemValue('Password')) {
            $this->verifyInputItem($this->_model->verifyPw());
        }
        try {
            try{
                $this->_model->_DB->prepare('BEGIN')->query_execute();
                $this->onSave_Other($this->_model->modifyID);
                $this->_model->__update();
                $this->_model->_DB->prepare('COMMIT')->query_execute();
                throw new Exception_Form_Message($this->getUpdateSuccessMessage());
            } catch (Exception_MYSQL_Null_Affected_Rows $e) {
                $this->_model->_DB->prepare('COMMIT')->query_execute();
                throw new Exception_Form_Message($this->getUpdateFailMessage());
            } catch (Exception_MYSQL $e) {
                $this->_model->_DB->prepare('ROLLBACK')->query_execute();
                throw new Exception_Form_Error($this->getUpdateFailMessage());
            }
        } catch(Exception_Form_Message $e) {
            throw new Exception_Form_Message($e->getMessage());
        }
    }

    protected function sendRegistrationEmail(array $data)
    {
        $mailer = new RimoMailerFromDB($this->_model->_DB);
        $mailer->emailFromDB($this->getEmailid());
        foreach ($data as $k => $v) {
            $mailer->BodyTPL->assign($k, $v);
        }
        $mailer->AddAddress($this->getEmailAddress());
        $mailer->Send();
    }
    
    abstract public function getEmailAddress();
    
    abstract public function createEmailData(array $params);
    
    abstract public function getEmailid();
    
    abstract public function getInsertSuccessMessage();
    
    abstract public function getInsertFailMessage();
    
    abstract public function getUpdateSuccessMessage();
    
    abstract public function getUpdateFailMessage();
}