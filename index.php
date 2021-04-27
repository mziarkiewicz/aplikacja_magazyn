<?php
require_once 'init.php';
use core\App;
//App::getSmarty()->display('mainpage.tpl');
header("Location: ". App::getConf()->app_url);