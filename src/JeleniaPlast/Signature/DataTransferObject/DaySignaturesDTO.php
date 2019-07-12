<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\DataTransferObject;

use JeleniaPlast\Signature\Service\ShowWorkTimeStrategyInterface;
use DateTime;

final class DaySignaturesDTO implements DaySignaturesDTOInterface
{
	/**
	 * @var ShowWorkTimeStrategyInterface
	 */
	private $showWorkTimeStrategy;
	
	/**
	 * @var DateTime 
	 */
	private $currentDate;
	
	/**
	 * @var DateTime|null
	 */
	private $entryTime;
	
	/**
	 * @var DateTime|null
	 */
	private $exitTime;
	
	/**
	 * @var int|null
	 */
	private $overmanId; 
	
	/**
	 * @var string|null
	 */
	private $symbol; 
	
	/**
	 * Class constructor 
	 *
	 * @param ShowWorkTimeStrategyInterface $showWorkTimeStrategy
	 * @param DateTime                      $currentDate
	 * @param DateTime|null                 $entryTime
	 * @param DateTime|null                 $exitTime
	 * @param int|null                      $overmanId
	 * @param string|null                   $symbol 
	 */
	public function __construct(ShowWorkTimeStrategyInterface $showWorkTimeStrategy,
	                            DateTime $currentDate, 
								$entryTime, 
								$exitTime, 
								$overmanId, 
								$symbol)
	{
		$this->showWorkTimeStrategy = $showWorkTimeStrategy;
		$this->currentDate          = $currentDate;
		$this->entryTime            = $entryTime;
		$this->exitTime             = $exitTime;
		$this->overmanId            = $overmanId;
		$this->symbol               = $symbol;
	}
	
	/**
	 * @inheritdoc
	 */
	public function validDates(DateTime $start, DateTime $end): bool
	{
		$end->setTime(23,59,59);
		
		if ($this->entryTime instanceof DateTime) {
			
			if ($this->entryTime < $start || $this->entryTime > $end) {
				return false;
			}
			
		}
		
		if ($this->exitTime instanceof DateTime) {
			
			if ($this->exitTime < $start || $this->exitTime > $end) {
				return false;
			}
			
		}
		
		return true;
	}
	
	/**
	 * @inheritdoc
	 */
	public function toArray(): array 
	{
		if ($this->showWorkTimeStrategy->can()) {
			$entry = $this->entryTime instanceof DateTime ? $this->entryTime->format('Y-m-d H-i-s') : null;
			$exit  = $this->exitTime  instanceof DateTime ? $this->exitTime->format('Y-m-d H-i-s') : null;
		} else {
			$entry = null;
		    $exit  = null;
		}
		
		return [
			'symbol'  => $this->symbol,
			'overman' => [
				'id'  => $this->overmanId,
			],
			'time' => [
				'entry' => $entry,
				'exit'  => $exit
			]
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function keyName(): string 
	{
		return $this->currentDate->format('Y-m-d');
	}

}