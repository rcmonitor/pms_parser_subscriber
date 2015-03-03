<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 03.03.2015
 * Time: 23:10
 */

namespace base;


use interfaces\iErroneous;

class bErroneous implements iErroneous{


	private $errors = array();


	public function addError($strError){
		$this->errors[] = $strError;
	}


	public function hasErrors(){
		return !empty($this->errors);
	}


	public function getErrors(){
		return $this->errors;
	}

}