<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\Mock;

use JeleniaPlast\Signature\Repository\UserEmploymentRepositoryInterface;
use JeleniaPlast\Contract\Model\ContractPeriod;
use DateTime;


final class UserEmploymentRepository implements UserEmploymentRepositoryInterface
{
	/**
	 * @inheritdoc
	 */
	public function findExternalCompanyWorkerContractByMonthOfYear(
		int $externalCompanyId, 
		int $userId, 
		DateTime $monthOfYear
	): ContractPeriod
	{
		return new ContractPeriod(
			(new DateTime())->setDate(2014,1,1)->setTime(0,0,0,0),
			null //(new DateTime())->setDate(2015,11,1)->setTime(23,59,59)
		);
	}
}