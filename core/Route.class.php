<?php namespace core;
class Route{
	public $namespace = null;
	public $controller = null;
	public $method = null;
	public $roles = null;
	public function __construct($namespace,$controller,$method,$roles){
		$this->namespace = $namespace;
		$this->controller = $controller;
		$this->method = $method;
		$this->roles = $roles;
	}
}