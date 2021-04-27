<?php namespace core;
class Config extends \ArrayObject{
	public $debug=false;
	public $clean_urls=false;
	public $root_path;
	public $server_name;
	public $protocol;
	public $server_url;
	public $app_root;
	public $app_url; 
	public $action_param;
	public $action_script;
	public $action_root;
	public $action_url;
	public $roles;
	public $db_type;
	public $db_server;
	public $db_port;
	public $db_name;
	public $db_user;
	public $db_pass;
	public $db_charset;
	public $db_prefix;
	public $db_option;
}