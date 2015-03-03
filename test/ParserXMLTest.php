<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 03.03.2015
 * Time: 12:43
 */

namespace test;

use helpers\HT;
use helpers\Tester;
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

		$boolParsed = $oParser->parse();
		$this->assertTrue($boolParsed, 'failed to parse');

		$boolHasErrors = $oParser->hasErrors();

		$arErrors = $oParser->getErrors();
		$this->assertEmpty($arErrors, 'errors not empty');

		$this->assertFalse($boolHasErrors, 'got some errors while parsing');

		$arParsed = $oParser->getParsed();
		$this->assertInternalType('array', $arParsed, 'parsed is not an array');
		$this->assertNotEmpty($arParsed, 'parsed array is empty');
		$this->assertCount(17, $arParsed, 'wrong amount of columns in parsed array');

		$intRowsCount = null;

		foreach ($arParsed as $intColumnOffset => $arColumn) {
			$this->assertThat($arColumn, $this->arrayHasKey('header'), 'no header for column #' . $intColumnOffset);
			$this->assertThat($arColumn, $this->arrayHasKey('values'), 'no values for column #' . $intColumnOffset);
			if($intColumnOffset == 0){
				$intRowsCount = count($arColumn['values']);
			}
			$this->assertCount($intRowsCount, $arColumn['values']);
		}

	}

}