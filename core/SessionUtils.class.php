<?php

namespace core;

/**
 * Wrapper for session tools
 *
 * @author Przemysław Kudłacik
 */
class SessionUtils {

    public static function store($name, $value) {
        if (isset($value)) {
            $_SESSION[$name] = $value;
        }
    }

    public static function load($name, $keep = false) {
        if (isset($_SESSION[$name])) {
            $r = $_SESSION[$name];
            if (!$keep)
                unset($_SESSION[$name]);
            return $r;
        }
        return null;
    }

    public static function storeMessages() {
        $_SESSION['_messages'] = serialize(App::getMessages());
    }

    public static function loadMessages($keep = false) {
        if (isset($_SESSION['_messages'])) {
            $msgs = unserialize($_SESSION['_messages']);
            App::setMessages($msgs);
            if (!$keep)
                unset($_SESSION['_messages']);
        }
    }

    public static function storeObject($name, &$object) {
        if (isset($object)) {
            $_SESSION[$name] = serialize($object);
        }
    }

    public static function loadObject($name, $keep = false) {
        if (isset($_SESSION[$name])) {
            $r = unserialize($_SESSION[$name]);
            if (!$keep)
                unset($_SESSION[$name]);
            return $r;
        }
        return null;
    }

    public static function storeData($name, &$data) {
        if (isset($data)) {
            $_SESSION[$name] = json_encode($data);
        }
    }

    public static function loadData($name, $keep = false) {
        if (isset($_SESSION[$name])) {
            $r = json_decode($_SESSION[$name]);
            if (!$keep)
                unset($_SESSION[$name]);
            return $r;
        }
        return null;
    }

    public static function remove($name) {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }

}
