<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 30.07.14
 * Time: 17:04
 */

namespace cox\backend\scoringModeller\helpers;


/**
 * Helper Numbers <br />
 * performs useful operations with numbers, <br />
 * or what is tend to be a number
 *
 * Class HN
 *
 * @package cox\backend\scoringModeller\helpers
 */
class HN {


	public static function integer($strInt){
		return filter_var($strInt, FILTER_VALIDATE_INT);
	}
}
