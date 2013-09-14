<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Form_Field_Textarea extends Xes_Form_Field
{
	/**
	 * Tag used as container for label field.
	 * @var string
	 */
	protected $_tag = 'textarea';
	
	
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
		$name = $this->getFullName();
		$value = $this->getValue();
		$value = $this->_formatter->format($value);
		
		$attributes = array_merge(
			$this->getAttributes(),
			array(
				'id' => $id,
				'name' => $name,
			)
		);
		
		return $this->_renderer->renderNode($tag, $attributes, $value);
	}
}
