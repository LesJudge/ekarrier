<?php
include_once "library/lib.paging.php";
include_once "page/all/model/page.list_model.php";

/**
 * Lista
 * 
 * @package Global
 * @subpackage Controller
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */  
abstract class Page_List extends RimoController {
     /**
     * @var Paging Lapozást kezelő osztályhozzáadása és a nyelvesített lista beállítása
     */
    protected $vPaging;
    protected $_verify_event_manual = true;
    protected $_multiple_lang = true;
    protected $vDataArray;
    
    public function __construct($nyelv_id="") {
        $this->_action_type = &$_REQUEST;
        if($this->_multiple_lang==true){
            $this->_model->__setNyelvID($nyelv_id);
            $this->_model->listWhere["nyelv_id"] = "{$this->_model->_tableName}.nyelv_id={$nyelv_id}";
        }
        $this->__addEvent("BtnNumOnPage", "SetNumOnPage");
        $this->vPaging = new Paging();
        $this->vPaging->__setURL($_SERVER["REQUEST_URI"]);
        $this->_model->__addForm();
    }
    
    /**
     * Az lapozáshoz szükséges elem/oldal szám beállításának eseménye.
     * Sessionben tárolódik.
     */
    protected function onClick_SetNumOnPage(){
        $_SESSION[$this->_name]["SelPagingLimit"] = $this->getItemValue("SelPagingLimit");
        $this->vPaging->_limit_per_page = $_SESSION[$this->_name]["SelPagingLimit"]; 
    }
        
    /**
     * Az elem/oldal betöltése sessionből, ha az szám, és a SelPagingLimit value-t is beállítja erre az értékre
     *  Lista összes elemének lekérdezése, amelyet át is ad a lapozó osztálynak. 
     * 
     * 
     * @uses Page_List_Model::__loadListCount()
     */
    protected function getCount() {
        
        if(isset($_SESSION[$this->_name]["SelPagingLimit"])){
            $this->vPaging->_limit_per_page = $_SESSION[$this->_name]["SelPagingLimit"];
            $this->_params["SelPagingLimit"]->_value = $this->vPaging->_limit_per_page; 
        }
        $this->vPaging->set($this->_model->__loadListCount());
    }
    
    /**
     * Lista lekérdezése. Itt kerül meghívásra a getCount függvény.
     * TODO: cache kellene  a getCount()-ra
     * 
     * @uses Page_List::getCount()
     * @catch Exception_Mysql_Null_Rows a view FormError-ba helyezi, hogy nincs megjelenítendő elem.
     */
    protected function getList() {
        try{
            $this->getCount();
            $this->_model->limit = $this->vPaging->getSqlLimit();
            $this->vDataArray = $this->_model->__loadList();
        }
        catch (Exception_Mysql_Null_Rows $e) {
        	$this->_view->assign("No_SelTetel", true);
            $this->_view->assign("FormInfo", LANG_PageList_nincs_elem);
        }
        catch (Exception $e) {
        	$this->_view->assign("No_SelTetel", true);
            $this->_view->assign("FormError", $e->getMessage());
        }
    }
    
     /**
     * Lista kiíratása. A getList függvény meghívása után a megfelelő lista és lapozás és nyelvesítési 
     * elemeket a template-be helyezi.
     * 
     * @uses Page_List::getList()
     * @uses Paging::getTemplate()
     */    
    public function __show(){
        $this->getList();
        $this->_view->assign("Lista", $this->vDataArray);
        $this->_view->assign("DOMAIN_ADMIN", Rimo::$_config->DOMAIN_ADMIN);
        $this->_view->assign("DOMAIN", Rimo::$_config->DOMAIN);
        $this->_view->assign("Lapozas",  $this->vPaging->getTemplate());
        if($this->_multiple_lang==true)
            $this->_view->assign("LANG_PARAM", "?nyelv=".$this->_model->nyelvID);
    }
}
?>