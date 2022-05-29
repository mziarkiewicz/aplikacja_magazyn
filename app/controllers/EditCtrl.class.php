<?php

namespace app\controllers;

use core\App;
use core\Utils;
use core\ParamUtils;
use core\Validator;
use app\forms\EditForm;

class EditCtrl
{

    private $form;

    public function __construct()
    {
        $this->form = new EditForm();
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
        $this->form->idprzedmiot = ParamUtils::getFromPost('idprzedmiot', true, 'Błędne wywołanie aplikacji');

        $v = new Validator();

        $this->form->nazwa = $v->validateFromPost('nazwa', [
            'trim' => true,
            'required' => true,
            'required_message' => 'Podaj nazwę urządzenia',
            'min_length' => 2,
            'max_length' => 20,
            'validator_message' => 'Nazwa powinna mieć od 2 do 20 znaków'
        ]);

        $this->form->producent = $v->validateFromPost('producent', [
            'trim' => true,
            'required' => true,
            'required_message' => 'Podaj producenta',
            'min_length' => 2,
            'max_length' => 20,
            'validator_message' => 'Producent powinien mieć od 2 do 20 znaków'
        ]);

        $this->form->modelurz = $v->validateFromPost('modelurz', [
            'trim' => true,
            'required' => true,
            'required_message' => 'Podaj model sprzętu',
            'min_length' => 2,
            'max_length' => 10,
            'validator_message' => 'Model powinien mieć od 2 do 10 znaków'
        ]);

        $this->form->typ = $v->validateFromPost('typ', [
            'trim' => true,
            'required' => true,
            'required_message' => 'Wpisz typ sprzętu',
            'min_length' => 2,
            'max_length' => 20,
            'validator_message' => 'Typ powinien mieć od 2 do 20 znaków'
        ]);

        $this->form->idpomieszczenie = $v->validateFromPost('idpomieszczenie', [
            'trim' => true,
            'required' => true,
            'int' => true,
            'required_message' => 'Podaj pomieszczenie, gdzie znajduje się urządzenie.',
            'min_length' => 1,
            'max_length' => 4,
            'validator_message' => 'Niepoprawnie wprowadzony identyfikator pomieszczenia'
        ]);

        return !App::getMessages()->isError();
    }

    public function validateEdit()
    {
        $this->form->idprzedmiot = ParamUtils::getFromCleanURL(1, true, 'Błędne wywołanie aplikacji');
        return !App::getMessages()->isError();
    }

    public function action_itemAdd()
    {
        App::getSmarty()->assign('page_title','Dodaj urządzenie');
        App::getSmarty()->assign('page_description','Formularz umożliwiający dodanie sprzętu do ewidencji');
        App::getSmarty()->assign('form_title','Formularz dodanie urządzenia');
        $this->generateView();
    }

    public function action_itemEdit()
    {
        if ($this->validateEdit()) {
            try {
                $record = App::getDB()->get("przedmiot", "*", [
                    "idprzedmiot" => $this->form->idprzedmiot
                ]);
                if(!is_null($record)) {
                    $this->form->idprzedmiot = $record['idprzedmiot'];
                    $this->form->nazwa = $record['nazwa'];
                    $this->form->producent = $record['producent'];
                    $this->form->modelurz = $record['model'];
                    $this->form->typ = $record['typ'];
                    $this->form->idpomieszczenie = $record['idpomieszczenie'];
                } else {
                    Utils::addErrorMessage('Wystąpił błąd podczas odczytu rekordu - brak podanego przedmiotu w bazie');
                }
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas odczytu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        } else {
            App::getRouter()->forwardTo('showMainPage');
        }
        App::getSmarty()->assign('page_title','Edytuj spis');
        App::getSmarty()->assign('page_description','Formularz edycji - Wprowadź zmiany we wpisie ewidencyjnym');
        App::getSmarty()->assign('form_title','Formularz edycji');
        $this->generateView();
    }

    public function action_itemDelete()
    {
        if ($this->validateEdit()) {
            try {
                App::getDB()->delete("przedmiot", [
                    "idprzedmiot" => $this->form->idprzedmiot
                ]);
                Utils::addInfoMessage('Pomyślnie usunięto rekord');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił błąd podczas usuwania rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
        } else {
            App::getRouter()->forwardTo('showMainPage');
        }
        App::getRouter()->redirectTo("showMainPage");
    }

    public function action_itemSave()
    {
        if ($this->validateSave()) {
            try {
                if ($this->form->idprzedmiot == '') {
                        App::getDB()->insert("przedmiot", [
                            "nazwa" => $this->form->nazwa,
                            "producent" => $this->form->producent,
                            "model" => $this->form->modelurz,
                            "typ" => $this->form->typ,
                            "idpomieszczenie" => $this->form->idpomieszczenie,
                        ]);
                } else {
                    App::getDB()->update("przedmiot", [
                        "nazwa" => $this->form->nazwa,
                        "producent" => $this->form->producent,
                        "model" => $this->form->modelurz,
                        "typ" => $this->form->typ,
                        "idpomieszczenie" => $this->form->idpomieszczenie,
                    ], [
                        "idprzedmiot" => $this->form->idprzedmiot
                    ]);
                }
                Utils::addInfoMessage('Pomyślnie zapisano rekord');
            } catch (\PDOException $e) {
                Utils::addErrorMessage('Wystąpił nieoczekiwany błąd podczas zapisu rekordu');
                if (App::getConf()->debug)
                    Utils::addErrorMessage($e->getMessage());
            }
            App::getRouter()->redirectTo('showMainPage');
        } else {
            App::getSmarty()->assign('page_title','Brak \ Błędnie wprowadzone dane');
            App::getSmarty()->assign('page_description','Proszę popraw dane w formularzu, a następnie zatwierdź ponownie');
            App::getSmarty()->assign('form_title','Formularz poprawy danych');
            $this->generateView();
        }
    }

    public function generateView()
    {
        App::getSmarty()->assign('form', $this->form);
        App::getSmarty()->display('formItem.tpl');
    }

}