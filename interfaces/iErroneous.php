<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 03.03.2015
 * Time: 23:10
 */

namespace interfaces;


interface iErroneous {


	public function addError($error);


	public function hasErrors();


	public function getErrors();
}