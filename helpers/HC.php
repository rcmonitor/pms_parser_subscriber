<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 29.04.14
 * Time: 15:39
 */

namespace cox\backend\scoringModeller\helpers;

/**
 * Helper Class <br />
 * performs useful operations with classes and objects
 *
 * Class HC
 *
 * @package cox\backend\scoringModeller\helpers
 */
class HC {


	/**
	 * returns name of a class without namespace
	 *
	 * @param object|string $specie
	 *
	 * @return mixed|string
	 */
	public static function className($specie){
		$strReturn = '';
		$strName = '';
		if(is_object($specie)){
			$strName = get_class($specie);
		}elseif(is_string($specie)){
			$strName = $specie;
		}
		$arPath = explode('\\', $strName);
		$strReturn = end($arPath);

		return $strReturn;
	}


	/**
	 * returns array of classes that given class extends <br />
	 * without namespaces
	 *
	 * @param object|string $specie
	 *
	 * @return array
	 */
	public static function classParents($specie){
		$arExtendedClasses = array();
		if(is_object($specie) || is_string($specie)){
			$arExtendedClasses = array_keys(class_parents($specie));

			array_walk($arExtendedClasses, function(&$value, $key){
				$value = self::className($value);
			});
		}

		return $arExtendedClasses;
	}


	/**
	 * returns array of traits that given class uses <br />
	 * without namespaces
	 *
	 * @param object|string $specie
	 *
	 * @return array
	 */
	public static function classUses($specie){
		$arUsedClasses = array();
		if(is_object($specie) || is_string($specie)){
			$arUsedClasses = array_keys(class_uses($specie));

			array_walk($arUsedClasses, function(&$value, $key){
				$value = self::className($value);
			});
		}

		return $arUsedClasses;
	}


	/**
	 * returns array of interfaces that given class implements <br />
	 * without namespaces
	 *
	 * @param object|string $specie
	 *
	 * @return array
	 */
	public static function classImplements($specie){
		$arUsedClasses = array();
		if(is_object($specie) || is_string($specie)){
			$arUsedClasses = array_keys(class_implements($specie));

			array_walk($arUsedClasses, function(&$value, $key){
				$value = self::className($value);
			});
		}

		return $arUsedClasses;
	}


	/**
	 * checks if object is of given class <br />
	 * without namespaces
	 *
	 * @param $specie
	 * @param $name
	 *
	 * @return bool
	 */
	public static function objectIs($specie, $name){
		$boolReturn = FALSE;

		if($name == self::className($specie)){
			$boolReturn = TRUE;
		}elseif(self::className($name) == self::className($specie)){
			$boolReturn = TRUE;
		}
		return $boolReturn;
	}


	/**
	 * checks if given class extends, implements, or uses given className <br />
	 * without namespaces
	 *
	 * @param $specie
	 * @param $strClassName
	 *
	 * @return bool
	 */
	public static function classExtends($specie, $strClassName){
		$arExtended = array_merge(self::classParents($specie), self::classUses($specie), self::classImplements($specie));

		return in_array($strClassName, $arExtended);
	}
}
