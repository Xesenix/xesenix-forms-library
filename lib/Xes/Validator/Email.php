<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Validator_Email implements Xes_Validator_Interface {
	
	
	/**
	 * Message that will be displayed if validation returns false.
	 * @var string
	 */	protected $_errorMessage;
		
	public function __construct($errorMessage)
	{		$this->_errorMessage = $errorMessage;
	}	
		public function validate(Xes_Visitable_NodeInterface $element)	{
		$value = $element->getValue();
				return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $value);	}	
		public function getErrorMessage()	{		return $this->_errorMessage;	}
}
