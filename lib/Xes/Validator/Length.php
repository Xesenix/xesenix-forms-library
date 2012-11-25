<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Validator_Length implements Xes_Validator_Interface {
	
	
	/**
	 * Length of string
	 * @var int
	 */	protected $_length;
	
	
	/**
	 * Message that will be displayed if validation returns false.
	 * @var string
	 */	protected $_errorMessage;	
	
	public function __construct($length, $errorMessage)
	{
		$this->_length = $length;		$this->_errorMessage = $errorMessage;
	}	
		public function validate(Xes_Visitable_NodeInterface $element)
	{
		$value = $element->getValue();
				return is_string($value) && strlen($value) == $this->_length;	}	
		public function getErrorMessage()	{		return $this->_errorMessage;	}
}
