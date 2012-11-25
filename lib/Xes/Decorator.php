<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Decorator implements Xes_Decorator_Interface {
	
	
	const PREPEND = 'prepend';
	
	
	const APPEND = 'append';
	
	
	const OVERRIDE = 'override';
	
	
	/**
	 * Name used to identify decorator. 
	 * @var string
	 */
	protected $_name = null;
	
	
	/**
	 * Special configuration that controls decorator behaviour. For example 'placment' that defines where decorator is added.
	 * @var array
	 */
	protected $_config = array();
	
	
	/**
	 * List of object in composition.
	 * @var array
	 */
	protected $_decorators = array();
	
	
	public function __construct($name, $config = array())
	{
		$this->setName($name);
		$this->setConfig($config);
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
	
	
	public function setConfig($config)
	{
		$this->_config = $config;
		
		return $this;
	}
	
	
	public function getConfig()
	{
		return $this->_config;
	}
	
	
	public function getPosition()
	{
		if (isset($this->_config['position']))
		{
			return $this->_config['position'];
		}
		
		return self::OVERRIDE;
	}
	
	
	public function &_prepareDecorator(&$config)
	{
		if (!$config instanceof Xes_Decorator_Interface)
		{
			$className = array_shift($config);
			$reflection = new ReflectionClass($className);
			
			$decorator = $reflection->newInstanceArgs($config);
			
			if (!$decorator instanceof Xes_Decorator_Interface)
			{
				throw new Exception('Xes_Decorator::_prepareDecorator() - object isn`t instance of Xes_Decorator_Interface!');
			}
		}
		else
		{
			$decorator = $config;
		}
		
		return $decorator;
	}
	
	
	public function addDecorator($config)
	{
		$decorator = $this->_prepareDecorator($config);
		$this->_decorators[$decorator->getName()] = $decorator;
		
		return $this;
	}
	
	
	public function addDecorators($configs)
	{
		foreach ($configs as $config)
		{
			$this->addDecorator($config);
		}
		
		return $this;
	}
	
	
	public function setDecorators($configs)
	{
		$this->_decorators = array();
		$this->addDecorators($configs);
		
		return $this;
	}
	
	
	public function getDecorator($name)
	{
		if (isset($this->_decorators[$name]))
		{
			return $this->_decorators[$name];
		}
		
		throw new Exception("Xes_Decorator::getDecorator - index: '$name' doesn`t exists.");
	}
	
	
	public function getDecorators()
	{
		return $this->_decorators;
	}
	
	
	public function decorate($content)
	{
		foreach ($this->getDecorators() as $decorator)
		{
			$content = $decorator->decorate($content);
		}
		
		return $content;
	}
}