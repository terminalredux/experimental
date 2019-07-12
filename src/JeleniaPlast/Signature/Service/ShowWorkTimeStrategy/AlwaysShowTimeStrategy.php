<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\Service\ShowWorkTimeStrategy;

use JeleniaPlast\Signature\Service\ShowWorkTimeStrategyInterface;

final class AlwaysShowTimeStrategy implements ShowWorkTimeStrategyInterface
{
	/**
	 * @var string|null 
	 */
	private $symbol ;
	 
	/**
	 * Class constructor
	 *
	 * @param string|null $symbol
	 */
	public function __construct($symbol)
	{
		$this->symbol = $symbol;
	}
	
	/**
	 * @inheritdoc
	 */
	public function can(): bool
	{
		return true;
	}
}