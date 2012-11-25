<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Decorator_FormFieldLabel extends Xes_Decorator_FormField {
	
	
	/**
	 * List of attributes for label node.
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
		$renderer = $field->getRenderer();
		$id = $field->getFullId();
		
		$attributes = array_merge(
			$this->getAttributes(),
			array('for' => $id)
		);
		
		if ($this->getPosition() != Xes_Decorator::OVERRIDE)
		{
			$label = $field->getLabel();
			$label = $renderer->renderNode('label', $attributes, $label);
		}
		else
		{
			$label = $renderer->renderNode('label', $attributes, $content);
		}
		
		$label = parent::decorate($label);
		
		switch($this->getPosition())
		{
			case Xes_Decorator::PREPEND:
				$content = $label . $content;
			break;
			case Xes_Decorator::APPEND:
				$content = $content . $label;
			break;
			case Xes_Decorator::OVERRIDE:
				$content = $label;
			break;
		}
		
		return $content;
	}
}