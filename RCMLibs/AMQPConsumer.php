<?php
/**
 * User: /@by_rcmonitor@/
 * Date: 08.02.2015
 * Time: 19:19
 */

namespace RCMLibs;

use PhpAmqpLib\Connection\AMQPConnection;

class AMQPConsumer {
	
	
	const CONNECTION_PARAMETERS = [
		'rabbit' => ['localhost', 5672, 'guest', 'guest']
		, 'apollo' => ['localhost', 61613, 'admin', 'password']
	];
	
	
	private $exchangeName;
	
	
	private $queueName;
	
	
	private $routingKey;
	
	
	private $consumeProperties;
	
	
	private $exchangeProperties;
	
	
	private $queueProperties;
	
	
	private $connection;
	
	
	private $timer;

	
	public function __construct(){
		
		$this->timer = new Timer(true, __CLASS__ . ' constructed');

		$this->initParameters();

		$this->connection = new AMQPConnection(...self::CONNECTION_PARAMETERS['rabbit']);
		
		$this->timer->lap('connected');
	}


	private function initParameters(){

		$this->exchangeName = 'parser_exchange';
		$this->queueName = 'parser_queue';
		$this->routingKey = 'parser.in';

		$this->exchangeProperties = array(
			'exchange' => $this->exchangeName
		, 'type' => 'topic'
		, 'passive' => false
		, 'durable' => true
		, 'auto_delete' => false
		, 'internal' => false
		, 'nowait' => false
		, 'arguments' => null
		, 'ticket' => null
		);

		$this->queueProperties = array(
			'queue' => $this->queueName
		, 'passive' => false
		, 'durable' => true
		, 'exclusive' => false
		, 'auto_delete' => false
		, 'nowait' => false
		, 'arguments' => null
		, 'ticket' => null
		);

		$this->consumeProperties = array(
			'queue' => $this->queueName
		, 'consumer_tag' => $this->routingKey
		, 'no_local' => false
		, 'no_acknowledge' => false
		, 'exclusive' => false
		, 'nowait' => false
		, 'callback' => array('RCMLibs\PMSPageWorker', 'perform')
		, 'ticket' => null
		, 'arguments' => array()
		);

	}
	
	
	public function consume(){
		$channel = $this->connection->channel();
		$this->timer->lap('got new channel');
		$channel->exchange_declare(...array_values($this->exchangeProperties));
		$this->timer->lap('got exchange');
		$channel->queue_declare(...array_values($this->queueProperties));
		$this->timer->lap('got queue');

		$channel->queue_bind($this->queueName, $this->exchangeName, $this->routingKey);


		echo 'waiting for messages' . "\n";
		
		$channel->basic_consume(...array_values($this->consumeProperties));
		$this->timer->lap('channel subscribed');

		while(count($channel->callbacks)) {
			$channel->wait();
		}

		$channel->close();
	}


	public function __destruct(){
		$this->connection->close();
	}
}