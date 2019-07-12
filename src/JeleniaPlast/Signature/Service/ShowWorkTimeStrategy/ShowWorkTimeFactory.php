<?php 
declare(strict_types=1);

namespace JeleniaPlast\Signature\Service\ShowWorkTimeStrategy;

use JeleniaPlast\Signature\Service\ShowWorkTimeStrategyInterface;

final class ShowWorkTimeFactory 
{
	const SYMBOL_DW   = 'dw';
	const SYMBOL_UWYP = 'uwyp';
	
	/**
	 * @var string|null $symbol
	 */
	public function getInstance($symbol): ShowWorkTimeStrategyInterface
	{
		$symbol = is_string($symbol) ? trim(strtolower($symbol)) : $symbol; 
		
		switch($symbol) {
			case self::SYMBOL_DW: 
			
				return new DontShowTimeStrategy($symbol);
				
			case self::SYMBOL_UWYP:
				
				return new DontShowTimeStrategy($symbol);
				
			default: 

				return new AlwaysShowTimeStrategy($symbol);
		}
		
	}
	
} 