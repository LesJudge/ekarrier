<?php
/**
 * Rimo
 * 
 * @package FrameWork
 * @author Rimóczi Gergely
 * @copyright 2011
 * @version 1.0
 * @access public
 */
class Rimo
{
    /**
     * Beállítás paraméterek
     * @var RimoConfig
     */
    public static $_config;
    /**
     * Az oldal kerete
     * @var Smarty
     */
    public static $_site_frame;
    /**
     * Betöltött controller
     * @var RimoController
     */
    public static $_controller;

    public static $translate;

    private static $_registry = array();
    /**
     * Fájl alapú cache-elés.
     * @var \Gregwar\Cache\Cache
     */
    protected static $cache;
    /**
     * ClientWebUser objektum.
     * @var \ClientWebUser
     */
    protected static $clientWebUser;
    /**
     * CompanyWebUser objektum.
     * @var \CompanyWebUser
     */
    protected static $companyWebUser;
    /**
     * Pimple DI.
     * @var \Pimple\Container
     */
    public static $pimple;
    /**
     * Alkalmazás inicializálása.
     */
    public static function init()
    {
        static::__addConfig();
        static::__addSession();
        //static::initSiteFrame();
        static::initAr();
        static::$cache = new Gregwar\Cache\Cache();
        static::$cache->setPrefixSize(0);
        static::$cache->setCacheDirectory('cache/data');
        $db = static::__getSingletonDatabase('MYSQL_DB');
        $verifyException = 'Exception_404';
        static::$clientWebUser = new \ClientWebUser($db, $verifyException);
        static::$companyWebUser = new \CompanyWebUser($db, $verifyException);
        static::$pimple = new \Pimple\Container;
        //static::initSiteFrame();
    }
    /**
     * Visszatér a cache objektummal.
     * @return \Gregwar\Cache\Cache
     */
    public static function getCache()
    {
        return static::$cache;
    }
    /**
     * 
     * @return \ClientWebUser
     */
    public static function getClientWebUser()
    {
        return static::$clientWebUser;
    }
    /**
     * 
     * @return \CompanyWebUser
     */
    public static function getCompanyWebUser()
    {
        return static::$companyWebUser;
    }
    /**
     * Config hozzáadása a sitehoz, valamint a karakterkódolás beállítása header-el
     * 
     * @return $_config
     */
    public static function __addConfig()
    {
        if(is_object(static::$_config)) {
            return static::$_config;
        }
        static::$_config = new RimoConfig;
        header('Content-Type: text/html; charset=' . static::$_config->getItem('CHARSET'));
        return static::$_config;
    }
    /**
     * Session hozzáadás, és vizsgálat config alapján.
     * 
     * @uses Session::verify()
     */
    public static function __addSession()
    {
        //$session = new Session(static::$_config->getItem('SESSION_NAME'), null);
        $session = new Session(static::$_config->getItem('SESSION_NAME'), static::$_config->getItem('SESSION_DIR'));
        $session->verify();
    }
    /**
     * Inicializálja az "oldal keretét".
     */
    public static function initSiteFrame()
    {
        //static::$_site_frame = new Smarty;
        //static::$_site_frame->compile_dir = 'cache/smarty';
        static::$_site_frame = static::$pimple['smarty'];
        static::$_site_frame->assign('DOMAIN_ADMIN', static::$_config->getItem('DOMAIN_ADMIN'));
        static::$_site_frame->assign('DOMAIN', static::$_config->getItem('DOMAIN'));
        static::$_site_frame->assign('PAGE_CHARSET', static::$_config->getItem('PAGE_CHARSET'));
    }
    /**
     * 
     */
    protected static function initAr()
    {
        ActiveRecord\Config::initialize(function($cfg) {
            /* @var RimoConfig $rc */
            $rc = Rimo::getConfig();
            $mysqlHost =$rc->getItem('MYSQL_DB_HOST');
            $mysqlDb = $rc->getItem('MYSQL_DB_NAME');
            $mysqlCharset = $rc->getItem('MYSQL_DB_CHARSET');
            $mysqlUser = $rc->getItem('MYSQL_DB_USER');
            $mysqlPass = $rc->getItem('MYSQL_DB_PASS');
            //$cfg->set_model_directory('path/to/models'); // Opcionális.
            $cfg->set_connections(array(
                'development' => "mysql://{$mysqlUser}:{$mysqlPass}@{$mysqlHost}/{$mysqlDb}?charset={$mysqlCharset}"
            ));
        });
    }
    /**
     * Modul betöltés.
     * 
     * @param mixed $class_name
     * 
     * @uses Exception_Load::Create_Error()
     * @throw Exception_Load::Create_Error() ha a betölteni kívánt fájl nem létezik 
     */
    public static function __loadModul($class_name)
    {
        $path = "modul/$class_name/" . static::$_config->PAGE_NAME . "." . $class_name . "_index.php";
        if (!is_file($path)) {
            throw Exception_Load::Create_Error("Modul", $path);
        }
        include_once $path;
    }
    /**
     * Oldal elem betöltése. Pl: menü, felhasználó
     * 
     * @param mixed $modul_name
     * @param mixed $class_name
     * 
     * @uses Exception_Load::Create_Error()
     * @throw Exception_Load::Create_Error() ha a betölteni kívánt fájl nem létezik 
     */
    public static function __loadSiteElement($modul_name, $class_name)
    {
        $path = "modul/$modul_name/" . static::$_config->PAGE_NAME . "." . $modul_name . "_" . $class_name . ".php";
        if (!is_file($path)) {
            throw Exception_Load::Create_Error("Modul", $path);
        }
        include_once $path;
    }
    /**
     * Controller betöltése. Az aktuális modul APP_PATH tulajdonsága alapján betölti a modul controllerét. 
     * A self::$_controller  értéke a betöltött controller osztály.
     * 
     * @param string $added_name
     * @uses Exception_Load::Create_Error()
     * @throw Exception_Load::Create_Error() ha a betölteni kívánt fájl nem létezik 
     */
    public static function __loadController($added_name="")
    {
        $path="modul/".Rimo::$_config->APP_PATH."/controller/".self::$_config->PAGE_NAME.".".Rimo::$_config->APP_PATH.ucfirst($added_name).".php";
        if(!is_file($path)) {
            throw Exception_Load::Create_Error("Controller", $path);
        }
        include_once $path;
        $class_full_name = ucfirst(Rimo::$_config->APP_PATH).ucfirst($added_name)."_".ucfirst(self::$_config->PAGE_NAME)."_Controller";
        self::$_controller = new $class_full_name;
    }
    /**
     * Betöltés. Sql, model, stb.
     * 
     * @param mixed $var_type
     * @param mixed $class_name

     * @uses Exception_Load::Create_Error()
     * @throw Exception_Load::Create_Error() ha a betölteni kívánt fájl nem létezik 
     * 
     * @return Object
     */
    public static function __load($var_type, $class_name)
    {
        $path="modul/".Rimo::$_config->APP_PATH."/$var_type/".Rimo::$_config->APP_PATH.$class_name."_".ucfirst($var_type).".php";
        if (!is_file($path)) {
            throw Exception_Load::Create_Error($var_type, $path);
        }
        include_once $path;
        $class_full_name=ucfirst(Rimo::$_config->APP_PATH).$class_name."_".ucfirst($var_type);
        return new $class_full_name();
    }

    public static function __getSingleton($var_type, $class_name)
    {
        $registryKey='_singleton/'.$class_name;
        if (isset(self::$_registry[$registryKey])) {
            return self::$_registry[$registryKey];
        }
        return self::$_registry[$registryKey] = Rimo::__load($var_type, $class_name);
    }

    public static function __getSingletonDatabase($class_name)
    {
        $registryKey='_singletondatabase/'.$class_name;
        if(isset(self::$_registry[$registryKey])) {
            return self::$_registry[$registryKey];
        }
        return self::$_registry[$registryKey] = new $class_name;
    }
    /**
     * Külső, nem a modul elemének betöltése.
     * 
     * @param mixed $var_type
     * @param mixed $class_name
     * @param mixed $app_path
     * 
     * @uses Exception_Load::Create_Error()
     * @throw Exception_Load::Create_Error() ha a betölteni kívánt fájl nem létezik
     *  
     * @return Object
     */
    public static function __loadPublic($var_type, $class_name, $app_path)
    {
        $path="modul/".$app_path."/$var_type/".$class_name."_".ucfirst($var_type).".php";
        if (!is_file($path)) {
            throw Exception_Load::Create_Error("Modul", $path);
        }
        include_once $path;
        $class_full_name=$class_name."_".ucfirst($var_type);
        return new $class_full_name();
    }

    public static function getTranslate()
    {
        if(is_object(self::$translate)) {
            return self::$translate;
        }
    }
    /**
     * Permalink készítése
     * 
     * @param string $alias
     * @param string $locale
     * 
     */
    public static function create_alias($alias, $locale='hu_HU.UTF8')
    {
        $alias=trim($alias);
        setlocale(LC_ALL, $locale);
        $alias=iconv('UTF-8', 'ASCII//TRANSLIT', $alias);
        $alias=preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $alias);
        $alias=strtolower(trim($alias, '-'));
        $alias=preg_replace("/[\/_| -]+/", '-', $alias);
        trim($alias, '-');
        return $alias;
    }
    /**
     * @return RimoConfig
     */
    public static function getConfig()
    {
        return self::$_config;
    }
    /**
     * @return Smarty Smarty objektum.
     */
    public static function getSiteFrame()
    {
        return self::$_site_frame;
    }
    /**
     * Visszatér a betöltött controllerrel.
     * @return object
     */
    public static function getController()
    {
        return self::$_controller;
    }
    
    public static function setCache(\Uniweb\Library\Cache\CacheInterface $cache)
    {
        static::$cache = $cache;
    }
    
    public static function pimple(\Pimple\Container $pimple = null)
    {
        if ($pimple != null) {
            static::$pimple = $pimple;
        }
        return static::$pimple;
    }
}