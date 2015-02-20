<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 17.02.2015
 * Time: 11:30
 */

namespace RCMLibs;


class RCMNameTest {


	private $callback;


	public function __construct(){
		$this->callback = array('RCMLibs\RCMCallbackTest', 'work');
	}


	public function doTest(){
		call_user_func($this->callback, 'some_string');
	}
}