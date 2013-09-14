<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Validator_IsChecked implements Xes_Validator_Interface
{
	/**
	 * Message that will be displayed if validation returns false.
	 * @var string
	 */	protected $_errorMessage;	
	
	public function __construct($errorMessage)
	{		$this->_errorMessage = $errorMessage;
	}		
	public function validate(Xes_Visitable_NodeInterface $element)
	{
		$value = $element->getAttribute('checked');
				return $value === 'checked';	}	
		public function getErrorMessage()	{		return $this->_errorMessage;	}
}
