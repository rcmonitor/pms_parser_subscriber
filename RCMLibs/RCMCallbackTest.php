<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 17.02.2015
 * Time: 11:32
 */

namespace RCMLibs;


class RCMCallbackTest {


	public static function work($strParam){
		echo __CLASS__ . '::' . __FUNCTION__ . ' fired with ' . $strParam . PHP_EOL;
	}
}