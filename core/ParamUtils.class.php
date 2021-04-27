<?php

namespace core;

use core\Message;

/**
 * Wrapper for basic parameter utils
 *
 * @author Przemysław Kudłacik
 */
class ParamUtils {

    private static function getFrom(&$source, &$idx, &$required, &$required_message, &$index) {
        if ($required && !isset($source[$idx]))
            App::getMessages()->addMessage(new Message($required_message, Message::ERROR), $index);
        if (isset($source[$idx]))
            return $source[$idx];
        return null;
    }

    public static function getFromCleanURL($param_idx, $required = false, $required_message = null, $index = null) {
        global $_PARAMS;
        return self::getFrom($_PARAMS, $param_idx, $required, $required_message, $index);
    }

    public static function getFromRequest($param_name, $required = false, $required_message = null, $index = null) {
        return self::getFrom($_REQUEST, $param_name, $required, $required_message, $index);
    }

    public static function getFromGet($param_name, $required = false, $required_message = null, $index = null) {
        return self::getFrom($_GET, $param_name, $required, $required_message, $index);
    }

    public static function getFromPost($param_name, $required = false, $required_message = null, $index = null) {
        return self::getFrom($_POST, $param_name, $required, $required_message, $index);
    }

    public static function getFromCookies($param_name, $required = false, $required_message = null, $index = null) {
        return self::getFrom($_COOKIE, $param_name, $required, $required_message, $index);
    }

    public static function getFromSession($param_name, $required = false, $required_message = null, $index = null) {
        return self::getFrom($_SESSION, $param_name, $required, $required_message, $index);
    }

}
