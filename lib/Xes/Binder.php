<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2012, Xesenix Paweł Kapalla - all rights reserved.
 */
 
class Xes_Binder {
	
	protected $_object;
	
	
	protected $_method;
	
	
	public function __construct(&$object, $method)
	{
		$this->_object = $object;
		$this->_method = $method;
	}
	
	
	public function bind($data)
	{
		$this->_object->{$this->_method}($data);
		
		return $data;
	}
}