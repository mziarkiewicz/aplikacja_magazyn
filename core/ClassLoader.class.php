<?php

namespace core;

/**
 * Description of ClassLoader
 *
 * @author Przemysław Kudłacik
 */
class ClassLoader {

    public $paths = array();
    private $config = null;

    public function __construct(&$config) {
        if (!(isset($config) && $config instanceof Config)) {
            throw new \Exception('Configuration missing or incorrect');
        }
        $this->config = $config;
        spl_autoload_register(function($class) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $fileName = $this->config->root_path . DIRECTORY_SEPARATOR . $class . '.class.php';
            if (is_readable($fileName)) {
                require_once $fileName;
            }
        });
    }

    public function addPath($path) {
        $this->paths [] = $path;
        if (count($this->paths) == 1) {
            spl_autoload_register(function($class) {
                $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
                foreach ($this->paths as $path) {
                    $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
                    $fileName = $this->config->root_path . $path . DIRECTORY_SEPARATOR . $class . '.php';
                    if (is_readable($fileName)) {
                        require_once $fileName;
                    } else {
                        $fileName = $this->config->root_path . $path . DIRECTORY_SEPARATOR . $class . '.class.php';
                        if (is_readable($fileName)) {
                            require_once $fileName;
                        }
                    }
                }
            });
        }
    }

}
