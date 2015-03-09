<?php
/**
 * Adminban elem szerkesztése, új felvitele
 * 
 * @package Admin
 * @subpackage Controller
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */  
abstract class Admin_Edit extends Page_Edit {
    /**
     * @var Event Új felvitel|módosítás gomb
     */
    protected $BtnSave;

    /**
     * Adatbázisból adatok betöltése a vBindArray a modifyID és a nyelvID segítségével.
     * 
     * Nyelvesített elem esetén lekérdezzük adatbázisból, hogy a módosítani kívánt elemnek van-e már más nyelvű 
     * megfelelője. Ha módosítani kívánt elem nincs az adott nyelven, akkor az új elem felvitele esetén lefuttatott
     * onLoad_New() függvényt futtatjuk.
     * 
     * @uses Page_Edit_Model::__formValues()
     * @uses Page_Edit_Model::onLoad_New()
     * @uses Page_Edit_Model::verifyRow()
     * @uses RimoController::__addScript()
     * 
     * @throw Exception_Form_Error
     * @catch Exception_Mysql_Null_Rows Exception_Form_Error kivételével szól, hogy az adott elem nem létezik, 
     *             és visszairányítja az oldalt a lista oldalra.
     */
    protected function onLoad_Edit_DefaultData() {
         try{
            $this->_model->verifyRow();
             try {
                $this->_model->__formValues();          
             }
             catch (Exception_Mysql_Null_Rows $e) {
                $this->_model->__setNyelvID(Rimo::$_config->ADMIN_NYELV_ID);
                $this->_model->__formValues();  
                $this->_model->__setNyelvID($_REQUEST["nyelv"]);        
                $this->_view->assign("FormInfo",LANG_AdminEdit_msg_load_lang);
            }
        }
        catch (Exception_Mysql_Null_Rows $e) {
            $this->__addScript("setTimeout('window.location.href=\"".Rimo::$_config->DOMAIN_ADMIN.$_REQUEST["m"]."/"."\"', 5000);");
            throw new Exception_Form_Error(LANG_PageEdit_error_modositas);
        }
        catch(Exception_MYSQL $e){
            throw new Exception_Form_Error($e->getMessage());
        }        
    }

    /**
     * Az adott rekord módosítása. Ha nyelvesítésről van szó, és az adott 
     * nyelven még nem létezik az elem, akkor új sor beszúrása történik. 
     * 
     * @uses Page_Edit_Model::verifyRow()
     * @uses Page_Edit::onClick_Modify()
     * @uses Page_Edit::onClick_New()
     * 
     * @throw Exception_Form_Message sikeres módosítás
     * @catch Exception_MYSQL_Null_Affected_Rows amely nem csinál semmit.
     */
    public function onClick_Modify() {
        try{
            $this->_model->verifyRow($this->_model->nyelvID);
            parent::onClick_Modify();
        }
        catch (Exception_Mysql_Null_Rows $e) { 
           $this->onClick_New(); 
        }
    }
    
    public function __show(){
        parent::__show();
        if($this->_model->nyelvID){
            $model = $this->__loadPublicModel("nyelv","_Admin_Select");
            $this->_view->assign("NyelvSelect",$model->getNyelvek(true));
        }
    }
}