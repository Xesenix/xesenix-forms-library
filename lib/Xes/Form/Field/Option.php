<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Form_Field_Option extends Xes_Form_Field
{
	public function __construct($name, $options = array())
	{
		parent::__construct($name, $options);
		
		$this->setValue($name);
	}
	
	public function getDefaultOptions()
	{
		return array(
			'errorBubbling' => true,
		);
	}
	
	public function render()
	{
		$value = $this->getValue();
		$label = $this->getLabel();
		$options = $this->_options;
		
		$attributes = array_merge(
			$this->getAttributes(),
			array(
				'value' => $value,
			)
		);
		
		return $this->_renderer->renderNode('option', $attributes, $label);
	}
}
