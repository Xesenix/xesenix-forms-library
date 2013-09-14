<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Tree_StringNode extends Xes_Tree_RenderableNode
{
	protected $_children = array();
	
	
	protected function &_prepareTreeNodeConfig(&$config)
	{
		if (is_string($config))
		{
			return $config;
		}
		
		throw new Exception('Xes_Tree_StringNode::_prepareTreeNodeConfig() - object isn`t instance of string!');
	}
}