<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Decorator_Tag extends Xes_Decorator_Node
{
	/**
	 * DOM node that will be rendered for decoration.
	 * @var Xes_Dom_Node
	 */
	protected $_node = null;
	
	
	public function __construct($name, $tag, $attributes = array(), $content = null, $config = array())
	{
		parent::__construct($name, new Xes_Dom_Node($tag, $attributes, $content), $config);
	}
}