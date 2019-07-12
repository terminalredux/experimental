<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\DataTransferObject;

use DateTime;

final class WorkerSignaturesDTOFactory
{
	public function getInstance(DateTime $dateStart, DateTime $dateEnd, int $userId): WorkerSignaturesDTOInterface
	{
		return new WorkerSignaturesDTO($dateStart, $dateEnd, $userId);
	}
}