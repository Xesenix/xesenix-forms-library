<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

interface Xes_Dom_Renderer_Interface
{
	public function renderNode($tag, array $attributes = array(), $content = '');
	
	
	public function renderAttributes(array $attributes);
	
	
	public function renderCssClasses(array $cssClasses);
}