<?php namespace core;
require_once 'Message.class.php';
class Messages {
	private $m = array ();
	private $n = 0;
	private $nerr = 0;
	private $nwar = 0;
	private $ninf = 0;

	public function addMessage($message,$index = null) { 
		if ($index!=null) $this->m[$index] = $message; else $this->m[] = $message;
		$this->n++;
		switch ($message->type) {
			case Message::ERROR: $this->nerr++; break;
			case Message::WARNING: $this->nwar++; break;
			case Message::INFO: $this->ninf++; break;
		}
	}
	public function isEmpty() { return $this->n == 0; }
	public function isError() { return $this->nerr > 0; }
	public function isWarning() { return $this->nwar > 0; }
	public function isInfo() { return $this->ninf > 0; }
	public function isMessage($index=null) { if ($index!=null) return isset($this->m[$index]); else return $this->n > 0;}

	public function getMessage($index) { return $this->m[$index]; }
	public function getMessages() { return $this->m; }
	public function getSize() { return $this->n; }	
	public function getNumberOfErrors() { return $this->nerr; }	
	public function getNumberOfWarnings() { return $this->nwar; }	
	public function getNumberOfInfos() { return $this->ninf; }	
	
	public function clear() {
		$this->m = array ();
		$this->n = 0;
		$nerr = 0;
		$nwar = 0;
		$ninf = 0;
	}
}