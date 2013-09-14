<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Form_Field_Checkbox extends Xes_Form_Field
{
	public function __construct($name, array $options = array())
	{
		parent::__construct($name, $options);
		
		if (isset($this->_options['value']))
		{
			$this->setCheckValue($this->_options['value']);
		}
	}
	
	
	public function setCheckValue($value)
	{
		$this->_value = $value;
		
		return $this;
	}
	
	
	public function setValue($value)
	{
		if ($value == $this->getValue())
		{
			$this->setAttribute('checked', 'checked');
		}
	}
	
	
	public function getDefaultOptions()
	{
		return array(
			'type' => 'checkbox',
			'errorBubbling' => true,
		);
	}
}
