<?php
/**
 * Admin lista
 * 
 * @package Admin
 * @subpackage Controller
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */  
abstract class Admin_List extends Page_List {
    /**
     * @var Paging Lapozást kezelő osztály
     */
    protected $vPaging;
    protected $_multiple_lang = true;
    
    /**
     * Hozzáadja a lista oldalhoz a szükséges event elemeket és az alap Admin model elemeket.
     * 
     * @uses Page_List::__construct()
     */
    public function __construct() {
        parent::__construct(Rimo::$_config->ADMIN_NYELV_ID);            
        $this->__addEvent("BtnRendez", "Rendez");
        $this->__addEvent("BtnFilter", "Filter");
        $this->__addEvent("BtnFilterDEL", "DelFilter");
        $this->__addEvent("BtnPublish", "Publish");
        $this->__addEvent("BtnUnpublish", "Unpublish");
        $this->__addEvent("BtnMultiplePublish", "MultiplePublish");
        $this->__addEvent("BtnMultipleUnpublish", "MultipleUnpublish");
        $this->__addEvent("BtnMultipleDelete", "MultipleDelete");
    }
    
    /**
     * Rendezés eseménye.
     * A TxtSort input mező értékének segítségével beállítja a rendezést.
     * Értéke tömb, első paramétere a mi szerint, második paramétere a hogyan.
     * Ezt a feltételt menti Sessionbe
     */
    protected function onClick_Rendez() {
        $values = explode("__", $this->getItemValue("TxtSort","onClick_Rendez"));
        if($values[0] AND $values[1]){
            $this->_model->tableHeader[$values[0]]["sort"] = $values[1];
            $this->_model->sortBY = $values[0]." ". $values[1];
            $_SESSION[$this->_name]["TxtSort"] = $this->_params["TxtSort"]->_value;
        }   
    }
    
    protected function onClick_DelFilter(){
    	$sort = $_SESSION[$this->_name]["TxtSort"];
        $this->formReset();
		$this->_params["TxtSort"]->_value = $_SESSION[$this->_name]["TxtSort"] = $sort; 
    }
    
    /**
     * Sor publikussá tételének eseménye
     * 
     * @uses Admin_List_Model::__modifyRowStatusz()
     * @uses Exception_Form_Message
     * @uses Exception_Form_Error
     * 
     * @throw Exception_Form_Message sikeres művelet esetén
     * @throw Exception_Form_Error sikertelen művelet esetén
     * 
     * @catch Exception_MYSQL_Null_Affected_Rows ha nem történt változás az adott sorban akkor hibát dob
     */
    protected function onClick_Publish(){
        UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
        try {
            $this->_model->__modifyRowStatusz("aktiv", $this->_events["BtnPublish"]->_value);
            throw new Exception_Form_Message(LANG_AdminList_msg_publikalas);
        }catch(Exception_MYSQL_Null_Affected_Rows $e){
             throw new Exception_Form_Error($e->getMessage());
        }
    }
    
    /**
     * Sor publikálás visszavonásának eseménye
     * 
     * @uses Admin_List_Model::__modifyRowStatusz()
     * @uses Exception_Form_Message
     * @uses Exception_Form_Error
     * 
     * @throw Exception_Form_Message sikeres művelet esetén
     * @throw Exception_Form_Error sikertelen művelet esetén
     * 
     * @catch Exception_MYSQL_Null_Affected_Rows ha nem történt változás az adott sorban akkor hibát dob
     */
    protected function onClick_Unpublish(){
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
         try {
              $this->_model->__modifyRowStatusz("aktiv", $this->_events["BtnUnpublish"]->_value);
             throw new Exception_Form_Message(LANG_AdminList_msg_visszavonas);
         }catch(Exception_MYSQL_Null_Affected_Rows $e){
             throw new Exception_Form_Error($e->getMessage());
        }
    }
    
    /**
     * Több sor logikai törlésének eseménye
     * 
     * @uses Admin_List_Model::__modifyRowStatuszWithValue()
     * @uses Exception_Form_Message
     * 
     * @throw Exception_Form_Message sikeres művelet esetén kiírja, hogy hány elemet jelöltünk ki
     * 
     * @catch Exception_MYSQL_Null_Affected_Rows ha nem történt változás nem csinál semmit
     */
    protected function onClick_MultipleDelete(){
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
         if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try {
                    $this->_model->__modifyRowStatuszWithValue("torolt", $val, 1);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_torles);
        }
    }
    
    /**
     * Több sor publikussá tételének eseménye
     * 
     * @uses Admin_List_Model::__modifyRowStatuszWithValue()
     * @uses Exception_Form_Message
     * 
     * @throw Exception_Form_Message sikeres művelet esetén kiírja, hogy hány elemet jelöltünk ki
     * 
     * @catch Exception_MYSQL_Null_Affected_Rows ha nem történt változás nem csinál semmit
     */
    protected function onClick_MultiplePublish(){
        UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
        if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try{
                    $this->_model->__modifyRowStatuszWithValue("aktiv", $val, 1);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_publikalas);
        }
    }
    
    /**
     * Több sor publikálás visszavonásának eseménye
     * 
     * @uses Admin_List_Model::__modifyRowStatuszWithValue()
     * @uses Exception_Form_Message
     * 
     * @throw Exception_Form_Message sikeres művelet esetén kiírja, hogy hány elemet jelöltünk ki
     * 
     * @catch Exception_MYSQL_Null_Affected_Rows ha nem történt változás nem csinál semmit
     */
    protected function onClick_MultipleUnpublish(){
         UserLoginOut_Controller::verifyFunctionAccess($_REQUEST["al"]."edit");
         if(is_array($this->_params["SelRow"]->_value)){
            $i=0;
            foreach($this->_params["SelRow"]->_value as $val){
                try{
                    $this->_model->__modifyRowStatuszWithValue("aktiv", $val, 0);
                }catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                $i++;
            }
            throw new Exception_Form_Message("$i ".LANG_AdminList_msg_multi_visszavonas);
        }
    }
    
    /**
     * Fejléc listába helyezése
     * 
     * @uses Page_List::getList()
     */
    protected function getList(){
        $this->_view->assign("Fejlec", $this->_model->tableHeader);
        parent::getList();
    }
    
    /**
     * A lista keresésének Sessionben tárolása.
     * 
     * @param mixed $feltetel
     * @param string $item
     * 
     * @uses Page_List::setWhereInput()
     */
    protected function setWhereInput($feltetel, $item) {
       $this->_model->__setWhereInput($feltetel, $item);
       $_SESSION[$this->_name][$item] = $this->_params[$item]->_value;    
    }
    
    /**
     * Események futtatásakor a keresés és rendezés esemény automatikus hívása
     * 
     */
    public function __runEvents() {
        parent::__runEvents();
        $this->onClick_Filter();
        $this->onClick_Rendez();
    }
}