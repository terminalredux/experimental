<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\DataTransferObject;

use DateTime;
use JeleniaPlast\Signature\Service\ShowWorkTimeStrategy\ShowWorkTimeFactory;
use JeleniaPlast\Contract\Model\ContractPeriod;
use JeleniaPlast\Signature\Service\Exception\{
	InvalidRawDaySignatureException
};

final class DaySignaturesDTOFactory
{
	/**
	 * @var ShowWorkTimeFactory
	 */
	private $showWorkTimeFactory;
	
	/**
	 * Class construct
	 */
	public function __construct(ShowWorkTimeFactory $showWorkTimeFactory)
	{
		$this->showWorkTimeFactory = $showWorkTimeFactory;
	}
	
	/**
	 * @param string|null rawSignature - but can be anything!
	 * @throws InvalidRawDaySignatureException
	 */
	public function getInstance(DateTime $currentDay, $rawSignature, ContractPeriod $contractPeriod): DaySignaturesDTOInterface
	{
		if (null === $rawSignature || false === $contractPeriod->contains($currentDay)) {
			
			$showWorkTimeStrategy = $this->showWorkTimeFactory->getInstance(null);
			
			return new DaySignaturesDTO($showWorkTimeStrategy, $currentDay, null, null, null, null);
		}
		
		$extracted = explode(',', $rawSignature);
		
		$this->validation($extracted);
		
		$entry     = $extracted[0] == 'null' ? null : (int) $extracted[0];
		$exit      = $extracted[1] == 'null' ? null : (int) $extracted[1];
		$overmanId = $extracted[2] == 'null' ? null : (int) $extracted[2];
		$symbol    = $extracted[3] == 'null' ? null : $extracted[3]; 
		
		$entry = is_int($entry) ? (new DateTime)->setTimestamp((int) $entry) : $entry;
		$exit  = is_int($exit) ? (new DateTime)->setTimestamp((int) $exit)  : $exit;
		
		$showWorkTimeStrategy = $this->showWorkTimeFactory->getInstance($symbol);
		
		return new DaySignaturesDTO(
			$showWorkTimeStrategy,
			$currentDay, 
			$entry, 
			$exit, 
			$overmanId, 
			$symbol
		);
	}
	
	/**
	 * Throws errors if something wrong 
	 *
	 * @return void
	 * @throws InvalidRawDaySignatureException
	 */
	private function validation(array $extracted)
	{
		if (false === $this->firstTwoElementsAreIntegersOrNulls($extracted)) {
			throw new InvalidRawDaySignatureException('Two first array element should be integers timestamps');
		}
		
		if (false === $this->thirdElementIsIntegerIdOrNull($extracted)) {
			throw new InvalidRawDaySignatureException('Third param should be valid overman id or null');
		}
		
		if (false === $this->fourthElementIsStringOrNull($extracted)) {
			throw new InvalidRawDaySignatureException('Fourth param should be valid string or null');
		}
	}
	
	/**
	 * Partial validation
	 */
	private function fourthElementIsStringOrNull(array $extracted): bool
	{
		return array_key_exists(3, $extracted) && ('null' == $extracted[3] || (is_string($extracted[3]) && $extracted[3]));
	}
	
	/**
	 * Partial validation
	 */
	private function thirdElementIsIntegerIdOrNull(array $extracted): bool 
	{
		return array_key_exists(2, $extracted) && ('null' == $extracted[2] || (int) $extracted[2] > 0);
	}	
	 
	/**
	 * Partial validation
	 */
	private function firstTwoElementsAreIntegersOrNulls(array $extracted): bool  
	{
		return array_key_exists(0, $extracted) && array_key_exists(1, $extracted) &&
		       ('null' == $extracted[0] || (int) $extracted[0] > 0) &&
			   ('null' == $extracted[0] || (int) $extracted[0] > 0);
	}
	
}