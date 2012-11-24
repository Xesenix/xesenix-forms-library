<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Formatter_NullToString extends Xes_Formatter implements Xes_Formatter_Interface {
	
	
	protected $_value = '';
	
	
	public function __construct($name, $nullValue = '')
	{
		parent::__construct($name);
		
		$this->setNullValue($nullValue);
	}
	
	
	public function setNullValue($value)
	{
		$this->_nullValue = $value;
		
		return $this;
	}
	
	
	public function getNullValue()
	{
		return $this->_nullValue;
	}
	
	
	public function format($value)
	{
		if ($value === null)
		{
			return $this->getNullValue();
		}
		
		return $value;
	}
}