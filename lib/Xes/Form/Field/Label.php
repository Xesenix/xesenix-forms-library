<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Form_Field_Label extends Xes_Form_Field {
	
	
	protected $_tag = 'span';
	
	
	public function getDefaultOptions()
	{
		return array(
			'errorBubbling' => true,
		);
	}
	
	
	public function render()
	{
		$tag = $this->getTag();
		$id = $this->getFullId();
		$value = $this->getValue();
		$value = $this->_formatter->format($value);
		
		$attributes = array_merge(
			$this->getAttributes(),
			array(
				'id' => $id,
			)
		);
		
		return $this->_renderer->renderNode($tag, $attributes, $value);
	}
}
