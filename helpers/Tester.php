<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 13.05.14
 * Time: 19:01
 */

namespace cox\backend\scoringModeller\helpers;


class Tester{


	public static function ec($str, $boolRetrieve = FALSE, $intLoopBack = 0){
		$strReturn = '';

		$intLoopBack ++;

		$arTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS&&!DEBUG_BACKTRACE_PROVIDE_OBJECT);

		$strReturn .= "\n";
		$strReturn .= $str;
		$strReturn .= "\n";
		$strReturn .= $arTrace[$intLoopBack - 1]['line'] . ":\t" . $arTrace[$intLoopBack]['function'] . ":\t" . $arTrace[$intLoopBack - 1]['file'] . "\n";

		if($boolRetrieve){
			return $strReturn;
		}else{
			echo $strReturn;
		}
	}


	public static function view($var, $strName = '', $boolRetrieve = FALSE, $boolWatchForDebugging = FALSE, $intLoopBack = 0){
		if(!$boolWatchForDebugging || (defined('RCM_DEBUGGING') && (RCM_DEBUGGING === TRUE))){

			$intLoopBack ++;

			$strReturn = '';

			$strType = gettype($var);
			$strVar = "\n" . 'variable ' . $strName . ' has type ' . $strType . ' end equals: ' . "\n";

			switch($strType){
				case 'boolean':
					if($var){
						$strVar .= 'TRUE';
					}else{
						$strVar .= 'FALSE';
					}
					break;

				case 'string':
					if(!$var){
						$strVar .= 'empty string';
					}else{
						$strVar .= "'" . $var . "'";
					}
					break;

				default:
					$strVar .= print_r($var, TRUE);
					break;
			}

			$strReturn .= self::ec($strVar, TRUE, $intLoopBack);

			if($boolRetrieve){
				return $strReturn;
			}else{
				echo $strReturn;
			}
		}

	}


	public static function arDebug(){
		$arReturn = array();
		$arDebug = debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT && DEBUG_BACKTRACE_IGNORE_ARGS);
		foreach($arDebug as $offset => $arEntry){
			$strTemp = $arEntry['class'] . ': '
						  . $arEntry['function'] . ': ';

			if(isset($arDebug[$offset - 1]) && isset($arDebug[$offset - 1]['line'])){
				$strTemp .= $arDebug[$offset - 1]['line'];
			}
			$arReturn[] = $strTemp;
		}

		return $arReturn;
	}


	public static function debug(){
		$arDebug = self::arDebug();
		$strReturn = '';

		$offset = 9;
		$arBacktrace = array_slice($arDebug, 2, -$offset);

		foreach($arBacktrace as $entry){
			$strReturn .= $entry . "\n";
		}

		return $strReturn;
	}


	public static function backtrace($depth = 5, $boolReturn = FALSE){
		$arBacktrace = debug_backtrace(2);

		$intFileNameMaxLength = 40;

		$strReturn = "\n";
		for($i = 0; $i < $depth; $i ++){
			if(isset($arBacktrace[$i]['file'])){
				$strFileName = basename($arBacktrace[$i]['file']);
				$intSpaces = $intFileNameMaxLength - strlen($strFileName);
				$strReturn .= $strFileName . ':' . str_repeat(' ', $intSpaces);
			}
			$strReturn .= isset($arBacktrace[$i - 1]['line']) ? $arBacktrace[$i - 1]['line'] . ': ' : '';
			$strReturn .= isset($arBacktrace[$i]['class']) ? HC::className($arBacktrace[$i]['class']) : '';
			$strReturn .= isset($arBacktrace[$i]['type']) ? $arBacktrace[$i]['type'] : '';
			$strReturn .= isset($arBacktrace[$i]['function']) ? $arBacktrace[$i]['function'] . '() ' : '';
			$strReturn .= "\n";
		}

		if($boolReturn){
			return $strReturn;
		}else{
			echo $strReturn;
		}
	}
}
