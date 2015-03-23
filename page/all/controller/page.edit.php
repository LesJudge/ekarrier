<?php
/**
 * Elem szerkesztése, új felvitele
 * 
 * @package Global
 * @subpackage Controller
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */  
abstract class Page_Edit extends RimoController {
    /**
     * @var Event Új felvitel|módosítás gomb
     */
    protected $BtnSave;
    
    /**
     * @var string új felvitel|módosítás
     */
    private $edit_mode;
    
    /**
     * Beállítja az _action_type-ot REQUEST-re. A __construct-or eldönti, hogy módosítás vagy új elem felvitele történik. Ez a függvény állítja be a BtnSave futtatandó függvényét, és az edit_mode változó értékét.
     * 
     */
    public function __construct() {
        $this->_action_type = $_REQUEST;
        /**
         * Undefined index.
         * Módosítva: 2015-01-30
         */
        /*$id = function($index) {
            return array_key_exists($index, $_REQUEST) && is_int($_REQUEST[$index]) > 0 ? $_REQUEST[$index] : 0;
        };*/
        $this->_model->__setModifyID($_REQUEST["id"]);
        $this->_model->__setNyelvID($_REQUEST["nyelv"]);
        //$this->_model->__setModifyID($id('id'));
        //$this->_model->__setNyelvID($id('nyelv'));
        if ($this->_model->modifyID) {
            $this->BtnSave = $this->__addEvent("BtnSave", "Modify");
            $this->edit_mode = LANG_PageEdit_modositas;
        }
        else{
            $this->BtnSave = $this->__addEvent("BtnSave", "New");
            $this->edit_mode = LANG_PageEdit_uj_felvitel;
        }
        $this->_model->__addForm();
    }
    
    /**
     * Az események futtatása. 
     * Ha még egy gombot sem nyomtunk meg a formon, akkor az Itemek adatbázisból való feltöltése.
     * 
     * @uses RimoController::__runEvents()
     * @uses Page_Edit::onLoad_Edit_DefaultData()
     * @uses Page_Edit::onLoad_Edit()
     * @uses Page_Edit::onLoad_New()
     */
    public function __runEvents(){
        parent::__runEvents();
        if($this->_model->modifyID)
        {
            if($this->_runned_event===0){
                $this->onLoad_Edit_DefaultData();   
            }
            $this->onLoad_Edit();    
        }
        else{
            if($this->_runned_event===0){
                $this->onLoad_New();
            }
        }
    }

    /**
     * Minden módosítás esetén lefut.
     * 
     * @uses Page_Edit_Model::__editData()
     */
    protected function onLoad_Edit(){
        try{
            $info = $this->_model->__editData();
            foreach($info as $key=>$val){
                $this->_view->assign($key, $val);    
            }
        }
        catch (Exception_Mysql_Null_Rows $e) {
    	} 
    }
    
     /**
     * Minden új felvitel esetén lefut.
     * 
     * @uses Page_Edit_Model::__newData()
     */
    protected function onLoad_New(){
        $this->_model->__newData();
    }

    /**
     * Adatbázisból adatok betöltése a vBindArray a modifyID és a nyelvID segítségével.
     * 
     * @uses Page_Edit_Model::__formValues()
     * @uses RimoController::__addScript()
     * 
     * @throw Exception_Form_Error
     * @catch Exception_Mysql_Null_Rows Exception_Form_Error kivételével szól, hogy az adott elem nem létezik, 
     *             és visszairányítja az oldalt a lista oldalra.
     */
    protected function onLoad_Edit_DefaultData() {
         try {
            $this->_model->__formValues();          
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
     * Az adott rekord módosítása.
     * 
     * @uses RimoController::getItemValue()
     * @uses Admin_SQL::modifyRow()
     * 
     * @throw Exception_Form_Message sikeres módosítás
     * @catch Exception_MYSQL_Null_Affected_Rows amely nem csinál semmit.
     */
    public function onClick_Modify() {
        try{
            $this->_model->_DB->prepare("BEGIN")->query_execute();
            $this->onSave_Other($this->_model->modifyID);
            $this->_model->__update();
            $this->_model->_DB->prepare("COMMIT")->query_execute();
            throw new Exception_Form_Message(LANG_PageEdit_msg_modositas);
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
            $this->_model->_DB->prepare("COMMIT")->query_execute();
            throw new Exception_Form_Message(LANG_PageEdit_msg_modositas);
        }
        catch(Exception_MYSQL $e){
            $this->_model->_DB->prepare("ROLLBACK")->query_execute();
            throw new Exception_Form_Error($e->getMessage());
        }
    }
    
    /**
     * Új rekord felvitele  a vBindArray segítségével.
     * 
     * @uses RimoController::getItemValue()
     * @uses Admin_SQL::insertRow()
     * 
     * @throw Exception_Form_Message sikeres új elem felvitele és link az elem megtekintéséhez
     */
    public function onClick_New() {
        try{
            $this->_model->_DB->prepare("BEGIN")->query_execute();
            $this->_model->__insert();
            $this->onSave_Other($this->_model->insertID);
            $this->_model->_DB->prepare("COMMIT")->query_execute();
            if(!$this->_model->modifyID){
                $this->formReset();
                $this->onLoad_New();
            }
            else{
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel_lang);
            }
            if($this->_model->nyelvID){
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel."<a href='".Rimo::$_config->APP_LINK[$_REQUEST["al"]]."/edit/{$this->_model->insertID}?nyelv=".Rimo::$_config->ADMIN_NYELV_ID."'>".LANG_PageEdit_msg_uj_felvitel_link.">></a>");
            }
            else{
                throw new Exception_Form_Message(LANG_PageEdit_msg_uj_felvitel."<a href='".Rimo::$_config->APP_LINK[$_REQUEST["al"]]."/edit/{$this->_model->insertID}'>".LANG_PageEdit_msg_uj_felvitel_link.">></a>");    
            }
        }catch(Exception_MYSQL $e){
            $this->_model->_DB->prepare("ROLLBACK")->query_execute();
            throw new Exception_Form_Error($e->getMessage());
        }                    
    }
    
    public function onSave_Other($id){
    	
    }
    
    /**
     * Kihelyezi az oldal szükséges változóit, és az edit_mode-ot
     */
    public function __show(){
        $this->_view->assign("edit_mode", $this->edit_mode);
    }
}
?>