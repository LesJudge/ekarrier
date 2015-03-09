<?php
/**
 * RimoController
 * 
 * @property Smarty $_view Nézet.
 * 
 * @package FrameWork
 * @subpackage Library
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
abstract class RimoController {
    /**
     * @var Smarty
     */
    public $_view;
    /**
     * @var array Event objektumokat gyűjtő tömb
     */
    public $_events = array();
    /**
     * @var array $_REQUEST|$_GET|$_POST|$_SESSION|$_FILE
     */
    public $_action_type = null;
    /**
     * @var string Egyedi azonosító
     */
    public $_name = null;
    /**
     * @var array Item objektumokat gyűjtő tömb
     */
    public $_params = array();
    /**
     * @var boolean true|false Több esemény lehet-e az oldalon egyszerre
     */
    public $_multiple_event = false;
    /**
     * @var int Lefuttatott események száma
     */
    public $_runned_event = 0;
    /**
     * @var string A $_view -ba elhelyezett scriptek
     */
    public $_scripts;
    /**
     * @var Betöltött model osztály
     */
    public $_model;
    
    /**
     * @var boolean true|false Ha kézzel, az adott függvényben validálunk
     */
    protected $_verify_event_manual = false;
    
    protected $_translate = false;
    
    /**
     * Modul Model osztály betöltése a Controller számára.
     * 
     * @access public
     * @param string $class_prefix
     * @uses Rimo::__load()
     * 
     */
    public function __loadModel($class_prefix="") {
        $this->_model = Rimo::__getSingleton("model", $class_prefix); 
        
    }
    
     /**
     *  Külső, a modulon kívüli Model osztály betöltése a Controller számára.
     * 
     * @access public
     * @param mixed $app_path
     * @param mixed $class_prefix
     * @uses Rimo::__loadPublic()
     * 
     * @return Model
     */
    public function __loadPublicModel($app_path, $class_prefix) {
        return Rimo::__loadPublic("model", $app_path.$class_prefix, $app_path); 
    }
    


    /**
     * A kapott tömböt hozzáfűzi a controller paramétereihez.
     * Így lehetőség van több több Model paramétereit betölteni egy Controllerhez.
     * 
     * @access public
     * @param array $params
     */
    public function __addParams(array $params){
        $this->_params = array_merge($params, $this->_params);
    }
    
    /**
     * Esemény készítése. Beállításra kerül, hogy mely függvény hajtódjon végre az esemény bekövetkeztekor.
     * A függvény neve: $function_type."_".$function_name
     * 
     * @access public
     * @param string $event_name
     * @param string $function_name
     * @param string $function_type
     * 
     * @return Event
     */
    public function __addEvent($event_name, $function_name, $function_type = "onClick") {
        $this->_events[$event_name] = new Event($event_name);
        $this->_events[$event_name]->_action_type = $this->_action_type;
        $this->_events[$event_name]->_params["function"] = $function_type . "_" . $function_name;
        return $this->_events[$event_name];
    }
   
    /**
     * Item object lekérdezése a {@link RimoController::$__params} tömbből. A $function az Exception generálásnál fontos, hogy tudjuk mely függvényben keletkezett kivétel.
     * 
     * @access public
     * @param string $item_name
     * @param string $function
     * 
     * @uses Exception_Form::Create_Error()
     * @throw Exception_Item_error Ha nem létező elemre hivatkozunk
     * 
     * @return Item
     */
    public function getItemObject($item_name, $function = "getItemObject") {
        if (!array_key_exists($item_name, $this->_params)) {
            throw Exception_Form::Create_Error("ITEM", $function, $item_name);
        }
        return $this->_params[$item_name];
    }

    /**
     * Item object értékének lekérdezése a {@link RimoController::$__params} tömbből. A  $function az Exception generálásnál fontos, hogy tudjuk mely függvényben keletkezett kivétel.
     * 
     * @access public
     * @param mixed $item_name
     * @param string $function
     * @uses Exception_Form::Create_Error()
     * @throw Exception_Item_error  Ha nem létező elemre hivatkozunk
     * 
     * @return Item::$_value
     */
    public function getItemValue($item_name, $function = "getItemValue") {
        if (!array_key_exists($item_name, $this->_params)) {
            throw Exception_Form::Create_Error("ITEM", $function, $item_name);
        }
        return $this->_params[$item_name]->_value;
    }

    /**
     * Kinullázza a _params-ok value-ját és a SESSION tömböt.
     */
    public function formReset() {
        foreach ($this->_params as $item_key => $item_value) {
            $this->_params[$item_key]->_value = null;
        }
        unset($_SESSION[$this->_name]);
    }
    
    /**
     * A beállított {@link RimoController::$_action_type} tömbben, illetve az itemnek külön beállított tömbben 
     * megvizsgálja, hogy van-e a kapott nevű eleme (Lásd file feltöltés).
     * Visszatérési értéke az elem értéke, vagy a $_SESSION-ben lévő érték, vagy false
     * 
     * @access public
     * @param string $name
     * @uses Exception_Form::Create_Error()
     * @throw Exception_Action_error Ha nincs $_action_type vagy $_name beállítva
     * 
     * @return RimoController::$_action_type[$val]|$_SESSION[RimoController::$_name][$val]|false
     */
    public function __methodVerify($name) {
        if ($this->_action_type === null or $this->_name === null) {
            throw Exception_Form::Create_Error("ACTION", "", "Form: " . $name);
        }        
        if($this->_params[$name]->_action_type !== null){
            if (isset($this->_params[$name]->_action_type[$this->_name . $name]))
                return $this->_params[$name]->_action_type[$this->_name . $name];
        }
        elseif(isset($this->_action_type[$this->_name . $name])) { 
            return $this->_action_type[$this->_name . $name];    
        } elseif (isset($_SESSION[$this->_name][$name])) {
            return $_SESSION[$this->_name][$name];
        }
        return false;
    }
    
    /**
     * A beállított event $_action_type tömbjében megvizsgálja, hogy van-e a kapott nevű eleme.
     * Visszatérési értéke az elem értéke vagy false. Ez az eseményeknél használatos.
     * 
     * @access private
     * @param string $name
     * 
     * @return RimoController::$_action_type[$val]|false
     */
    private function eventVerify($name){  
        if($this->_events[$name]->_action_type !== null){
            if (isset($this->_events[$name]->_action_type[$this->_name . $name]))
                return $this->_events[$name]->_action_type[$this->_name . $name];
        }
        elseif(isset($this->_action_type[$this->_name . $name])) { 
            return $this->_action_type[$this->_name . $name];
        }
        return false;
    }
    
    /**
     * Értéket ad a {@link RimoController::__methodVerify()} függvény segítségével. 
     * Az értéket átalakítja <code>trim(stripcslashes($value))</code>.
     * Ha a paraméter Item select, és az Item::$_verify_multiple_values === true, akkor azt is vizsgálja, hogy a kapott érték benne van-e az Item::$_select_value tömbben.
     * 
     * @access public 
     * @param string $param_key
     * @uses RimoController::__methodVerify()
     * @uses Exception_Form::Create_Error()
     * @throw Exception_Item_error Ha az elem select, és a kapott érték nincs az Item::$_select_value tömbben
     */
    public function __setParamValue($param_key){
        $value = $this->__methodVerify($this->_params[$param_key]->_name);
        if($value!==false){
            if(isset($this->_params[$param_key]->_select_value)){
                if(is_array($value)){
                    foreach($value as $value_key => $value_data){
                        if($this->_params[$param_key]->_verify_multiple_values === true){
                            if (!$this->_params[$param_key]->_select_value[$value_data]){
                                throw Exception_Form::Create_Error("ITEM_SELECT", "", $param_key);}
                        }
                        $this->_params[$param_key]->_value[$value_key] = trim(stripcslashes($value_data));
                    }
                }
                else{
                    if($this->_params[$param_key]->_verify_multiple_values === true){
                        if (!$this->_params[$param_key]->_select_value[$value]){
                            throw Exception_Form::Create_Error("ITEM_SELECT", "", $param_key);
                        }
                    }
                    $this->_params[$param_key]->_value = trim(stripcslashes($value));
                }
            }
            elseif(is_array($value)){
                $this->_params[$param_key]->_value = $value;
            }
            else {
                $this->_params[$param_key]->_value = trim(stripcslashes($value));
            }
        }
    }
    
    /**
     * A {@link RimoController::$_params} tömb elemein lefuttatja a {@link RimoController::__setParamValue()} függvényt.
     * 
     * @access public 
     * @uses RimoController::__setParamValue()
     */
    public function __runParams() {
        foreach ($this->_params as $param_key => $param_value) {
            $this->__setParamValue($param_key);
        }
    }

    /**
     * A Controller eseményeinek futtatása. Állítható, hogy 1 avagy több esemény ({@link RimoController::$_multiple_event}) hajtódhat végre 1 futáskor.
     * Az első futás esetében vizsgálja csak a kötelező beviteli mezőket.
     * 
     * 
     * @access public
     * @uses RimoController::verifyInputItem()
     * @uses RimoController::__verify()
     * 
     * 
     * @catch Exception_Form_Error Elhelyezi a view-ba (FormError)
     * @catch Exception Elhelyezi a view-ba (FormError)
     * @catch Exception_Form_Message Elhelyezi a view-ba (FormMessage) 
     * @catch Exception_MYSQL_Null_Affected_Rows elkapja, nem csinál vele semmit
     */
    public function __runEvents() {
        foreach ($this->_events as $event) {
            $event->_value = $this->eventVerify($event->_name);
            if ($event->_value !== false) {
                try {
                    if ($this->_runned_event === 0 AND $this->_verify_event_manual===false) {
                        $this->verifyInputItem($this->_params);
                        $this->__verify();
                    }
                    $run_function = $event->_params["function"];
                    $this->$run_function();
                }
                catch (Exception_Form_Error $e) {
                    $this->_view->assign("FormError", $e->getMessage());
                }
                catch (Exception_Verify_error $e) {
                    $this->_view->assign("FormWarning", $e->getMessage());
                }
                catch (Exception_Form_Message $e) {
                    $this->_view->assign("FormMessage", $e->getMessage());
                }
                catch(Exception_MYSQL_Null_Affected_Rows $e){
                }
                catch (Exception $e) {
                    $this->_view->assign("FormError", $e->getMessage());
                }
                $this->_runned_event++;
            }
            if ($this->_runned_event != 0 and $this->_multiple_event === false)
                break;
        }
    }
    
    /**
     * Vizsgálat.
     * 
     * @return void
     */
    public function __verify(){
        
    }

    /**
     * A megadott inputok vizsgálata a {@link Verify} object segítségével.
     * A hibát mind a {@link RimoController::_error} tömbbe, mind pedig az {@link Item::_error} változójába beleteszi
     * 
     * @param $params
     * 
     * @access public
     * @uses Verify::setObject()
     */
    public function verifyInputItem(array $params) {
        $kitoltes_hiba = false;
        $verifyObject = new Verify;
        foreach ($params as $param_value) {
            $param_key = $param_value->_name;
            if (is_array($param_value->_verify)) {
                $verifyObject->setObject($param_value);
                foreach ($param_value->_verify as $verify_function=>$verify_param) {
                    $param_value->_error = $verifyObject->$verify_function($verify_param);
                    if ($param_value->_error) {
                        $kitoltes_hiba = true;
                        $this->_error[] = $param_value->_error;
                    }
                }
            }
        }
        if ($kitoltes_hiba) {
              throw Exception_Form::Create_Error("VERIFY",'','',$this->_translate->__("Hibás form kitöltés"));
        }
    }

    /**
     * A formot kigenerálja a megadott file segítségével.
     * <ul><li>FormScript</li><li>FormName</li></ul>
     * 
     * @param string $view_file
     * @uses Item::__show()
     * @uses Event::__show()
     * 
     * @return Smarty::fetch()
     */
    public function __generateForm($view_file) {
        $this->_view->assign("FormScript", $this->_scripts);
        $this->_view->assign("FormName", $this->_name);
        foreach ($this->_params as $param_value) {
            $this->_view->assign($param_value->_name, $param_value->__show($this->_name));
        }
        foreach ($this->_events as $event_value) {
            $array = $event_value->__show($this->_name);
            $this->_view->assign($event_value->_name, $array["name"]);
            $this->_view->assign($event_value->_name . "_val", $array["value"]);
        }
        return $this->_view->fetch($view_file);
    }
    
    /**
     * Script hozzáfűzése a formhoz.
     * 
     * @param string $script
     */
    public function __addScript($script){
        $this->_scripts .= $script;
    }
    
    /**
     * A Controller futtatása
     * 
     * @uses RimoController::__runParams()
     * @uses RimoController::__runEvents()
     * @uses Smarty
     * 
     * @catch Exception_Action_error Elhelyezi a view-ba (FormError)
     * @catch Exception_Item_error Elhelyezi a view-ba (FormError)
     */
    public function __run() {
        //$this->_view = new Smarty;
        //$this->_view->compile_dir = 'cache/smarty';
        
        $this->_view = Rimo::$pimple['smarty'];
        $this->_view->assign("APP_PATH", Rimo::$_config->APP_PATH);
        
        //var_dump(Rimo::$_config->APP_PATH);
        //var_dump($_REQUEST['al']);
        //echo '<br />';
        /**
         * Undefined index.
         * Módosítva: 2015-01-30
         */
        //$this->_view->assign("APP_LINK", Rimo::$_config->APP_LINK[$_REQUEST["al"]]);
        $appLink = array();
        if (isset(Rimo::$_config->APP_LINK) && isset($_REQUEST['al']) && isset(Rimo::$_config->APP_LINK[$_REQUEST['al']])) {
            $appLink = Rimo::$_config->APP_LINK[$_REQUEST['al']];
        }
        $this->_view->assign("APP_LINK", $appLink);
        $this->_view->assign("DOMAIN_ADMIN", Rimo::$_config->DOMAIN_ADMIN);
        $this->_view->assign("DOMAIN", Rimo::$_config->DOMAIN);
        $this->_translate = Rimo::getTranslate();
        //$this->_view->assignByRef("lang", $this->_translate->translate(get_class($this)));
        $this->_view->assign("lang", $this->_translate->translate(get_class($this)));
        try {
            $this->__runParams();
            $this->__runEvents();
        }
        catch (Exception_Action_error $e) {
            $this->_view->assign("FormError", $e->getMessage());
        }
        catch (Exception_Item_error $e) {
            $this->_view->assign("FormError", $e->getMessage());
        }
        catch (Exception_Form_Error $e) {
            $this->_view->assign("FormError", $e->getMessage());
        }
        catch (Exception_Form_Message $e) {
            $this->_view->assign("FormMessage", $e->getMessage());
        }
        catch (Exception $e) {
            $this->_view->assign("FormError", $e->getMessage());
        }
        $this->__show();
    }
    
    /**
     * A Controller megjelenítése a böngészőben.
     */
    public function __show(){
    }
}