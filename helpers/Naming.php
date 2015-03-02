<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 29.04.14
 * Time: 18:31
 */

namespace cox\backend\scoringModeller\helpers;


use cox\backend\scoringModeller\facility\Attribute;

class Naming{


	/**
	 * generates unique system name
	 *
	 * @return string
	 */
	public static function system(){
		return md5(time() . microtime() . mt_rand(0, 100500));
//		return md5($oAttribute->parentName . '.' . $oAttribute->name . )
	}


	/**
	 * checks that string given is a system name
	 *
	 * @param $strName
	 *
	 * @return bool
	 */
	public static function isName($strName){
		return (strlen($strName) == 32) && ctype_xdigit($strName);
	}


	public static function full($oSpecie){
		if(HC::classExtends($oSpecie, 'tNamed') && HC::classExtends($oSpecie, 'tNamedChild')){
			return $oSpecie->getParentName() . '.' . $oSpecie->getName();
		}
	}


	/**
	 * gives back full name if entity name is given; <br />
	 * or, attribute name if not
	 *
	 * @param string $strName
	 * @param string $strEntity
	 *
	 * @return string
	 */
	public static function getFull($strName, $strEntity = ''){
		return empty($strEntity) ? $strName : $strEntity . '.' . $strName;
	}


	public static function error($error){
		return md5($error);
	}
}
