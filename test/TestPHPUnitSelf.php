<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 02.03.2015
 * Time: 12:20
 */

use helpers\HT;

class TestPHPUnitSelf extends PHPUnit_Framework_TestCase{


	public static function setUpBeforeClass(){
		HT::header(__CLASS__);
	}


	public function testOne(){
		$this->assertEquals(1, 1, 'one isn`t one');
	}

}