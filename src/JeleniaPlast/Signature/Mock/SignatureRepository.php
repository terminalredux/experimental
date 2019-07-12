<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\Mock;

use DateTime;
use JeleniaPlast\Signature\Repository\SignatureRepositoryInterface;

final class SignatureRepository implements SignatureRepositoryInterface
{
	/**
	 * @inheritdoc
	 */
	public function findUserSignatureyYearAndMonth(int $userId, DateTime $monthOfYear): array
	{
		return [
			'day01' =>  '1446411600,1446440786,null,null',
			'day02' =>  'null,null,15,null',
			'day03' =>  null,
			'day04' =>  '1446641325,1446670875,15,dw',
			'day05' =>  '1446727595,1446757297,15,null',
			'day06' =>  '1446814099,1446843663,15,null',
			'day07' =>  '1446900399,1446930047,15,null',
			'day08' =>  null,
			'day09' =>  null,
			'day10' =>  '1447130769,1447160449,15,null',
			'day11' =>  '1447217351,1447246856,15,null',
			'day12' =>  '1447303721,1447333279,15,null',
			'day13' =>  null,
			'day14' =>  '1447534211,1447563668,15,null',
			'day15' =>  '1447620400,1447650054,15,null',
			'day16' =>  '1447706920,1447736462,15,null',
			'day17' =>  '1447793407,1447822874,15,null',
			'day18' =>  'null,null,15,null',
			'day19' =>  null,
			'day20' =>  '1448023586,1448053217,15,dw',
			'day21' =>  '1448110016,1448139660,15,null',
			'day22' =>  '1448196399,1448226086,15,null',
			'day23' =>  '1448282981,1448312484,15,null',
			'day24' =>  null,
			'day25' =>  '1448427008,1448456453,15,null',
			'day26' =>  '1448513219,1448542858,15,null',
			'day27' =>  '1448599751,1448629255,15,null',
			'day28' =>  '1448686059,1448715664,15,null',
			'day29' =>  null,
			'day30' =>  '1448916585,1448946048,15,null',
			'day31' =>  null
		];
	}
}