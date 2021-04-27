<?php

/*
 * The script automatically executed when getSmarty() is called for the first time.
 * Use it to setup the engine or pass additional variables that are always needed.
 */
function url($params, $smarty)
{
  $action = '';
  if (isset($params['action'])){
      $action = $params['action'];
      unset($params['action']);
  }
  return \core\Utils::URL($action, $params);
}

function rel_url($params, $smarty)
{
  $action = '';
  if (isset($params['action'])){
      $action = $params['action'];
      unset($params['action']);
  }
  return \core\Utils::relURL($action, $params);
}

\core\App::getSmarty()->registerPlugin("function","url", "url");
\core\App::getSmarty()->registerPlugin("function","rel_url", "rel_url");

#assign variables
#\core\App::getSmarty()->assign('variable',$variable);
