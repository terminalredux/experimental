<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\DataTransferObject;

use DateTime;
use InvalidArgumentException;

final class WorkerSignaturesDTO implements WorkerSignaturesDTOInterface
{
	/**
	 * @var DateTime
	 */
	private $dateStart;

	/**
	 * @var DateTime
	 */
	private $dateEnd;

	/**
	 * @var int
	 */
	private $userId;
	
	/**
	 * @var DaySignaturesDTOInterface[]
	 */
	private $signatures = [];
	
	/**
	 * Class constructor
	 */
	public function __construct(DateTime $dateStart, DateTime $dateEnd, int $userId)
	{
		$this->dateStart  = $dateStart; 
		$this->dateEnd    = $dateEnd; 
		$this->userId     = $userId;
	}
	
	/** 
	 * @inheritdoc 
	 */
	public function addDaySignature(DaySignaturesDTOInterface $daySignatures)
	{
		if (false === $daySignatures->validDates($this->dateStart, $this->dateEnd)) {
			
			throw new InvalidArgumentException('Given signature date are not from given period');
		}
		
		$this->signatures[] = $daySignatures;
	}
	
	/**
	 * @inheritdoc
	 */
	public function toArray(): array 
	{
		$signatures = [];
		
		/**
		 * @var DaySignaturesDTOInterface $signature 
		 */
		foreach ($this->signatures as $signature) {
			$signatures[$signature->keyName()] = $signature->toArray();
		}
		
		return [
			'range'      => [
				'from' => $this->dateStart->format('Y-m-d'),
				'to'   => $this->dateEnd->format('Y-m-d') 
			],
			'worker'     => [
				'id' => $this->userId,
			],
			'signatures' => $signatures
		];
	}
}