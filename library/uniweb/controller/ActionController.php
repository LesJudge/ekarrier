<?php
/**
 * Action Controller
 * 
 * @property string $defaultAction Az alapértelmezett action. Ez fut le akkor, ha nincs action kérés.
 * @property string $action Az action, aminek le kell futnia.
 * 
 * @author Petró Balázs Máté <balazs@uniweb.hu>
 */
abstract class ActionController extends RimoController
{

        protected $defaultAction='actionIndex';
        protected $action=null;

        public function __construct()
        {
                $this->__run(); // Controller futtatása.
        }
        /**
         * Inicializálja a controllert.
         */
        protected function init()
        {
                $r=$this->getActionParams();
                if(isset($r['action'])) // Megvizsgálja, hogy van-e action kérés, ha igen...
                {
                        $actionName = trim($r['action']);
                        $requiredAction='action'.$actionName; // ...akkor veszi a nevét. Kap egy action prefixet, plusz a trim-elt nevet.
                        if(method_exists($this, $requiredAction)) // Megvizsgálja, hogy létezik-e a metódus, ha igen...
                        {
                                $this->action=$requiredAction; // ...akkor beállítja az action példányváltozót.
                        }
                        else
                        {
                                throw new BadMethodCallException("A kért action {$actionName} nem létezik!");
                        }
                }
                else
                {
                        $this->action=$this->defaultAction; // Ha pedig nem, akkor az alapértelemzett action fog lefutni.
                }
        }
        /**
         * Controller futtatása.
         * @return void
         */
        public function __run()
        {
                try
                {
                        $this->init(); // Controller inicializálása.
                        parent::__run(); // Controller futtatása.
                }
                catch(BadMethodCallException $bmce)
                {
                        echo $bmce->getMessage();
                        exit;
                }
                catch(InvalidArgumentException $iae)
                {
                        echo $iae->getMessage();
                        exit;
                }
        }
        /**
         * Futtatja az Action-t.
         * @return void
         */
        public function __show()
        {
                $rm=new ReflectionMethod($this, $this->action); // Példányosít egy ReflectionMethod objektumot. Paraméterei: az éppen "futó" osztály, valamint a kért action.
                $params=$rm->getParameters(); // Veszi az action paramétereit.
                $passParams=array(); // Ebbe a tömbbe kerülnek majd az action paraméterei.
                if(isset($params[0])) // Megvizsgálja, hogy van-e paramétere a metódusnak. Ha igen...
                {
                        $r=$this->getActionParams();
                        foreach($params as $param) // ..., akkor bejárja a tömböt.
                        {
                                $name=$param->name;
                                if(isset($r[$name]))
                                {
                                        $passParams[]=trim($r[$name]); // ..., akkor trim-eli azt, majd hozzáadja a tömbhöz.
                                }
                                else
                                {
                                        throw new InvalidArgumentException("Nem megfelelő paraméterek!"); // Ellenkező esetben pedig kivételt dob.
                                }
                        }
                }
                call_user_func_array(array($this,$this->action),$passParams); // Action futtatása.
        }
        /**
         * Visszatér az alapértelmezett action nevével.
         * @return string
         */
        public function getDefaultAction()
        {
                return $this->defaultAction;
        }
        /**
         * Visszatér az action nevével.
         * @return string
         */
        public function getAction()
        {
                return $this->action;
        }
        /**
         * Visszatér az action paraméterekkel.
         * @return array
         */
        public function getActionParams()
        {
                return $_GET;
        }

}