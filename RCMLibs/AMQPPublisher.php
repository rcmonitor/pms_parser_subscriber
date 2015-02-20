<?php
/**
 * User: /@by_rcmonitor@/
 * Date: 08.02.2015
 * Time: 16:04
 */

namespace RCMLibs;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;


class AMQPPublisher {


	/**
	 * @var string
	 */
	private $queueName;


	/**
	 * @var string
	 */
	private $exchangeName;


	/**
	 * @var string
	 */
	private $routingKey;


	/**
	 * @var AMQPConnection
	 */
	private $connection;


	private $connectionProperties;


	private $exchangeProperties;


	private $queueProperties;

	
	public function __construct(){

		$this->initProperties();

		$this->connection = new AMQPConnection(...array_values($this->connectionProperties));
		
	}


	private function initProperties(){
		$this->exchangeName = 'parser_exchange';
		$this->queueName = 'parser_outgoing_queue';
		$this->routingKey = 'parser.out';

		$this->connectionProperties = array(
			  'host' => 'localhost'
			, 'port' => 5672
			, 'user' => 'guest'
			, 'password' => 'guest'
		);

		$this->exchangeProperties = array(
			  'exchangeName' => $this->exchangeName
			, 'type' => 'topic'
			, 'passive' => true
			, 'durable' => false
			, 'auto_delete' => false
			, 'internal' => false
			, 'nowait' => false
			, 'arguments' => null
			, 'ticket' => null
		);

		$this->queueProperties = array(
			  'name' => $this->queueName
			, 'passive' => false
			, 'durable' => true
			, 'exclusive' => true
			, 'auto_delete' => false
			, 'nowait' => false
			, 'arguments' => null
			, 'ticket' => null
		);

	}
	
	
	public function publish($strMsg){
		$channel = $this->connection->channel();
		$channel->exchange_declare(...array_values($this->exchangeProperties));
		$channel->queue_declare(...array_values($this->queueProperties));
		
		$channel->queue_bind($this->queueName, $this->exchangeName, $this->routingKey);

		$oMsg = new AMQPMessage($strMsg, array(
			'delivery_mode' => 2
		));
		
		$channel->basic_publish($oMsg, $this->exchangeName, $this->routingKey);
		
		echo 'message published to ' . $this->routingKey . "\n";

		$channel->close();
	}
	
	
	public function __destruct(){
		$this->connection->close();
	}
}