<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 14.05.14
 * Time: 17:05
 */

namespace cox\backend\scoringModeller\helpers;

/**
 * Helper Arrays <br />
 * performs useful operations with arrays
 *
 * Class HA
 *
 * @package cox\backend\scoringModeller\helpers
 */
class HA{


	/**
	 * checks if given array is a sequential indexed
	 *
	 * @param $array
	 *
	 * @return bool TRUE if it is; <br />
	 *              FALSE otherwise
	 */
	public static function isIndexed($array){
		return array_keys($array) === range(0, count($array) - 1);
	}


	/**
	 * traverses named parameters from source array to given <br />
	 *
	 * @param array $arTarget where to traverse to
	 * @param array $arSource where to traverse from
	 * @param array $arNames which parameters to traverse
	 * @param array $arRequired if passed, only really required parameters causes return FALSE <br />
	 *                          others filled with default value, if empty
	 * @param mixed $defaultValue value to set as default, when empty
	 *
	 * @return bool TRUE if all required parameters traversed; <br />
	 *              FALSE otherwise
	 */
	public static function traverseParameters(&$arTarget, $arSource, $arNames, $arRequired = array(), $defaultValue = NULL){

		$boolTraversed = FALSE;

		$arRequired = empty($arRequired) ? $arNames : $arRequired;

		if(!empty($arNames)){
			$boolTraversed = TRUE;

			foreach($arNames as $strName){
				if(isset($arSource[$strName])){
					$arTarget[$strName] = $arSource[$strName];
				}else{
					if(in_array($strName, $arRequired)){
						$boolTraversed = FALSE;
					}else{
						$arTarget[$strName] = $defaultValue;
					}
				}

			}

		}

		return $boolTraversed;
	}

}
