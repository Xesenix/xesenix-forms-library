<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Decorator_Node extends Xes_Decorator
{
	/**
	 * DOM node that will be rendered for decoration.
	 * @var Xes_Dom_Node
	 */
	protected $_node = null;
	
	
	public function __construct($name, Xes_Dom_Node $node = null, $config = array())
	{
		parent::__construct($name, $config);
		
		if ($node !== null)
		{
			$this->setNode($node);
		}
	}
	
	
	public function setNode(Xes_Dom_Node $node)
	{
		$this->_node = $node;
		
		return $this;
	}
	
	
	public function getNode()
	{
		return $this->_node;
	}
	
	
	public function decorate($content)
	{
		$node = $this->getNode();
		
		
		if ($this->getPosition() != Xes_Decorator::OVERRIDE)
		{
			$node = $node->render();
		}
		else
		{
			$node->setContent($content);
			$node = $node->render();
		}
		
		$node = parent::decorate($node);
		
		switch($this->getPosition())
		{
			case Xes_Decorator::PREPEND:
				$content = $node . $content;
			break;
			case Xes_Decorator::APPEND:
				$content = $content . $node;
			break;
			case Xes_Decorator::OVERRIDE:
				$content = $node;
			break;
		}
		
		return $content;
	}
}