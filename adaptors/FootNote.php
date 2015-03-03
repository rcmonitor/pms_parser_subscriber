<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 03.03.2015
 * Time: 23:41
 */

namespace adaptors;


class FootNote {


	public static function remove($strOrigin){
		$regExp = '/(\w+)(?:\s*\[.+\])/';
		return preg_replace($regExp, '$1', $strOrigin);
	}

}