<?php

/**
 * ActiveRecord modelhez hibaüzenet megjelenítő.
 * 
 * @property string $property A példányváltozó neve.
 * @property boolean $rawError Nyers hibaüzenetet adjon-e át a nézetnek.
 * @property string $view A nézet fájlneve.
 * @property string $viewExt A nézet fájl kiterjesztése.
 * @property string $viewPath A nézet fájt tartalmazó könyvtár.
 * @property \ActiveRecord\Model $model Model.
 * @property Smarty $template Smarty objektum, ami rendereli a hibaüzenetet.
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class ArErrorRenderer
{

    const VIEW_PATH = 'views';

    public $property;
    public $rawError = false;
    public $view = null;
    public $viewExt = '.tpl';
    public $viewPath = null;
    public $openTag = 'p';
    public $closeTag = 'p';
    public $errorClass = 'error small';
    public $attributes = array();
    protected $model;
    protected $template;

    public function __construct(array $params)
    {
        if ($this->validateParameters($params)) {
            $this->setModel($params['model']);
            $this->setProperty($params['property']);
            $this->setTemplate($params['template']);
            if (isset($params['viewPath'])) {
                $viewPath = $params['viewPath'];
            } else {
                $viewPath = null;
            }
            $this->setViewPath($viewPath);
            $this->setView($params['view']);
            if (isset($params['rawError'])) {
                $this->setRawError($params['rawError']);
            }
        }
    }
    /**
     * Visszatér az alapértelmezett nézetek könyvtárával.
     * @return string
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }
    /**
     * Visszatér a model-lel.
     * @return \ActiveRecord\Model
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Visszatér a property nevével.
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }
    /**
     * Visszatér a nézet nevével.
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }
    /**
     * "Nyers" hibaüzenettel dolgozik-e.
     * @return boolean
     */
    public function getRawError()
    {
        return $this->rawError;
    }
    /**
     * Visszatér a Smarty objektummal.
     * @return Smarty
     */
    public function getTemplate()
    {
        return $this->template;
    }
    /**
     * Visszatér a nézet kiterjesztésével.
     * @return string
     */
    public function getViewExt()
    {
        return $this->viewExt;
    }
    /**
     * Beállítja a model-t.
     * @param \ActiveRecord\Model $model
     * @return void
     */
    protected function setModel(\ActiveRecord\Model $model)
    {
        $this->model = $model;
    }
    /**
     * Beállítja az property példányváltozó értékét, ha a paraméterül adott property megtalálható a modelben.
     * Ha nem, akkor <b>UndefinedPropertyException</b>-t dob!
     * @param string $property
     * @return void
     * @throws \ActiveRecord\UndefinedPropertyException
     */
    public function setProperty($property)
    {
        if (array_key_exists($property, $this->model->attributes())) {
            $this->property = $property;
        } else {
            throw new \ActiveRecord\UndefinedPropertyException(get_class($this->model), $this->property);
        }
    }
    /**
     * Beállítja a nézetet, ha az valid. Ha nem, akkor InvalidArgumentException-t dob!
     * @param string $view Nézet fájlneve.
     * @return void
     * @throws InvalidArgumentException
     */
    public function setView($view)
    {
        if ($this->isValidView($view)) {
            $this->view = $view;
        } else {
            throw new InvalidArgumentException("A paraméterül adott nézet nem megfelelő!");
        }
    }
    /**
     * Beállítja a template-et.
     * @param Smarty $template
     * @return void
     */
    protected function setTemplate(Smarty $template)
    {
        $this->template = $template;
    }
    /**
     * Beállítja a rawError értékét. ("Nyersen" assign-olja-e a hibaüzenetet vagy dolgozza fel előtte.)
     * @param boolean $rawError
     * @return void
     */
    public function setRawError($rawError)
    {
        $this->rawError = (boolean) $rawError;
    }
    /**
     * Beállítja a nézet kiterjesztését.
     * @param string $viewExt
     * @return void
     */
    public function setViewExt($viewExt)
    {
        $this->viewExt = $viewExt;
    }
    /**
     * Beállítja a nézet elérési útját.
     * @param string $viewPath
     * @return void
     */
    public function setViewPath($viewPath = null)
    {
        if ($viewPath == null) {
            $viewPath = __DIR__ . '/' . self::VIEW_PATH . '/';
        }
        $this->viewPath = $viewPath;
    }
    /**
     * Megvizsgálja, hogy a kötelező paraméterek léteznek-e. Ha nem, kivételt dob.
     * @param array $params
     * @return boolean
     * @throws InvalidArgumentException
     */
    protected function validateParameters(array $params)
    {
        if (isset($params['model']) && isset($params['property']) && isset($params['view'])) {
            return true;
        } else {
            //echo '<pre>', print_r($params, true), '</pre>';
            //exit;
            throw new InvalidArgumentException('A kötelező paraméterek egyike (model, property, view) hiányzik!');
        }
    }
    /**
     * Megvizsgálja, hogy a fájlnév kiterjesztése illik-e a $viewExt-ben megadottra, valamint létezik-e a fájl.
     * @param string $view Nézet fájlneve.
     * @return boolean
     */
    protected function isValidView($view)
    {
        return strpos($view, $this->viewExt) !== false && file_exists($this->getViewPath() . '/' . $view);
    }
    /**
     * Feldolgoza a hibaüzenet tömböt.
     * @param array $error
     * @return string
     */
    public static function processArray(array $error)
    {
        $errorMessage = '<ul style="margin: 0px; padding: 0px;">';
        foreach ($error as $e) {
            $errorMessage .= '<li>' . $e . '</li>';
        }
        $errorMessage .= '</ul>';
        return $errorMessage;
    }
    /**
     * Feldolgozza a string hibaüzenetet.
     * @param string $error
     * @return string
     */
    public static function processString($error)
    {
        return $error;
    }
    /**
     * Alapértelmezett hibaüzenet feldolgozás.
     * @param mixed $error
     * @return string
     */
    public static function processDefault($error)
    {
        return self::processString($error);
    }
    
    public static function processErrorMessage($error)
    {
        $type = gettype($error);
        $methodName = 'process'.ucfirst($type);
        if (method_exists(get_class(), $methodName)) {
            $errorMessage = call_user_func(array(get_class(), $methodName), $error);
        }
        else {
            $errorMessage = self::processDefault($error);
        }
        return $errorMessage;
    }
    /**
     * Megjeleníti a hibaüzenetet.
     * @return string
     */
    public function __toString()
    {
        if (is_object($this->model->errors) && ($error = $this->model->errors->on($this->property))) {
            if (!$this->getRawError()) {
                $errorMessage = $this->processErrorMessage($error);
            } else {
                $errorMessage = $error;
            }
            $this->template->assign('errorMessage', $errorMessage);
            return $this->template->fetch($this->getViewPath() . '/' . $this->getView());
        }
        return '';
    }
}