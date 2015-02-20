<?php
/**
 * User: /@by_rcmonitor@/
 * Date: 08.02.2015
 * Time: 22:44
 */

namespace RCMLibs;


class ClassLoader {

	
	public static function load($strClassName){
		
		$arPath = explode('\\', $strClassName);
		$strPath = implode(DIRECTORY_SEPARATOR, $arPath);
		
		$strFullPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . $strPath . '.php';

		if(file_exists($strFullPath)){
			require_once($strFullPath);
		}
	}
	
}


spl_autoload_register(array('\RCMLibs\ClassLoader', 'load'));