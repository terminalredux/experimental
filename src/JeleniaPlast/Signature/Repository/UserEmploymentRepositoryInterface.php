<?php 
namespace JeleniaPlast\Signature\Repository;

use DateTime;
use JeleniaPlast\Contract\Model\ContractPeriod;

interface UserEmploymentRepositoryInterface
{
	public function findExternalCompanyWorkerContractByMonthOfYear(
		int $externalCompanyId, 
		int $userId, 
		DateTime $monthOfYear
	): ContractPeriod;
}