<?php

namespace app\controllers;

use core\App;
use core\ParamUtils;
use core\Utils;

class MainCtrl {

    public $items;
    public $offset = 1;
    public $records = 5;

    public function getItemsFromDB() {
        try {
            $this->items = App::getDB()->select("przedmiot",["[>]pomieszczenie" => "idpomieszczenie","[>]dzial" => "iddzial"],"*",[
                'LIMIT' => [(($this->offset - 1) * $this->records), $this->records]
            ]);
        } catch (\PDOException $e) {
            Utils::addErrorMessage("Błąd połączenia z bazą danych!".$e->getMessage());
        }
    }

    public function checkIsNextPage(){
        try{
            $isNext = App::getDB()->has("przedmiot",[
                'LIMIT' => [(($this->offset) * $this->records), $this->records]
            ]);
        }catch(\PDOException $e){
            Utils::addErrorMessage("Błąd połączenia z bazą danych!");
        }

        return $isNext;
    }

    public function action_defaultPage(){
        App::getSmarty()->display('defaultpage.tpl');
    }

    public function action_showMainPage(){
        $offset = ParamUtils::getFromCleanURL(1);
        if(isset($offset) && is_numeric($offset) && $offset > 0) $this->offset += $offset - 1;
        if(isset($offset) && $offset == 0) $this->records = App::getDB()->count("przedmiot","*");
        $this->generateView();
    }

    public function generateView(){
        $this->getItemsFromDB();
        App::getSmarty()->assign("lista", $this->items);
        App::getSmarty()->assign("offset", $this->offset);
        App::getSmarty()->assign("isNextPage", $this->checkIsNextPage());
        App::getSmarty()->assign("next_page", $this->offset + 1);
        App::getSmarty()->assign("previous_page", $this->offset - 1);
        App::getSmarty()->assign("page_title", "Panel zarządzający");
        App::getSmarty()->display('mainpage.tpl');
    }


}

