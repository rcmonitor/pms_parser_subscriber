<?php
/**
 * User: //@by_rcmonitor@//
 * Date: 04.03.2015
 * Time: 0:36
 */

namespace adaptors;


class FixFuckUps {


	public static function matchWare($strSoftwareName){
		if($strSoftwareName == 'MatchWare MindView 4 Business Edition'){
			return 'MatchWare MindView 5 Business Edition';
		}

		return $strSoftwareName;
	}

}