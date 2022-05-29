<?php

use core\App;
use core\Utils;

App::getRouter()->setDefaultRoute('defaultPage'); #default action
App::getRouter()->setLoginRoute('nopermission');
//App::getRouter()->setLoginRoute('login'); #action to forward if no permissions

Utils::addRoute('defaultPage', 'MainCtrl');
Utils::addRoute('nopermission','LoginCtrl');
Utils::addRoute('showMainPage', 'MainCtrl',['admin','user']);
Utils::addRoute('login', 'LoginCtrl');
Utils::addRoute('logout', 'LoginCtrl');

Utils::addRoute('itemView','ViewItemCtrl',['admin','user']);
Utils::addRoute('itemAdd', 'EditCtrl',['admin','user']);
Utils::addRoute('itemSave', 'EditCtrl',['admin','user']);
Utils::addRoute('itemEdit', 'EditCtrl',['admin','user']);
Utils::addRoute('itemDelete', 'EditCtrl',['admin','user']);

Utils::addRoute('userAdd', 'EditUserCtrl',['admin']);
Utils::addRoute('userEdit', 'EditUserCtrl',['admin']);
Utils::addRoute('userSave', 'EditUserCtrl',['admin']);
Utils::addRoute('userDelete', 'EditUserCtrl',['admin']);
Utils::addRoute('showUsersPage', 'MainUserCtrl',['admin']);

Utils::addRoute('contact', 'FormContactCtrl',['admin','user']);
Utils::addRoute('messageSend', 'FormContactCtrl',['admin','user']);

Utils::addRoute('search', 'SearchCtrl');
Utils::addRoute('hint', 'SearchHintsCtrl');

//Utils::addRoute('elements', 'ElementsCtrl');

//Utils::addRoute('action_name', 'controller_class_name');