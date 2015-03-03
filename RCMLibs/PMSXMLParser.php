<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 03.03.2015
 * Time: 11:50
 */

namespace RCMLibs;


use adaptors\FixFuckUps;
use adaptors\FootNote;
use adaptors\Unknown;
use base\bErroneous;
use helpers\Tester;
use interfaces\iParser;
use DOMDocument;
use DOMElement;
use DOMNodeList;

class PMSXMLParser extends bErroneous implements iParser{


	private $dom;


	private $parsed;


	private $table0;


	private $table1;


	private $table2;


	public function __construct($strPage){
		$this->dom = new DOMDocument();
//		$this->dom->preserveWhiteSpace = false;
		$this->dom->loadHTML($strPage);

		$this->parsed = array();
	}


	private function parseHeader(DOMNodeList $oRows){
		$arReturn = array();

		/**
		 * @type DOMElement $oHeader
		 */
		$oHeader = $oRows->item(0);

		$oProperties = $oHeader->getElementsByTagName('th');

		$intOffset = 0;
		while($intOffset < $oProperties->length){
			$arReturn[$intOffset] = $oProperties->item($intOffset)->nodeValue;

			$intOffset ++;
		}

		return $arReturn;
	}


	private function parseFirstTableBodyOffset(DOMNodeList $oRows, $intFirst, $intLast){
		$intRowOffset = 1;

		while($intRowOffset < $oRows->length){

			/**
			 * @type DOMElement $oRow
			 */
			$oRow = $oRows->item($intRowOffset);

			$oCells = $oRow->getElementsByTagName('td');

			for($i = $intFirst; $i < $intLast; $i ++){
				$this->parsed[$i]['values'][$intRowOffset - 1] =
					FootNote::remove($oCells->item($i)->nodeValue);
			}

			$intRowOffset ++;
		}

	}


	private function parseSubsequentTableBodyOffset(DOMNodeList $oRows, $intFirst, $intLast){
		$intRowOffset = 1;

		while($intRowOffset < $oRows->length){

			/**
			 * @type DOMElement $oRow
			 */
			$oRow = $oRows->item($intRowOffset);
			$oCells = $oRow->getElementsByTagName('td');

			$strSoftwareName = FixFuckUps::matchWare($oCells->item(0)->nodeValue);
			$intAddedRowOffset = $this->getRowOffsetBuySoftwareName($strSoftwareName);
			if($intAddedRowOffset !== false){
				$intColumnOffset = 1;

				for($i = $intFirst; $i < $intLast; $i ++){
					$this->parsed[$i]['values'][$intAddedRowOffset] =
						FootNote::remove($oCells->item($intColumnOffset)->nodeValue);
					$intColumnOffset ++;
				}
			}else{
				$this->addError('software "' . $strSoftwareName . '" not found');
			}

			$intRowOffset ++;
		}
	}


	private function getRowOffsetBuySoftwareName($strName){
		return array_search($strName, $this->parsed[0]['values']);
	}


	private function parseBody(DOMNodeList $oRows, $arHeader){
		$intFirstColumnOffset = count($this->parsed);

//	if parsed is empty, we wanna add all columns
//	else we want to add all, except first one
		$intFirstHeaderOffset = ($intFirstColumnOffset == 0) ? 0 : 1;

		$intLastHeaderOffset = count($arHeader);

		$intAddedColumnsCount = count($arHeader) - $intFirstHeaderOffset;
		$intLastColumnOffset = $intFirstColumnOffset + $intAddedColumnsCount;

//	adding new columns to parsed table
		for($i = $intFirstHeaderOffset; $i < $intLastHeaderOffset; $i ++){
			$this->parsed[] = array(
				'header' => $arHeader[$i],
				'values' => array(),
			);
		}

		if($intFirstColumnOffset == 0){
			$this->parseFirstTableBodyOffset($oRows, $intFirstColumnOffset, $intLastColumnOffset);
		}else{
			$this->parseSubsequentTableBodyOffset($oRows, $intFirstColumnOffset, $intLastColumnOffset);
		}

//		Tester::view($this->parsed, 'parsed');
	}


	private function parseTable($intOffset){

		/**
		 * @type DOMElement $oTable
		 */
		$oTable = $this->table{$intOffset};

		$oRows = $oTable->getElementsByTagName('tr');

		$arHeader = $this->parseHeader($oRows);

		$this->parseBody($oRows, $arHeader);

		Unknown::fill($this->parsed);

//		Tester::view($this->parsed, 'parsed');

	}


	public function parse(){
		$boolReturn = false;

		$oTables = $this->dom->getElementsByTagName('table');

		$intOffset = 0;
		while($intOffset < $oTables->length){
			$this->table{$intOffset} = $oTables->item($intOffset);
			$this->parseTable($intOffset);

			$intOffset ++;
		}

		if(!$this->hasErrors()){
			$boolReturn = true;
		}

		return $boolReturn;
	}


	public function getParsed(){
		return $this->parsed;
	}
}