<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Validator_Number implements Xes_Validator_Interface {
		protected $_errorMessage;	
	public function __construct($errorMessage)
	{		$this->_errorMessage = $errorMessage;
	}		public function validate(Xes_Visitable_NodeInterface $element)
	{
		$value = $element->getValue();
				return is_numeric($value);	}		public function getErrorMessage()	{		return $this->_errorMessage;	}
}
