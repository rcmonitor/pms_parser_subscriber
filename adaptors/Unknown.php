<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 03.03.2015
 * Time: 23:56
 */

namespace adaptors;


class Unknown {

	public static function fill(&$arParsed){
		$intColumnsCount = count($arParsed);
		$intRowsCount = count($arParsed[0]['values']);

		$intColumn = 1;
		while($intColumn < $intColumnsCount){
			$intRow = 0;
			while($intRow < $intRowsCount){

				if(!isset($arParsed[$intColumn]['values'][$intRow])){
					$arParsed[$intColumn]['values'][$intRow] = 'Unknown';
				}

				$intRow ++;
			}

			$intColumn ++;
		}

	}

}