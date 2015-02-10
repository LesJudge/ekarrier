<?php

/**
 * Exception_Mysql
 * 
 * MYSQL hibakezelés
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_MYSQL extends Exception {
    /**
     * 
     * Hibakód alapján példányosítja a megefelelő kivétel osztályt. 
     * 
     * @param string $message
     * @param int $code
     */
    static function Create_Error($message = false, $code = false) {
        if (!$code) {
            $code = mysql_errno();
        }
        $message .= mysql_error();
        switch ($code) {
            case 'null_rows':
                return new Exception_MYSQL_Null_Rows($message);
                break;
            case 'null_affected_row':
                return new Exception_MYSQL_Null_Affected_Rows($message);
                break;
            default:
                return new Exception_MYSQL($message);
                break;
        }
    }
}

/**
 * Exception_MYSQL_Null_Rows
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_MYSQL_Null_Rows extends Exception_Mysql {
}

/**
 * Exception_MYSQL_Null_Affected_Rows
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_MYSQL_Null_Affected_Rows extends Exception_Mysql {
}

/**
 * Exception_Form_Error
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_Form_Error extends Exception {
}
/**
 * Exception_Form_Message
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_Form_Message extends Exception {
}

/**
 * Exception_Form
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_Form extends Exception {
    /**
     * 
     * Típus alapján példányosítja a megefelelő kivétel osztályt egy definiált üzenettel. 
     * 
     * @param string $type
     * @param string $function
     * @param string $elem_name
     * @return
     */
    static function Create_Error($type, $function, $elem_name) {
        switch ($type) {
            case 'ITEM':
                $message = "
                    <strong>Nincs ilyen Beviteli mező!</strong> <br> 
                    <strong>Name:</strong> {$elem_name}<br>  
                    <strong>Function:</strong> {$function}
                ";
                return new Exception_Item_error($message);
                break;

            case 'ACTION':
                $message = "
                            <strong>A fogadó metódus nincs jól beállítva!" .
                    ' ( pl.: $this->_action_type = $_REQUEST; $this->_name = ModulList;)' . "</strong> <br> 
                            <strong>Name:</strong> {$elem_name}<br>  
                            <strong>Function:</strong> __methodVerify(name)
                ";
                return new Exception_Action_error($message);
                break;
                
            case 'ITEM_SELECT':
                $message = "
                            <strong>A kapott érték nem szerepel a select választható értékei között!</strong><br>
                            <strong>Name:</strong> {$elem_name}<br>  
                ";
                return new Exception_Item_error($message);
                break;
            
            case 'VERIFY':
                $message = "Hibás form kitöltés!";
                return new Exception_Verify_error($message);
                break;

            default:
                return new Exception_Form($message);
                break;
        }
    }
}

/**
 * Exception_Item_error
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_Item_error extends Exception {
}

/**
 * Exception_Verify_error
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_Verify_error extends Exception {
}


/**
 * Exception_Action_error
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_Action_error extends Exception {
}

/**
 * Exception_Load
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_Load extends Exception {
    /**
     * 
     * Típus alapján példányosítja a megefelelő kivétel osztályt. 
     * 
     * @param string $type
     * @param string $message
     */
    static function Create_Error($type, $message) {
        switch ($type) {
            case 'Controller':
                $message = "
                    <div class='notice error'> 
                        <p> 
                            <strong>Controller not found!</strong> <br> 
                            <strong>Path:</strong> {$message}<br>  
                            <strong>Function:</strong> __loadController(added_name)
                        </p>
                    </div>
                    <div class='clear'></div>
                ";
                return new Exception_Load_error($message);
                break;
            case 'Modul':
                $message = "
                    <div class='notice error'>
                        <p>  
                            <strong>Modul not found!</strong> <br> 
                            <strong>Path:</strong> {$message}<br>  
                            <strong>Function:</strong> __loadModul(class_name)
                        </p>
                    </div>
                    <div class='clear'></div>
                ";
                return new Exception_Load_error($message);
                break;
            case 'sql':
                $message = "
                    <div class='notice error'> 
                        <p> 
                            <strong>SQL not found!</strong> <br> 
                            <strong>Path:</strong> {$message}<br>
                        </p>  
                    </div>
                    <div class='clear'></div>
                ";
                return new Exception_Load_error($message);
                break;

            case 'model':
                $message = "
                    <div class='notice error'> 
                        <p> 
                            <strong>Model not found!</strong> <br> 
                            <strong>Name:</strong>{$message}<br>
                        </p>  
                    </div>
                    <div class='clear'></div>
                ";
                return new Exception_Load_error($message);
                break;

            case 'Verify':
                $message = "
                    <div class='notice error'> 
                        <p> 
                            <strong>Not a valid verify type!<strong> <br> 
                            <strong>Type:</strong>{$message}<br>
                        </p>  
                    </div>
                    <div class='clear'></div>
                ";
                return new Exception_Load_error($message);
                break;
            
            case 'Controller_Access':
                $message = "
                    <div class='notice error'> 
                        <p> 
                            Önnek nincs joga a kért oldal megtekintéséhez! <br>   
                        </p>
                    </div>
                    <div class='clear'></div>
                ";
                return new Exception_Load_error($message);
                break;
            default:
                $message = "
                    <div class='notice error'> 
                        <p> 
                            <strong>Default!<strong> <br> 
                            <strong>Name:</strong>{$message}<br>  
                            <strong>Function: </strong>LOAD
                        </p>
                    </div>
                    <div class='clear'></div>
                ";
                return new Exception_Load_error($message);
                break;
        }
    }
}

/**
 * Exception_Load_error
 * 
 * @package FrameWork
 * @subpackage Exception
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 */
class Exception_Load_error extends Exception {
}

class Exception_404 extends Exception {
}

?>