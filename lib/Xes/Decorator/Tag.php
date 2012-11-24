<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Decorator_Tag extends Xes_Decorator {
	
	public function __construct($name, $tag, $attributes = array(), $config = array())
	{
		parent::__construct($name, $config);
		
		$this->setNode(new Xes_Dom_Node($tag, $attributes));
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
		$content = parent::decorate($content);
		$node = $this->getNode();
		
		switch($this->getPosition())
		{
			case Xes_Decorator::PREPEND:
				$content = $node->render() . $content ;
			break;
			case Xes_Decorator::APPEND:
				$content = $content . $node->render();
			break;
			case Xes_Decorator::OVERRIDE:
				$node->setContent($content);
				$content = $node->render();
			break;
		}
		
		return $content;
	}
}