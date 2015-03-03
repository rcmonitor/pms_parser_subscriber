<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 03.03.2015
 * Time: 9:27
 */

namespace test;

use helpers\Tester;
use helpers\HT;
use PHPUnit_Framework_TestCase;
use RCMLibs\PMSParser;


class ParserShortTest extends PHPUnit_Framework_TestCase{


	private $strPagePath;


	public static function setUpBeforeClass(){
		HT::header(__CLASS__);
	}


	public function setUp(){
		$this->strPagePath = __DIR__
			. DIRECTORY_SEPARATOR . 'data'
			. DIRECTORY_SEPARATOR . 'short_page.html';
	}


	public function testShort(){
		$strShortPage = file_get_contents($this->strPagePath);

//		Tester::view($strShortPage, 'super short page');

		$oParser = new PMSParser($strShortPage);

		$boolParsed = $oParser->parse();
		$this->assertTrue($boolParsed, 'failed to parse');

		$arParsed = $oParser->getParsed();
		$this->assertInternalType('array', $arParsed, 'parsed is not an array');
		$this->assertNotEmpty($arParsed, 'parsed array is empty');
		$this->assertNotEmpty($arParsed[0], 'nothing found');

//		Tester::view($arParsed, 'parsed array');
	}
}