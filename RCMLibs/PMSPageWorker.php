<?php
/**
 * User: /@by_rcmonitor@/
 * Date: 08.02.2015
 * Time: 19:34
 */

namespace RCMLibs;

use helpers\Tester;
use PhpAmqpLib\Channel\AMQPChannel;
use RCMLibs\PMSParser;
use RCMLibs\AMQPPublisher;
use PhpAmqpLib\Message\AMQPMessage;

class PMSPageWorker {


	private $channel;


	private static function getParser($strPage){
		return new PMSXMLParser($strPage);
	}


	public function __construct(AMQPChannel $channel){
		$this->channel = $channel;
	}

	
	public function perform(AMQPMessage $oMsg){
		
		echo 'got message' . "\n";

		$arDelivery = $oMsg->delivery_info;
//		Tester::view($arDelivery, 'delivery info');
//		Tester::view($oMsg, 'amqp message');

//		Tester::view($var, 'var');

		$oParser = self::getParser($oMsg->body);
		if($oParser->parse()){
			
			echo 'message successfully parsed' . "\n";
			
//			$arParsed = $oParser->getParsed();
//			$strJsonParsed = json_encode($arParsed);

			$arJSONParsed = $oParser->toJSON();
			
			$oPublisher = new AMQPPublisher();
			$oPublisher->publish($arJSONParsed);
			$oPublisher = null;

//			$this->channel->basic_ack($arDelivery['delivery_tag']);

			/**
			 * @type AMQPChannel $oChannel
			 */
			$oChannel = $arDelivery['channel'];
			$oChannel->basic_ack($arDelivery['delivery_tag']);
		}
	}
}