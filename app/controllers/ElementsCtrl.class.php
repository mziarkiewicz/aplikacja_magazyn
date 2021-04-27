<?php

namespace app\controllers;

use core\App;

class ElementsCtrl {

    public function action_elements() {
        App::getSmarty()->display('elements.tpl');
    }
}