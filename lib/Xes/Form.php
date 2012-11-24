<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Form extends Xes_Form_Field {
	
	protected $_tag = 'form';
	
	
	protected $_name = 'form';
	
		protected $_children = array();
	
	
	public function __construct($name, $options = array())
	{
		if (!isset($options['attr']))
		{
			$options['attr'] = array();
		}
		
		$options['attr'] = array_merge(array(
			'action' => '',
			'method' => 'post',
		), $options['attr']);
		
		parent::__construct($name, $options);
	}
	
	
	public function setAction($action)
	{
		$this->_attributes['action'] = $action;
		
		return $this;
	}
	
	
	public function getAction()
	{
		return $this->_attributes['action'];
	}
	
	
	public function setMethod($method)
	{
		$this->_attributes['method'] = $method;
		
		return $this;
	}
	
	
	public function getMethod()
	{
		return $this->_attributes['method'];
	}
	
	
	public function isValid()
	{
		$this->clearErrors();
		
		$result = true;
		
		foreach($this->_children as &$child)
		{
			if (!$child->isValid())
			{
				$result = false;
			}
		}
		
		return $result;
	}	
		public function add($name, $childClass = null, $options = array())	{		if ($childClass === null)		{			$childClass = 'Xes_Form_Field';		}
				$this->_children[$name] = new $childClass($name, $options);
		$this->_children[$name]->setParent($this);
		
		return $this;	}
	
	
	public function setData($data)
	{
		if (isset($data[$this->getName()]))
		{
			$data = $data[$this->getName()];
			
			foreach($this->_children as $child)
			{
				if (isset($data[$child->getName()]))
				{
					$child->setValue($data[$child->getName()]);
				}
			}
		}
		
		return $this;
	}
	
	
	public function getData()
	{
		$data = array();
		
		foreach($this->_children as $child)
		{
			$data[$child->getName()] = $child->getValue();
		}
		
		return $data;
	}
	
	
	public function getDefaultOptions()
	{
		return array(
			'errorBubbling' => false,
		);
	}	
		public function __get($paramName)	{		if (isset($this->_children[$paramName]))		{			return $this->_children[$paramName];		}	}
	
	
	public function render()
	{
		$children = '';
		
		foreach ($this->_children as $child)
		{
			$children .= $child->__toString() . "\n";
		}
		
		$tag = $this->getTag();
		$options = $this->_options;
		$attributes = array_merge(
			$this->getAttributes(),
			array(
				'id' => $this->getFullId(),
				'name' => $this->getFullName(),
			)
		);
		
		return $this->_renderer->renderNode($tag, $attributes, $children);
	}
}
