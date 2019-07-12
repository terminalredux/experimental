<?php 
namespace JeleniaPlast\Signature\DataTransferObject;

use Shared\Utils\CommonInterface\Arrayable;
use Shared\Utils\CommonInterface\Keyable;
use DateTime;

interface DaySignaturesDTOInterface extends Keyable, Arrayable 
{
	public function validDates(DateTime $start, DateTime $end): bool;
}