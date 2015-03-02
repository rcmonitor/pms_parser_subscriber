<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 30.07.14
 * Time: 12:09
 */

namespace cox\backend\scoringModeller\helpers;
use cox\backend\core\AR;

/**
 * Helper Database <br />
 * performs useful operations for databases and tables
 *
 * Class HD
 *
 * @package cox\backend\scoringModeller\helpers
 */
class HD {

	static $transactionConst = 'TRANSACTION_IN_PROGRESS';


	public static function getDBMSName(\PDO $oPdo){
		return $oPdo->getAttribute(\PDO::ATTR_DRIVER_NAME);
	}


	public static function getColumnNames(\PDO $oPdo, $strTableName){
		$strQuery = '';
		$arReturn = array();

		$strDBMSName = self::getDBMSName($oPdo);

		switch ($strDBMSName){
			case 'pgsql':
				$strQuery = 'SELECT column_name FROM information_schema.columns WHERE table_name = :table_name';
				break;
		}

		if(!empty($strQuery)){
			$oPdoStatement = $oPdo->prepare($strQuery);

//			if(HT::debugging()){
//				Tester::view($strQuery, 'query from columns definition for ' . $strTableName);
//			}

			$oPdoStatement->bindParam(':table_name', $strTableName);
			if($oPdoStatement->execute()){
				$arReturn = $oPdoStatement->fetchAll(\PDO::FETCH_COLUMN);
			}
		}

		return $arReturn;
	}


	public static function prepareVariable($variable){
		$return = 'DEFAULT';

		if($variable === NULL){
			$return = 'NULL';
		}elseif(is_string($variable)){
			$return = "'" . $variable . "'";
		}elseif(is_integer($variable)){
			$return = $variable;
		}elseif($variable === TRUE){
			$return = 'TRUE';
		}elseif($variable === FALSE){
			$return = 'FALSE';
		}

		return $return;
	}


	/**
	 * starts transaction if possible (not started yet) <br />
	 * and remembers object that initiated it
	 *
	 * @param AR $oModel
	 *
	 * @return bool TRUE if transaction started <br />
	 *              FALSE otherwise
	 */
	public static function beginTransaction(AR $oModel){
		$boolStarted = FALSE;

		if(!self::inTransaction()){
			define(self::$transactionConst, spl_object_hash($oModel));
			if(!HT::pdo()->inTransaction()){
				$boolStarted = HT::pdo()->beginTransaction();
			}
		}

		return $boolStarted;
	}


	/**
	 * checks if we`re in transaction
	 *
	 * @return bool TRUE if we are <br />
	 *              FALSE otherwise
	 */
	public static function inTransaction(){
		return defined(self::$transactionConst);
	}


	/**
	 * commits transaction if object initiated commit <br />
	 * is same as object initiated transaction
	 *
	 * @param AR $oModel
	 *
	 * @return bool TRUE if transaction commited <br />
	 *              FALSE otherwise
	 */
	public static function commit(AR $oModel){
		$boolCommited = FALSE;

		if(self::inTransaction()){
			if(spl_object_hash($oModel) == constant(self::$transactionConst)){
				if($boolCommited = HT::pdo()->commit()){
					self::abortTransaction();
				}
			}

		}

		return $boolCommited;
	}


	/**
	 * rolls back transaction in progress, if any <br />
	 * any object may initiate rolling back
	 *
	 * @return bool TRUE if rolled back; <br />
	 *              FALSE otherwise
	 */
	public static function rollBack(){
		$boolRolledBack = FALSE;

		if(self::inTransaction()){
			if($boolRolledBack = HT::pdo()->rollBack()){
				self::abortTransaction();
			}

		}

		return $boolRolledBack;
	}


	private static function abortTransaction(){
		runkit_constant_remove(self::$transactionConst);
	}
}
