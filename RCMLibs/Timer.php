<?php
/**
 * @author //@by_rcmonitor@//
 * Date: 09.09.13
 * Time: 12:40
 */

namespace RCMLibs;

class Timer {


	private $timeStart;


	private $baseMemoryUsage;


	private $active;


	private $counter;


	public function __construct($boolActive = FALSE, $strMessage = '', $intCounter = 0){
		$this->active = $boolActive;
		if($this->active){
			$this->timeStart = self::ft();

			$this->counter = $intCounter;

			if(empty($strMessage)){
				$strMessage = 'timer started';
			}

			$strMessage .= ' at ';
			$strMessage .= self::out($this->timeStart);
			$strMessage .= ' seconds' . "\n";

			$this->baseMemoryUsage = memory_get_usage();

			$strMessage .= $this->baseMemoryUsage . ' memory already used' . "\n";

			echo $strMessage;
		}
	}


	public function lap($strMessage = ''){
		if($this->active){
			$timeLap = self::ft();
			$this->counter ++;

			$timeTook = $timeLap - $this->timeStart;

			$strMessage .= ' ' . $this->counter . ' items processed for ' . self::out($timeTook) . ' seconds' . "\n";

			$memoryUsed = memory_get_usage() - $this->baseMemoryUsage;

			$strMessage .= 'using ' . $memoryUsed . ' of memory' . "\n";

			echo $strMessage;
		}
	}


	public function end($strMessage = ''){
		if($this->active){
			$timeEnd = self::ft();

			$timeTook = $timeEnd - $this->timeStart;

			if(empty($strMessage)){
				$strMessage = 'everything done ';
			}

			$strMessage .= ' for ' . self::out($timeTook) . ' seconds' . "\n";

			$memoryUsed = memory_get_usage() - $this->baseMemoryUsage;

			$strMessage .= 'using ' .  $memoryUsed . ' of memory' . "\n";

			$strMessage .= 'with peak of ' . memory_get_peak_usage() - $this->baseMemoryUsage . "\n";

			echo $strMessage;
		}
	}


	/**
	 * returns fractions of a current second
	 *
	 * @return string
	 */
	public static function mt(){
		return substr(microtime(), 2, 6);
	}


	/**
	 * returns full current time (integer + fractions)
	 *
	 * @return string
	 */
	public static function ft(){
		return time() . '.' . self::mt();
	}


	public static function out($time){
		return number_format($time, 6);
	}
}
