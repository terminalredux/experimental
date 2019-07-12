<?php 
declare(strict_types=1);

namespace JeleniaPlast\Contract\Model;

use DateTime;
use DatePeriod;
use TypeError;

final class ContractPeriod 
{
	/**
	 * @var DateTime 
	 */
	private $from;
	
	/**
	 * @var DateTime|null 
	 */
	private $to;
	
	/**
	 * Class constructor 
	 *
	 * @param DateTime      $from 
	 * @param DateTime|null $to
	 */
	public function __construct(DateTime $from, $to)
	{
		if (false === ($to instanceof DateTime) && null !== $to) {
			throw new TypeError('$to should contain DateTime object or null value');
		}
		
		$this->from = $from;
		$this->to   = $to;
	}
	
	/**
	 * Checks if given date is in contract
	 */
	public function contains(DateTime $checkedDate): bool 
	{
		$result = true;
		
		if ($this->from > $checkedDate) {
			return false;
		}
		
		if ($this->to && $this->to < $checkedDate) {
			return false;
		}
		
		return $result;
	}
}