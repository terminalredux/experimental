<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\Service\ShowWorkTimeStrategy;

use JeleniaPlast\Signature\Service\ShowWorkTimeStrategyInterface;

final class DontShowTimeStrategy implements ShowWorkTimeStrategyInterface
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
	
	
	public function can(): bool
	{
		return false;
	}
}