<?php
/**
 * User: /@by_rcmonitor@/
 * Date: 08.02.2015
 * Time: 14:50
 */

namespace RCMLibs;

class PMSParser {

	/**
	 * @var string
	 */
	private $page;


	/**
	 * @var array
	 */
	private $parsed;


	private $firstHeaderRE;


	private function setFirstHeaderRE(){
		$this->firstHeaderRE = '/(?:^<th>(?:<[^>]+>)*?'
		. '(:<property>[a-zA-Z\\-\\s]+)'
		. '(?:<[^>]+>)*?<\\/th>\r?\n?)/';

	}


	public function __construct($strPage){
		$this->page = $strPage;

		$this->setFirstHeaderRE();

	}


	public function parse(){
		$boolReturn = false;

		$arMatches = array();

		$intParsed = preg_match_all($this->firstHeaderRE, $this->page, $arMatches);

		if($intParsed !== false){
			$this->parsed = $arMatches;
			$boolReturn = true;
		}

		var_dump($this->parsed);

		return $boolReturn;
	}


	/**
	 * @return array
	 */
	public function getParsed(){
		return $this->parsed;

	}
}