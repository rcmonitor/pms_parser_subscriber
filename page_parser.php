<?php
/**
 * User: /@by_rcmonitor@/
 * Date: 08.02.2015
 * Time: 14:36
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/RCMLibs/ClassLoader.php';


use RCMLibs\AMQPConsumer;

$oConsumer = new AMQPConsumer();

$oConsumer->consume();












//use PhpAmqpLib\Connection\AMQPConnection;
//use PhpAmqpLib\Message\AMQPMessage;
//use RCMLibs\PMSParser;
//
//$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
//$channel = $connection->channel();
//
//$channel->exchange_declare('parser_exchange', 'topic', true, false, false);
//$channel->queue_declare('parser_queue', false, true, true, false);
//
//$callback = function($msg){
//	$oParser = new PMSParser($msg);
//	if($oParser->parse()){
//		$arParsed = $oParser->getParsed();
//		
////		new AMQPConnection();
//
////		$channel->exchange_declare('parser_income_exchange', 'topic', true, false, false);
////		$channel->queue_declare('parser_income_queue', false, true, true, false);
//		
//
//		$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
//	}
//};
