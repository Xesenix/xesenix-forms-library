<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Decorator_FormFieldErrors extends Xes_Decorator_FormField
{
	/**
	 * Attributes of error list 
	 * TODO: use them ...
	 * @var array
	 */
	protected $_attributes = array();
	
	
	public function __construct($name, $attributes = array(), $config = array())
	{
		parent::__construct($name, $config);
		
		$this->setAttributes($attributes);
	}
	
	
	public function setAttributes(array $attributes)
	{
		$this->_attributes = $attributes;
		
		return $this;
	}
	
	
	public function getAttributes()
	{
		return $this->_attributes;
	}
	
	
	public function decorate($content)
	{
		$field = $this->getField();
		$errors = $field->renderErrors();
		
		if ($errors !== '')
		{
			$errors = parent::decorate($errors);
			
			switch($this->getPosition())
			{
				case Xes_Decorator::PREPEND:
					$content = $errors . $content;
				break;
				case Xes_Decorator::APPEND:
					$content = $content . $errors;
				break;
				case Xes_Decorator::OVERRIDE:
					$content = $errors;
				break;
			}
		}
		
		return $content;
	}
}