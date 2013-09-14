<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Dom_Node implements Xes_Visitable_NodeInterface, Xes_Tree_Node_Interface
{
	public static $objectInstances = 0;
	
	
	protected $_objectInstance;
	
	
	public function getObjectInstanceName()
	{
		return __CLASS__ . '(' . $this->_objectInstance . ')';
	}
	
	/**
	 * Tag used for rendering node.
	 * @var string
	 */
	protected $_tag = '';
	
	
	/**
	 * List of attributes for node.
	 * @var array
	 */
	protected $_attributes = array(); 
	
	
	/**
	 * Renderer used for rendering of node.
	 * @var Xes_Dom_Renderer_Interface
	 */
	protected $_renderer = null;
	
	
	/**
	 * Renderer used for rendering of node.
	 * @var Xes_Decorator_Intreface
	 */
	protected $_decorator = null;
	
	
	/**
	 * Renderer used for rendering of node.
	 * @var Xes_Children_Interface
	 */
	protected $_childrenNodes = null;
	
	
	public function __construct($tag, $attributes = array(), $content = null, $options = array())
	{
		$this->_objectInstance = ++self::$objectInstances;
		
		$this->setRenderer(Xes_Dom_Renderer_Xhtml::getInstance());
		$this->setTag($tag);
		$this->setAttributes($attributes);
		
		$this->_childrenNodes = new Xes_Tree_RenderableNode('root');
		
		$this->setContent($content);
		
		$this->_decorator = new Xes_Decorator('root');
	}
	
	
	public function setRenderer(Xes_Dom_Renderer_Interface $renderer)
	{
		$this->_renderer = $renderer;
		
		return $this;
	}
	
	
	public function getRenderer()
	{
		return $this->_renderer;
	}
	
	
	public function setDecorator(Xes_Decorator_Intreface &$decorator)
	{
		$this->_decorator = $decorator;
		
		return $this;
	}
	
	
	public function getDecorator($name = null)
	{
		if ($name !== null)
		{
			return $this->_decorator->getDecorator($name);
		}
		
		return $this->_decorator;
	}
	
	
	public function setContent($content)
	{
		$this->_childrenNodes->set($content);
		
		return $this;
	}
	
	
	public function setTag($tag)
	{
		$this->_tag = $tag;
		
		return $this;
	}
	
	
	public function getTag()
	{
		return $this->_tag;
	}
	
	
	public function setAttribute($key, $value)
	{
		$this->_attributes[$key] = $value;
		
		return $this;
	}
	
	
	public function getAttribute($key)
	{
		if (isset($this->_attributes[$key]))
		{
			return $this->_attributes[$key];
		}
		
		return null;
	}
	
	
	public function removeAttribute($key)
	{
		unset($this->_attributes[$key]);
		
		return $this;
	}
	
	
	public function setAttributes(array $attributes = array())
	{
		$this->_attributes = $attributes;
		
		return $this;
	}
	
	
	public function getAttributes()
	{
		return $this->_attributes;
	}
	
	
	public function setId($id)
	{
		$this->_id = $id;
		
		return $this;
	}
	
	
	public function getId()
	{
		return $this->_id;
	}
	
	
	public function addCssClass($class)
	{
		if (!isset($this->_attributes['class']))
		{
			$this->_attributes['class'] = array();
		}
		elseif (is_string($this->_attributes['class']))
		{
			$this->_attributes['class'] = explode(' ', $this->_attributes['class']);
		}
		
		if (!in_array($class, $this->_attributes['class']))
		{
			$this->_attributes['class'][] = $class;
		}
	}
	
	
	/* Xes_Tree_Node_Interface() */
	
	public function set($config)
	{
		$this->_childrenNodes->set($config);
		
		return $this;
	}
	
	
	public function append($config)
	{
		$this->_childrenNodes->append($config);
		
		return $this;
	}
	
	
	public function prepend($config)
	{
		$this->_childrenNodes->prepend($config);
		
		return $this;
	}
	
	
	public function pop()
	{
		return $this->_childrenNodes->pop();
	}
	
	
	public function shift()
	{
		return $this->_childrenNodes->shift();
	}
	
	
	public function &get($name)
	{
		return $this->_childrenNodes->get($name);
	}
	
	
	public function setChildren(Xes_Children_Interface &$children)
	{
		$this->_childrenNodes = $children;
		
		return $this;
	}
	
	
	public function &getContent($name = null)
	{
		if ($name !== null)
		{
			return $this->_childrenNodes->get($name);
		}
		
		return $this->_childrenNodes;
	}
	
	/* ----- */
	
	
	public function render()
	{
		$tag = $this->getTag();
		$attributes = $this->getAttributes();
		$content = $this->_childrenNodes->render();
		$content =  $this->getRenderer()->renderNode($tag, $attributes, $content);
		$content = $this->_decorator->decorate($content);
		
		return $content;
	}
	
	
	public function __toString()
	{
		return $this->render();
	}
	
	
	public function __clone()
	{
		// var_dump('CLONNING: ' . $this->getObjectInstanceName());
		
		$this->_childrenNodes = clone $this->_childrenNodes;
		
		$this->_decorator = clone $this->_decorator;
		
		$this->_objectInstance = ++self::$objectInstances;
	}
}