<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Validator_Min implements Xes_Validator_Interface
{
	/**
	 * Minimal value of field.
	 * @var int
	 */
	
	
	/**
	 * Message that will be displayed if validation returns false.
	 * @var string
	 */
	
	public function __construct($min, $errorMessage)
	{
		$this->_min = $min;
	}
	
	{
		$value = $element->getValue();
		
	
}