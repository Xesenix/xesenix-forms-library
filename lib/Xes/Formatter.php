<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */


class Xes_Formatter implements Xes_Formatter_Interface {
	
	
	/**
	 * Name used to identify formatter. 
	 * @var string
	 */
	protected $_name = null;
	
	
	/**
	 * List of object in composition.
	 * @var array
	 */
	protected $_formatters = array();
	
	
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
	
	
	public function &_prepareFormatter(&$config)
	{
		if (!$config instanceof Xes_Formatter_Interface)
		{
			$className = array_shift($config);
			$reflection = new ReflectionClass($className);
			
			$formatter = $reflection->newInstanceArgs($config);
			
			if (!$formatter instanceof Xes_Formatter_Interface)
			{
				throw new Exception('Xes_Formatter::_prepareFormatter() - object isn`t instance of Xes_Formatter_Interface!');
			}
		}
		else
		{
			$formatter = $config;
		}
		
		return $formatter;
	}
	
	
	public function addFormatter($config)
	{
		$formatter = $this->_prepareFormatter($config);
		$this->_formatters[$formatter->getName()] = $formatter;
		
		return $this;
	}
	
	
	public function addFormatters($configs)
	{
		foreach ($configs as $config)
		{
			$this->addFormatter($config);
		}
		
		return $this;
	}
	
	
	public function setFormatters($configs)
	{
		$this->_formatters = array();
		$this->addFormatters($configs);
		
		return $this;
	}
	
	
	public function getFormatter($name)
	{
		if (isset($this->_formatters[$name]))
		{
			return $this->_formatters[$name];
		}
		
		throw new Exception("Xes_Formatter::getformatter - index: '$name' doesn`t exists.");
	}
	
	
	public function getFormatters()
	{
		return $this->_formatters;
	}
	
	
	public function format($value)
	{
		foreach ($this->getFormatters() as $formatter)
		{
			$value = $formatter->format($value);
		}
		
		return $value;
	}
}