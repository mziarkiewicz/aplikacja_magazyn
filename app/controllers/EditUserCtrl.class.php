<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use core\Validator;
use app\forms\EditUserForm;

class EditUserCtrl
{

    private $form;

    public function __construct()
    {
        $this->form = new EditUserForm();
    }

    /* Walidacja danych przed zapisem (nowe dane lub edycja).
     * Poniżej pełna, możliwa konfiguracja metod walidacji:
     *  [
     *    'trim' => true,
     *    'required' => true,
     *    'required_message' => 'message...',
     *    'min_length' => value,
     *    'max_length' => value,
     *    'email' => true,
     *    'numeric' => true,
     *    'int' => true,
     *    'float' => true,
     *    'date_format' => format,
     *    'regexp' => expression,
     *    'validator_message' => 'message...',
     *    'message_type' => error | warning | info,
     *  ]
     */
    public function validateSave()
    {
        $this->form->iduser = ParamUtils::getFromPost('iduser', true, 'Błędne wywołanie aplikacji');

        $v = new Validator();

        $this->form->login = $v->validateFromPost('login', [
            'trim' => true,
            'required' => true,
            'required_message' => 'Podaj nazwę użytkownika',
            'min_length' => 2,
            'max_length' => 20,
            'validator_message' => 'Login powinien mieć od 2 do 20 znaków'
        ]);

        $this->form->haslo = $v->validateFromPost('haslo', [
            'required' => true,
            'regexp' => "/(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,}/",
            'required_message' => 'Podaj hasło',
            'max_length' => 10,
            'validator_message' => 'Hasło powinno mieć od 5 do 10 znaków w tym jedną literę i jedną cyfrę'
        ]);

        $this->form->idrole = $v->validateFromPost('idrole', [
            'trim' => true,
            'required' => true,
            'required_message' => 'Wybierz uprawnienia dla użytkownika',
            'numeric' => true,
            'max_length' => 1,
            'validator_message' => 'Użytkownik powinien mieć przypisane uprawnienia zwykłe lub administracyjne'
        ]);

        $this->checkForDuplicates();

        return !App::getMessages()->isError();
    }

    public function validateEdit()
    {
        $this->form->iduser = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
        return !App::getMessages()->isError();
    }

    public function checkForDuplicates(){
        try{
            $record = App::getDB()->has('user',
                    ['login' => $this->form->login,
                        'iduser[!]' => $this->form->iduser
            ]);
            if($record){
                Utils::addErrorMessage("Użytkownik o podanej nazwie, istnieje już w bazie!");
                App::getRouter()->forwardTo('showUsersPage');
            }
        }catch(\PDOException $e){
            Utils::addErrorMessage("Wystąpił błąd połączenia z bazą danych");
        }
    }


    public function action_userAdd()
    {
        App::getSmarty()->assign('page_title','Dodaj użytkownika');
        App::getSmarty()->assign('page_description','Formularz umożliwiający dodanie użytkownika');
        App::getSmarty()->assign('form_description','Formularz dodawania użytkownika');
        $this->generateView();
    }

    public function action_userEdit()
    {
        if ($this->validateEdit()) {
            try {
                $record = App::getDB()->get("user", "*", [
                    "iduser" => $this->form->iduser
                ]);
                $this->form->iduser = $record['iduser'];
                $this->form->login = $record['login'];
                //$this->form->haslo = $record['haslo'];
                $this->form->idrole = $record['idrole'];
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas odczytu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        } else {
            App::getRouter()->forwardTo('showUsersPage');
        }
        App::getSmarty()->assign('page_title','Edytuj użtykownika');
        App::getSmarty()->assign('page_description','Formularz edycji - zmień login / hasło / uprawnienia dla użytkownika');
        App::getSmarty()->assign('form_description','Formularz edycji');
        $this->generateView();
    }

    public function action_userDelete()
    {
        if ($this->validateEdit()) {
            if($this->form->iduser == '1'){
                Utils::addErrorMessage('Nie można usunąć głównego administratora');
                App::getRouter()->forwardTo('showUsersPage');
            }
            try {
                App::getDB()->delete("user", [
                    "iduser" => $this->form->iduser
                ]);
                Utils::addInfoMessage('Pomyślnie usunięto użytkownika');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas usuwania rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        }
        App::getRouter()->forwardTo('showUsersPage');
    }

    public function action_userSave()
    {
        if ($this->validateSave()) {
            try {
                if ($this->form->iduser == '') {
                        App::getDB()->insert("user", [
                            "login" => $this->form->login,
                            "haslo" => md5($this->form->haslo),
                            "idrole" => $this->form->idrole,
                        ]);
                } else {
                    if($this->form->iduser == '1'){
                        if($this->form->idrole <> '1'){
                            Utils::addErrorMessage('Nie można zmienić uprawnień głównego administratora');
                            App::getRouter()->forwardTo('showUsersPage');
                        }
                    }
                    App::getDB()->update("user", [
                        "login" => $this->form->login,
                        "haslo" => md5($this->form->haslo),
                        "idrole" => $this->form->idrole,
                    ], [
                        "iduser" => $this->form->iduser
                    ]);
                }
                Utils::addInfoMessage('Pomyślnie zapisano użykownika');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił nieoczekiwany błąd podczas zapisu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
            App::getRouter()->forwardTo('showUsersPage');
        } else {
            App::getSmarty()->assign('page_title','Błędne dane');
            App::getSmarty()->assign('page_description','Wpisz poprawne: login / hasło / uprawnienia dla użytkownika');
            App::getSmarty()->assign('form_description','Formularz poprawy danych');
            $this->generateView();
        }
    }

    public function generateView()
    {
        App::getSmarty()->assign('form', $this->form);
        App::getSmarty()->display('formUser.tpl');
    }

}