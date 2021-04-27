<?php

namespace core;

/**
 * Application - wrapper for fundamental objects and appliction initalization
 *
 * @author Przemysław Kudłacik
 */
class App {

    private static $config = null;
    private static $loader = null;
    private static $messages = null;
    private static $router = null;
    private static $smarty = null;
    private static $db = null;

    private function __construct() {
        
    }

    /**
     * Container of fundamental system objects and wrapper for access methods
     * 
     * @global type $_PARAMS
     * @param \core\Config $config Aplication configuration
     * @throws \Exception On missing or incorrect configuration 
     */
    public static function createAndInitialize(&$config) {

        if (!(isset($config) && $config instanceof Config)) {
            throw new \Exception('Configuration missing or incorrect');
        }
        
        //assign configuration and create fundamental objects
        self::$config = $config;
        require_once self::$config->root_path . '/core/ClassLoader.class.php';
        self::$loader = new ClassLoader($config);
        self::$messages = new Messages();
        self::$router = new Router($config);

        //start session and load roles
        session_start();
        self::$config->roles = isset($_SESSION['_amelia_roles']) ? unserialize($_SESSION['_amelia_roles']) : array();

        //load parameters from clean URL and load action
        if (self::$config->clean_urls) {
            $req_uri = $_SERVER['REQUEST_URI'];
            $len = strlen(self::$config->app_root);
            if ($len > 0) {
                if (substr($req_uri, 0, $len) == self::$config->app_root) {
                    $req_uri = substr($req_uri, $len);
                }                 
            }
            $req_uri = ltrim($req_uri,"/");
            $p = strpos($req_uri, "?");
            if ($p)
                $req_uri = substr($req_uri, 0, $p);#cut off query parameters
            global $_PARAMS;
            $_PARAMS = explode("/", $req_uri);
            //get action to perform from clean URL
            App::getRouter()->setAction(isset($_PARAMS[0]) ? $_PARAMS[0] : null );
        } else {
            //get action to perform from GET
            App::getRouter()->setAction(isset($_GET[self::$config->action_param]) ? $_GET[self::$config->action_param] : null );
        }        
    }

    /**
     * Returns class loader object
     * 
     * @return \core\ClassLoader class loader object
     */
    public static function &getLoader(): \core\ClassLoader {
        return self::$loader;
    }

    /**
     * Returns application configuration
     * 
     * @return \core\Config configuration object
     */
    public static function &getConf(): \core\Config {
        return self::$config;
    }

    /**
     * Returns system messages object
     * 
     * @return \core\Messages messages object
     */
    public static function &getMessages(): \core\Messages {
        return self::$messages;
    }

    /**
     * Assigns new Messages object as a main message container
     * 
     * @param \core\Messages $messages messages object to assign
     */
    public static function setMessages(&$messages) {
        if (!(isset($messages) && $messages instanceof Messages)) {
            throw new \Exception('Messages missing or incorrect');
        }
        self::$messages = $messages;
    }

    /**
     * Returns main router
     * 
     * @return \core\Router router object
     */
    public static function &getRouter(): \core\Router {
        return self::$router;
    }

    /**
     * Creates and returns Smatry templating engine.
     * Smarty object is created only once on first call.
     * 
     * @return \Smarty smarty object
     */
    public static function &getSmarty(): \Smarty {
        if (!isset(self::$smarty)) { //Create smarty and assign configuration and messages
            require_once self::$config->root_path . '/lib/smarty/Smarty.class.php';
            self::$smarty = new \Smarty();
            self::$smarty->assign('action', self::$router->getAction());
            self::$smarty->assign('conf', self::$config);
            self::$smarty->assign('msgs', self::$messages);
            self::$smarty->setTemplateDir(array(
                'one' => self::$config->root_path . '/app/views',
                'two' => self::$config->root_path . '/app/views/templates'
            ));
            if (file_exists(self::$config->root_path . '/app/onload_smarty.php')) {
                require_once self::$config->root_path . '/app/onload_smarty.php';
            }
        }
        return self::$smarty;
    }

    /**
     * Creates and returns Medoo object - PDO wrapper for easy database access.
     * Medoo object is created only once on first call.
     * 
     * @return \Medoo\Medoo medoo object
     */
    public static function &getDB(): \Medoo\Medoo {
        if (!isset(self::$db)) {
            require_once self::$config->root_path . '/lib/Medoo/Medoo.php';
            self::$db = new \Medoo\Medoo([
                'database_type' => self::$config->db_type,
                'server' => self::$config->db_server,
                'database_name' => self::$config->db_name,
                'username' => self::$config->db_user,
                'password' => self::$config->db_pass,
                'charset' => self::$config->db_charset,
                'port' => self::$config->db_port,
                'prefix' => self::$config->db_prefix,
                'option' => self::$config->db_option
            ]);
            if (file_exists(self::$config->root_path . '/app/onload_db.php')) {
                require_once self::$config->root_path . '/app/onload_db.php';
            }
        }
        return self::$db;
    }

}
