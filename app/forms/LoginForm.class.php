<?php

namespace app\forms;

class LoginForm {
    public $login;
    public $pass;

    function checkIsNull() {
        foreach ($this as $key => $value) {
            if(!isset($value)) return false;
            else return true;
        }
    }

}