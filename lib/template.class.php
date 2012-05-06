<?php

/*
	template class, where templates get "rendered"

	06/05/12	Starting this. Don't think much will be added here.
			Actually, just try to keep this page light! [janith]

*/

class template {

	protected $vars = array();

	public function render($tempfile) {

		include_once('./templates/' . $tempfile);
	}

	public function __set($name, $value) {

		$this->vars[$name] = $value;
	}

	public function __get($name) {

		return $this->vars[$name];
	}
}

?>
