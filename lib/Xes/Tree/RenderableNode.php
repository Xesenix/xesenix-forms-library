<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Tree_RenderableNode extends Xes_Tree_Node implements Xes_Interface_RenderableInterface
{
	public function render()
	{
		$content = '';
		
		foreach ($this->_children as $node)
		{
			if (is_object($node) && method_exists($node, '__toString'))
			{
				$renderedNode = $node->__toString();
			}
			else
			{
				$renderedNode = $node;
			}
			
			$content .= $renderedNode;
		}
		
		return $content;
	}
	
	
	public function __toString()
	{
		return $this->render();
	}
}