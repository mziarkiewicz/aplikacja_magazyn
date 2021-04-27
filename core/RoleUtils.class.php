<?php

namespace core;

/**
 * Wrapper class for role utility functions
 *
 * @author Przemysław Kudłacik
 */
class RoleUtils {

    public static function addRole($role) {
        App::getConf()->roles [$role] = true;
        $_SESSION['_amelia_roles'] = serialize(App::getConf()->roles);
    }

    public static function removeRole($role) {
        if (isset(App::getConf()->roles [$role])) {
            unset(App::getConf()->roles [$role]);
            $_SESSION['_amelia_roles'] = serialize(App::getConf()->roles);
        }
    }

    public static function inRole($role) {
        return isset(App::getConf()->roles[$role]);
    }

    public static function requireRole($role, $fail_action = null) {
        if (!self::inRole($role)) {
            if (isset($fail_action))
                App::getRouter()->forwardTo($fail_action);
            else
                App::getRouter()->forwardTo(App::getRouter()->getLoginRoute());
        }
    }

}
