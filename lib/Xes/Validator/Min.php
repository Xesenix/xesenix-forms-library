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
	 */	protected $_min;
	
	
	/**
	 * Message that will be displayed if validation returns false.
	 * @var string
	 */	protected $_errorMessage;	
	
	public function __construct($min, $errorMessage)
	{
		$this->_min = $min;		$this->_errorMessage = $errorMessage;
	}	
		public function validate(Xes_Visitable_NodeInterface $element)
	{
		$value = $element->getValue();
				return is_numeric($value) && $value >= $this->_min;	}	
		public function getErrorMessage()	{		return $this->_errorMessage;	}
}
