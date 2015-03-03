<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 14.08.14
 * Time: 15:53
 */

namespace helpers;


/**
 * Class HT
 * Helper Tests class
 * contains functions that may become useful while testing
 *
 * @package cox\backend\scoringModeller\helpers
 */
class HT {


//	public static $hosts = array(
//		'my' => '127.0.0.1',
//		'cox' => 'crm-dev.cox.ru',
//		'crm-calc' => 'crm-calc.cox.ru',
//	);
//
//
//	public static function getHost(){
//		return self::$hosts['my'];
//	}



//	public static function getConnectionParameters(){
//		$arParameters = array();
//		$arParameters['host'] = self::getHost();
//
//		$arParameters['database'] = 'crm';
//		$arParameters['user'] = 'crm';
//		$arParameters['password'] = 'crm';
//
////		$arParameters['database'] = 'crmcalc';
////		$arParameters['user'] = 'cox';
////		$arParameters['password'] = 'f#rfg346rf';
//
//		return $arParameters;
//	}


	/**
	 * outputs tester class header
	 */
	public static function header($strClassName){

		$intClassNameLength = strlen($strClassName);
		$intRepeats = (127 - $intClassNameLength) / 2;

		$strStars = str_repeat('*', $intRepeats);
		echo "\n" . $strStars . 'tests in ' . $strClassName . ' started' . $strStars . "\n";
	}


////	/**
////	 * @todo rcm if needed, convert into singleton pool, or dependency injection
////	 *
////	 * @param boolean $boolSecond whether to get second connection <br />
////	 *                            which is required for logging and/or <br/ >
////	 *                            maybe, some other needs
////	 *
////	 * @return \PDO
////	 */
////	public static function pdo($boolSecond = FALSE){
//////		return new \PDO('pgsql:host=localhost;dbname=crm', 'crm', 'crm');
////		static $connection = NULL;
////
////		static $secondConnection = NULL;
////
////		if($boolSecond){
////			if(NULL === $secondConnection){
//////				$arParameters = self::getConnectionParameters();
////
////				$secondConnection = self::newConnection();
////			}
////
////			return $secondConnection;
////		}else{
////			if(NULL === $connection){
////				$connection = self::newConnection();
////			}
////
////			return $connection;
////		}
//
////		if(NULL === $connection){
////
////			$arParameters = self::getConnectionParameters();
////
////			$connection = new \PDO('pgsql:host=' . $arParameters['host'] .
////								   ';dbname=' . $arParameters['database'],
////								   $arParameters['user'],
////								   $arParameters['password']);
////		}
////
////		return $connection;
//	}


//	private static function newConnection(){
//		$arParameters = self::getConnectionParameters();
//
//		$connection = new \PDO('pgsql:host=' . $arParameters['host'] .
//							   ';dbname=' . $arParameters['database'],
//							   $arParameters['user'],
//							   $arParameters['password']);
//
//		return $connection;
//	}



//	protected function __construct(){
//		return
//	}


	public static function debugging(){
		$boolDebugging = defined('RCM_DEBUGGING');

//		Tester::view($boolDebugging, 'debugging in HT class');

		return $boolDebugging;
	}


	public static function setDebugging(){
		define('RCM_DEBUGGING', TRUE);
	}


	public static function unsetDebugging(){
		if(self::debugging()){
			runkit_constant_remove('RCM_DEBUGGING');
		}
	}


	/**
	 * creates filtered data set for given tables/attributes
	 *
	 * @param \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection $oConnection
	 * @param array $arTables array of 'table_name' => array('filtered_attribute_1', ...);
	 *
	 * @return \PHPUnit_Extensions_Database_DataSet_DataSetFilter
	 */
	public static function getActualDataSet(\PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection $oConnection, $arTables){
		$oDataSet = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($oConnection);
		foreach($arTables as $strTableName => $arFilteredAttributes){
			$oDataSet->addTable($strTableName, 'SELECT * FROM ' . $strTableName);
		}

		$oDataSetFiltered = new \PHPUnit_Extensions_Database_DataSet_DataSetFilter($oDataSet, $arTables);

		return $oDataSetFiltered;
	}


	/**
	 * @fial
	 */
//	public static function assertDataSets($strExpectedFilePath, $arActualTables, \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection $oConnection){
//		$dsExpected = \PHPUnit_Extensions_Database_TestCase::create
////		\PHPUnit_Extensions_Database_TestCase::assertDataSetsEqual()
//	}
}
