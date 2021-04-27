<?php

namespace app\controllers;

use app\forms\SearchForm;
use core\App;
use core\ParamUtils;
use core\Utils;

class SearchCtrl {
    public $form;
    public $where = [];
    public $search_params = [];
    public $query;

    public function __construct(){
        $this->form = new SearchForm();
    }

    public function getParams(){
        $this->form->nazwa = ParamUtils::getFromGet("nazwa");
        $this->form->producent = ParamUtils::getFromGet("producent");
        $this->form->modelurz = ParamUtils::getFromGET('modelurz');
        $this->form->iddzial = ParamUtils::getFromGET('iddzial');
    }

    public function validate(){
        if(!empty($this->form->nazwa)) $this->where['nazwa[~]'] = $this->form->nazwa . '%';
        if(!empty($this->form->producent)) $this->where['producent[~]'] = '%' .$this->form->producent . '%';
        if(!empty($this->form->modelurz)) $this->where['model[~]'] = $this->form->modelurz . '%';
        if(!empty($this->form->iddzial)) $this->where['iddzial'] = $this->form->iddzial;
        $this->where['LIMIT'] = 20;

        $num_params = sizeof($this->where);
        if ($num_params > 1) {
            $this->search_params = ["AND" => &$this->where];
        } else {
            $this->search_params = &$this->where;
        }

        if(empty($this->where)) Utils::addErrorMessage("Brak kryteriów wyszukiwania!");

        if(!App::getMessages()->isError()) return true;
        else return false;
    }

    public function queryToDB(){
        $this->where['LIMIT'] = 10;

        try{
            $this->query = App::getDB()->select("przedmiot",["[>]pomieszczenie" => "idpomieszczenie","[>]dzial" => "iddzial"],"*", $this->where);
        }catch(\PDOException $e){
            Utils::addErrorMessage("Błąd połączenia z bazą danych");
        }
    }

    public function generateView(){
        App::getSmarty()->assign("page_title", "Wyszukiwarka");
        App::getSmarty()->assign("query", $this->query);
        App::getSmarty()->display("resultsView.tpl");
    }

    public function action_search(){
        $this->getParams();
        if($this->validate()){
            $this->queryToDB();
        }
        $this->generateView();
    }

}