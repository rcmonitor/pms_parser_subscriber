<?php
/**
 * User: /@by_rcmonitor@/
 * Date: 08.02.2015
 * Time: 19:19
 */

namespace RCMLibs;

use helpers\Tester;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Channel\AMQPChannel;

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


	/**
	 * @var AMQPConnection
	 */
	private $connection;


	/**
	 * @var AMQPChannel
	 */
	private $channel;
	
	
	private $timer;


	private $timeStarted;


	/**
	 * @var PMSPageWorker
	 */
	private $worker;


	/**
	 * @var int timeout in seconds
	 */
	private $timeout;

	
	public function __construct(){
		
		$this->timer = new Timer(true, __CLASS__ . ' constructed');

		$this->timeout = 2;

		$this->timeStarted = Timer::ft();

		$this->initParameters();

		$this->connection = new AMQPConnection(...self::CONNECTION_PARAMETERS['rabbit']);
		
		$this->channel = $this->connection->channel();

		$this->worker = new PMSPageWorker($this->channel);

		$this->initConsumerParameters();
		
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

	}
	
	
	private function initConsumerParameters(){

		$this->consumeProperties = array(
			'queue' => $this->queueName
		, 'consumer_tag' => $this->routingKey
		, 'no_local' => false
		, 'no_acknowledge' => false
		, 'exclusive' => false
		, 'nowait' => false
		, 'callback' => array($this->worker, 'perform')
		, 'ticket' => null
		, 'arguments' => array()
		);
	}
	
	
	public function consume(){
		$this->timer->lap('got new channel');
		$resultChannelDeclare = $this->channel->exchange_declare(...array_values($this->exchangeProperties));

		Tester::view($resultChannelDeclare, 'channel declare result');

		$this->timer->lap('got exchange');
		$resultQueueDeclare = $this->channel->queue_declare(...array_values($this->queueProperties));

		Tester::view($resultQueueDeclare, 'queue declare result');
		$this->timer->lap('got queue');

		echo 'waiting for messages' . "\n";
		
		$resultConsumerTag = $this->channel->basic_consume(...array_values($this->consumeProperties));
		$this->timer->lap('channel subscribed');

		if(!empty($this->timeout)){
			$this->waitWithTimeout($this->channel);
		}else{
			$this->waitForever($this->channel);
		}

		$this->channel->close();
		Tester::ec('channel closed');
	}


	private function waitWithTimeout(){
		while(count($this->channel->callbacks)) {
			try{
				$this->channel->wait(null, false, $this->timeout);
			}catch (\Exception $e){

				if($e->getCode() === 0){
					$strMsg = 'resumed by timeout of ' . $this->timeout . "\n";
					Tester::ec($strMsg);
					break;
				}
			}
		}

	}


	private function waitForever(){
		while(count($this->channel->callbacks)){
			$this->channel->wait();
		}
	}


	public function __destruct(){
		$this->connection->close();
		Tester::ec('connection closed');
	}
}