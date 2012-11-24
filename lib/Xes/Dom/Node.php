<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Dom_Node {
	
	
	protected $_tag = '';
	
	
	protected $_content = '';
	
	
	protected $_attributes = array(); 
	
	
	protected $_renderer = null;
	
	
	public function __construct($tag, $attributes = array(), $content = '', $options = array())
	{
		$this->setRenderer(Xes_Dom_Renderer_Xhtml::getInstance());
		$this->setTag($tag);
		$this->setAttributes($attributes);
		$this->setContent($content);
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
	
	
	public function setTag($tag)
	{
		$this->_tag = $tag;
		
		return $this;
	}
	
	
	public function getTag()
	{
		return $this->_tag;
	}
	
	
	public function setContent($content)
	{
		$this->_content = $content;
		
		return $this;
	}
	
	
	public function getContent()
	{
		return $this->_content;
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
	
	
	public function render()
	{
		$tag = $this->getTag();
		$attributes = $this->getAttributes();
		$content = $this->getContent();
		
		return $this->getRenderer()->renderNode($tag, $attributes, $content);
	}
	
	
	public function __toString()
	{
		return $this->render();
	}
}