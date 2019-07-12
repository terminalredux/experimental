<?php 
namespace JeleniaPlast\Signature\Service;

use JeleniaPlast\Signature\DataTransferObject\WorkerSignaturesDTOInterface;
use DateTime;

interface SignatureMapperInterface
{
	public function map(
		int      $externalComapnyId,
		int      $userId, 
		array    $rawSignatures, 
		DateTime $dateStart, 
		DateTime $dateEnd
	): WorkerSignaturesDTOInterface;
}
