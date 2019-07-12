<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\Service\Behavior;

use JeleniaPlast\Signature\Repository\SignatureRepositoryInterface;
use JeleniaPlast\Signature\Service\SignatureMapperInterface;
use DateTime;

final class MonthlySignaturesBehavior
{
	/**
	 * @var SignatureRepositoryInterface
	 */
	private $signatureRepository;
	 
	/**
	 * @var RawSignaturesMapper
	 */ 
	private $rawSignaturesMapper;
	 
	/**
	 * Class constructor 
	 */
	public function __construct(SignatureRepositoryInterface $signatureRepository,
	                            SignatureMapperInterface     $rawSignaturesMapper)
	{
		$this->signatureRepository = $signatureRepository;
		$this->rawSignaturesMapper = $rawSignaturesMapper;
	}
	
	/**
	 * Main function
	 * @return array - serialized Data Transfer Object 
	 */
	public function fetchSignatures(int $externalCompanyId, int $userId, DateTime $monthOfYear): array
	{
		$rawSignatures = $this->signatureRepository->findUserSignatureyYearAndMonth($userId, $monthOfYear);
		
		$monthBegin = clone $monthOfYear;
		$monthEnds  = clone $monthOfYear;
		
		$monthBegin->modify('first day of this month');
		$monthEnds->modify('last day of this month');
		
		/**
		 * @var WorkerSignaturesDTOInterface $workerSignaturesDTO
		 */
		$workerSignaturesDTO = $this->rawSignaturesMapper->map(
			$externalCompanyId, 
			$userId, 
			$rawSignatures, 
			$monthBegin, 
			$monthEnds
		);
		
		return $workerSignaturesDTO->toArray();
	}
}
