<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 30.07.14
 * Time: 12:37
 */

namespace cox\backend\scoringModeller\helpers;


/**
 * Helper String <br />
 * performs useful operations with strings
 *
 * Class HS
 *
 * @package cox\backend\scoringModeller\helpers
 */
class HS {


	public static function camelToSnake($strCamel){
		return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $strCamel));
	}


	public static function snakeToCamel($strSnake){
		return preg_replace_callback('/([a-z])_([a-z])/', function($arMatches){
			return $arMatches[1] . strtoupper($arMatches[2]);
		}, strtolower($strSnake));
	}
}
