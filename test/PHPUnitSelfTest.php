<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 02.03.2015
 * Time: 12:20
 */


namespace test;

use helpers\HT;
use PHPUnit_Framework_TestCase;

class PHPUnitSelfTest extends PHPUnit_Framework_TestCase{


	public static function setUpBeforeClass(){
		HT::header(__CLASS__);
	}


	public function testOne(){
		$this->assertEquals(1, 1, 'one isn`t one');
	}

}