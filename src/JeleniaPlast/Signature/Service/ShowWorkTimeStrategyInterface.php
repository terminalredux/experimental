<?php 
namespace JeleniaPlast\Signature\Service;

interface ShowWorkTimeStrategyInterface
{
	/**
	 * Decide if can display work time (entry & exit) if exists. Decision based 
	 * on give symbol 	
	 *
	 * @retunr bool
	 */
	public function can(): bool;
}