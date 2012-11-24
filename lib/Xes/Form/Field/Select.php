<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Form_Field_Select extends Xes_Form_Field {
	
	protected $_children = array();
	
	
	public function __construct($name, $options = array())
	{
		parent::__construct($name, $options);
		
		if (isset($this->_options['options']))
		{
			foreach($this->_options['options'] as $key => $value)
			{
				if (is_string($value))
				{
					$options = array(
						'label' => $value,
					);
				}
				else
				{
					$options = $value;
				}
				
				$this->add($key, null, $options);
			}
		}
		
		if (isset($this->_options['value']))
		{
			$this->setValue($this->_options['value']);
		}
	}
	
	
	public function setValue($value)
	{
		parent::setValue($value);
		
		foreach($this->_children as $child)
		{
			if ($child->getValue() == $value)
			{
				$child->setAttribute('selected', 'selected');
			}
			else
			{
				$child->removeAttribute('selected');
			}
		}
	}
	
	
	public function add($name, $childClass, array $options)
	{
		if ($childClass === null)
		{
			$childClass = 'Xes_Form_Field_Option';
		}
		
		$this->_children[$name] = new $childClass($name, $options);
		$this->_children[$name]->setParent($this);
		
		return $this;
	}
	
	
	public function getDefaultOptions()
	{
		return array(
			'errorBubbling' => true,
		);
	}
	
	
	public function renderChildren()
	{
		$children = '';
		
		foreach($this->_children as $child)
		{
			$children .= "$child";
		}
		
		return $children;
	}
	
	
	public function render()
	{
		$value = $this->getValue();
		$id = $this->getFullId();
		$name = $this->getFullName();
		$options = $this->_options;
		$children = $this->renderChildren();
		
		$attributes = array_merge(
			$this->getAttributes(),
			array(
				'id' => $id,
				'name' => $name,
			)
		);
		
		return $this->_renderer->renderNode('select', $attributes, $children);
	}
}
