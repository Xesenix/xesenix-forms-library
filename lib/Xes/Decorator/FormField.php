<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Decorator_FormField extends Xes_Decorator {
	
	
	protected $_name = null;
	
	
	/**
	 * @var Xes_Form_Field
	 */
	protected $_field;
	
	
	public function setField(Xes_Form_Field &$field)
	{
		$this->_field = $field;
		
		foreach ($this->getDecorators() as $decorator)
		{
			if ($decorator instanceof Xes_Decorator_FormField)
			{
				$decorator->setField($this->_field);
			}
		}
		
		return $this;
	}
	
	
	public function getField()
	{
		return $this->_field;
	}
	
	
	public function &_prepareDecorator(&$config)
	{
		$decorator = parent::_prepareDecorator($config);
		
		if ($decorator instanceof Xes_Decorator_FormField)
		{
			$decorator->setField($this->getField());
		}
		
		return $decorator;
	}
}