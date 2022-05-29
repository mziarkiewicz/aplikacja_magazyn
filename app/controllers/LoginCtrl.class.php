<?php

namespace app\controllers;

use core\App;
use core\SessionUtils;
use core\Utils;
use core\RoleUtils;
use core\ParamUtils;
use app\forms\LoginForm;
use core\Validator;

class LoginCtrl {

    public $form;
    public $lista;

    public function __construct() {
        $this->form = new LoginForm();
    }

    public function getLoginParams(){
        $this->form->login = ParamUtils::getFromRequest('login');
        $this->form->pass = ParamUtils::getFromRequest('pass');
    }

    public function validate() {

        if(!empty(SessionUtils::load("role", true))) return true;

        if(!$this->form->checkIsNull()) return false;

        $v = new Validator();
        $v->validate($this->form->login,[
            'trim' => true,
            'required' => true,
            'required_message' => 'Login jest wymagany',
            'min_length' => 3,
            'max_length' => 32,
            'validator_message' => 'Login powinien zawierać od 3 do 32 znaków'
        ]);

        $v->validate($this->form->pass,[
            'required' => true,
            'required_message' => 'Hasło jest wymagane',
        ]);

        if(App::getMessages()->isError()) return false;

        try{
            $this->lista = App::getDB()->get("user", [
                "[>]role" => ["idrole" => "idrole"]
            ],[
                'user.iduser',
                'user.login',
                'user.haslo',
                'role.nazwa',
            ],[
                'login' => $this->form->login,
                'haslo' => md5($this->form->pass)
            ]);

            if(empty($this->lista)){
                Utils::addErrorMessage("Nieprawidłowy login lub hasło");
            }
        }catch(\PDOException $e){
            Utils::addErrorMessage("Błąd połączenia z bazą danych");
        }

        if(!App::getMessages()->isError()) return true;
        else return false;
    }

    public function action_loginShow() {
        $this->generateView();
    }

    public function action_nopermission() {
        Utils::addErrorMessage('Dostęp do strony tylko dla zalogowanych uzytkowników');
        $this->generateView();
    }

    public function action_login() {
        if(!empty(SessionUtils::load("role", true))) App::getRouter()->redirectTo('showMainPage');
        $this->getLoginParams();
        $this->generateView();
    }

    public function action_logout() {
        session_destroy();
        RoleUtils::removeRole(SessionUtils::load("role"));
        SessionUtils::remove("login");
        SessionUtils::remove("role");
        App::getRouter()->redirectTo('');
    }

    public function generateView() {
        if ($this->validate()) {
            SessionUtils::store("login", $this->lista["login"]);
            SessionUtils::store("role", $this->lista["nazwa"]);
            RoleUtils::addRole($this->lista["nazwa"]);
            Utils::addInfoMessage('Poprawnie zalogowano do systemu');
            App::getRouter()->forwardTo("showMainPage");
        } else {
            App::getSmarty()->assign('form', $this->form);
            App::getSmarty()->display('LoginView.tpl');
        }
    }

}
