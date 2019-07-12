<?php 
namespace JeleniaPlast\Signature\DataTransferObject;

use Shared\Utils\CommonInterface\Arrayable;

interface WorkerSignaturesDTOInterface extends Arrayable
{
	/**
	 * @return void
	 */
	public function addDaySignature(DaySignaturesDTOInterface $daySignatures);
}