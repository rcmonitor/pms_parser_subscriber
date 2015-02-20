<?php
/**
 * User: /@by_rcmonitor@/
 * Date: 08.02.2015
 * Time: 19:34
 */

namespace RCMLibs;

use RCMLibs\PMSParser;
use RCMLibs\AMQPPublisher;
use PhpAmqpLib\Message\AMQPMessage;

class PMSPageWorker {

	
	public static function perform(AMQPMessage $oMsg){
		
		echo 'got message' . "\n";

//		var_dump($strMsg);
//		die();
		
		$oParser = new PMSParser($oMsg->body);
		if($oParser->parse()){
			
			echo 'message successfully parsed' . "\n";
			
			$arParsed = $oParser->getParsed();
			$strJsonParsed = json_encode($arParsed);
			
			$oPublisher = new AMQPPublisher();
			$oPublisher->publish($strJsonParsed);
			$oPublisher = null;
		}
	}
}