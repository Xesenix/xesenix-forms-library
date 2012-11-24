<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Form_Field_Submit extends Xes_Form_Field {
	
	
	public function getDefaultOptions()
	{
		return array(
			'type' => 'submit',
		);
	}
	
	
	public function render()
	{
		$tag = $this->getTag();
		$value = $this->getLabel();
		$options = $this->_options;
		$attributes = array_merge(
			$this->getAttributes(),
			array(
				'value' => $this->getLabel(),
				'type' => $options['type'],
			)
		);
		
		return $this->_renderer->renderNode($tag, $attributes);
	}
}
