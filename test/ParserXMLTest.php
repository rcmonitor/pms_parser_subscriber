<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 03.03.2015
 * Time: 12:43
 */

namespace test;

use helpers\HT;
use PHPUnit_Framework_TestCase;
use RCMLibs\PMSXMLParser;

class ParserXMLTest extends PHPUnit_Framework_TestCase{


//	private $pagePath;

	private $page;


	public static function setUpBeforeClass(){
		HT::header(__CLASS__);
	}


	public function setUp(){

		$strPagePath = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'page.html';

		$this->page = file_get_contents($strPagePath);
	}


	public function testTables(){
		$oParser = new PMSXMLParser($this->page);

		$oParser->parse();

		$this->assertEquals(1,1, 'not');
	}

}