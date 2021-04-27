<?php

namespace app\controllers;

use core\App;

class MainUserCtrl {

    public function action_showUsersPage() {

        try {
            $records = App::getDB()->select("user",["[>]role" => "idrole"],["iduser","login","nazwa"]);
        } catch (\PDOException $ex) {
            getMessages()->addError("DB Error: ".$ex->getMessage());
        }
        App::getSmarty()->assign("page_title",'Panel zarządzania użytkownikami');
        App::getSmarty()->assign("lista",$records);
        App::getSmarty()->display('userspage.tpl');
    }

}