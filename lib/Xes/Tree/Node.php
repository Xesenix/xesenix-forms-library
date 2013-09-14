<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Tree_Node implements Xes_Tree_Node_Interface, IteratorAggregate, ArrayAccess
{
	public static $objectInstances = 0;
	
	
	protected $_objectInstance;
	
	
	public function getObjectInstanceName()
	{
		return __CLASS__ . '(' . $this->_objectInstance . ')';
	}
	
	
	protected $_children = array();
	
	
	/**
	 * Name used to identify child. 
	 * @var string
	 */
	protected $_name = null;
	
	
	public function __construct($name)
	{
		$this->_objectInstance = ++self::$objectInstances;
		
		$this->setName($name);
	}
	
	
	public function setName($name)
	{
		$this->_name = $name;
		
		return $this;
	}
	
	
	public function getName()
	{
		return $this->_name;
	}
	
	
	protected function _prepareTreeNodeConfig(&$config)
	{
		if (is_null($config))
		{
			return null;
		}
		if (is_string($config))
		{
			$stringNode = new Xes_Tree_StringNode('leaf');
			$stringNode->set($config);
			
			return $stringNode;
		}
		elseif (!$config instanceof Xes_Tree_Node_Interface)
		{
			$className = array_shift($config);
			$reflection = new ReflectionClass($className);
			
			$node = $reflection->newInstanceArgs($config);
			
			if (!$node instanceof Xes_Tree_Node_Interface)
			{
				throw new Exception('Xes_Tree_Node::_prepareTreeNodeConfig() - object isn`t instance of Xes_Tree_Node!');
			}
		}
		else
		{
			$node = $config;
		}
		
		return $node;
	}
	
	
	public function set($config)
	{
		$item = $this->_prepareTreeNodeConfig($config);
		
		if (is_null($item))
		{
			$this->_children = array();
		}
		else
		{
			$this->_children = array($item);
		}
		
		return $this;
	}
	
	
	public function append($config)
	{
		$item = $this->_prepareTreeNodeConfig($config);
		$this->_children[] = $item;
		
		return $this;
	}
	
	
	public function prepend($config)
	{
		$item = $this->_prepareTreeNodeConfig($config);
		array_unshift($this->_children, $item);
		
		return $this;
	}
	
	
	public function pop()
	{
		return array_pop($this->_children);
	}
	
	
	public function shift()
	{
		return array_shift($this->_children);
	}
	
	
	public function &get($name)
	{
		return $this->_children[$name];
	}
	
	
	public function &getChildren()
	{
		return $this->_children;
	}
	
	/* Interface IteratorAggregate */
	
	public function getIterator() {
		return new ArrayIterator($this->_children);
	}
	
	/* ----- */
	
	
	/* Interface ArrayCollection */
	
	public function offsetSet($offset, $value)
	{
		$item = $this->_prepareTreeNodeConfig($value);
		
		if (is_null($offset))
		{
			$this->_children[] = $item;
		}
		else
		{
			$this->_children[$offset] = $item;
		}
	}
	
	
	public function offsetExists($offset)
	{
		return isset($this->_children[$offset]);
	}
	
	
	public function offsetUnset($offset)
	{
		unset($this->_children[$offset]);
	}
	
	
	public function offsetGet($offset)
	{
		return isset($this->_children[$offset]) ? $this->_children[$offset] : null;
	}
	
	/* ----- */
	
	
	public function __clone()
	{
		// var_dump('CLONNING: ' . $this->getObjectInstanceName());
		
		foreach ($this->_children as $key => $child)
		{
			if (is_object($child))
			{
				$child = clone $child;
			}
			
			$this->_children[$key] = $child;
		}
		
		$this->_objectInstance = ++self::$objectInstances;
	}
}