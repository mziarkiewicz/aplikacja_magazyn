<?php

namespace app\controllers;


use core\App;
use core\ParamUtils;
use core\Utils;

class SearchHintsCtrl
{
    public $column;
    public $value;
    public $hints;

    public function getParams(){
        $this->column = ParamUtils::getFromGet("column");
        $this->value= ParamUtils::getFromGet("value");
    }

    public function getFromDb(){
        try{
            $this->hints = array_unique(App::getDB()->select("przedmiot", $this->column,[
                $this->column.'[~]' => $this->value . '%',
                'LIMIT' => 5
            ]));
        }catch (\PDOException $e){
            Utils::addErrorMessage("Błąd połączenia z bazą danych!");
        }
    }

    public function showHints(){
        foreach($this->hints as $h){
            echo "<option value='".$h."'>";
        }
    }

    public function action_hint(){
        $this->getParams();
        $this->getFromDb();
        $this->showHints();
    }

}