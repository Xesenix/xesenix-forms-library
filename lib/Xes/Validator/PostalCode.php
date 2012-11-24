<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Validator_PostalCode implements Xes_Validator_Interface {
		protected $_errorMessage;	
	public function __construct($errorMessage)
	{		$this->_errorMessage = $errorMessage;
	}		public function validate(Xes_Visitable_NodeInterface $element)
	{
		$value = $element->getValue();
				return preg_match("/^[0-9]{2}-[0-9]{3}$/", $value);	}		public function getErrorMessage()	{		return $this->_errorMessage;	}
}
