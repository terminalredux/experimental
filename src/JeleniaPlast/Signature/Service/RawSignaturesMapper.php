<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\Service;

use JeleniaPlast\Signature\Service\Exception\{
	InvalidRawDaySignatureException,
	InvalidRawSignaturesException
};
use JeleniaPlast\Signature\Repository\UserEmploymentRepositoryInterface;
use JeleniaPlast\Signature\DataTransferObject\{
	DaySignaturesDTOInterface,
	DaySignaturesDTO,
	NullDaySignaturesDTO,
	WorkerSignaturesDTOFactory,
	WorkerSignaturesDTOInterface,
	DaySignaturesDTOFactory
};
use DateTime;
use DateInterval;
use DatePeriod;

/**
 * Map raw signatures data stright forward database to DTO object
 */
final class RawSignaturesMapper implements SignatureMapperInterface
{
	const KEY_PREFIX    = 'day';
	const MIN_MONTH_DAY = 1;
	const MAX_MONTH_DAY = 31;
	
	/**
	 * @var WorkerSignaturesDTOFactory
	 */
	private $workerSignatureDTOFactory;
	
	/**
	 * @var DaySignaturesDTOFactory
	 */
	private $daySignaturesDTOFactory;
	
	/**
	 * @var UserEmploymentRepositoryInterface
	 */
	private $userEmploymentRepository;
	
	/**
	 * Class constructor
	 */
	public function __construct(WorkerSignaturesDTOFactory        $workerSignatureDTOFactory,
	                            DaySignaturesDTOFactory           $daySignaturesDTOFactory,
								UserEmploymentRepositoryInterface $userEmploymentRepository)
	{
		$this->workerSignatureDTOFactory = $workerSignatureDTOFactory;
		$this->daySignaturesDTOFactory   = $daySignaturesDTOFactory;
		$this->userEmploymentRepository  = $userEmploymentRepository;
	}
	
	/**
	 * @param array $rawSignatures - expects array with keys day01-day31
	 *
	 * @inheritdoc
	 * @throws InvalidRawSignaturesException
	 */
	public function map(
		int      $externalComapnyId, 
		int      $userId, 
		array    $rawSignatures, 
		DateTime $dateStart, 
		DateTime $dateEnd
	): WorkerSignaturesDTOInterface
	{
		/**
		 * @var WorkerSignaturesDTOInterface $workerSignatureDTO
		 */
		$workerSignatureDTO = $this->workerSignatureDTOFactory
		                           ->getInstance($dateStart, $dateEnd, $userId);
		
		if (empty($rawSignatures)) {
			return $workerSignatureDTO;
		}
		
		if (false === $this->isValid($rawSignatures)) {
			throw new InvalidRawSignaturesException();
		}

		$period = new DatePeriod($dateStart, new DateInterval('P1D'), $dateEnd);
		

		$contractPeriod = $this->userEmploymentRepository
		                       ->findExternalCompanyWorkerContractByMonthOfYear($externalComapnyId, $userId, $dateStart);
		
		foreach ($period as $day) {
						
			$searchedKey     = $this->buildSearchedDayKey($day);
			
			$daySignatureDTO = $this->daySignaturesDTOFactory->getInstance($day, $rawSignatures[$searchedKey], $contractPeriod);
			
			$workerSignatureDTO->addDaySignature($daySignatureDTO);
		}
		
		return $workerSignatureDTO;
	}
	
	private function buildSearchedDayKey(DateTime $day): string 
	{
		return self::KEY_PREFIX . $day->format('d');
	}
	
	private function isValid(array $rawData): bool 
	{
		if (count(range(self::MIN_MONTH_DAY, self::MAX_MONTH_DAY)) !== count($rawData)) {
			return false;
		}
		
		if(count($rawData) !== count(array_unique(array_keys($rawData)))) {
			return false;
		}
		
		foreach($rawData as $signatureKey => $signatures) {
			
			$dayNumber = (int) str_replace(self::KEY_PREFIX, '', $signatureKey);
			
			if ($dayNumber < self::MIN_MONTH_DAY || $dayNumber > self::MAX_MONTH_DAY) {
				return false;
			}
			
			if (false === is_string($signatures) && null !== $signatures) {
				return false;
			}
			
		}
		
		return true;
	}

}