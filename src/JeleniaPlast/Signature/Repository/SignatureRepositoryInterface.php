<?php 
namespace JeleniaPlast\Signature\Repository;

use DateTime;

interface SignatureRepositoryInterface
{
	public function findUserSignatureyYearAndMonth(int $userId, DateTime $monthOfYear): array;
}