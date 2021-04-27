<?php
require_once 'init.php';

require_once 'routing.php';

\core\SessionUtils::loadMessages();

\core\App::getRouter()->go();