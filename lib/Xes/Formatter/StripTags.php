<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Formatter_StripTags extends Xes_Formatter implements Xes_Formatter_Interface
{
	/**
	 * Tags to strip out all if empty.
	 * @var array
	 */
	protected $_allowedTags;
	
	
	public function __construct($name, array $allowed = array())
	{
		parent::__construct($name);
		
		$this->setAllowedTags($allowed);
	}
	
	
	public function setAllowedTags($value)
	{
		$this->_allowedTags = $value;
		
		return $this;
	}
	
	
	public function getAllowedTags()
	{
		return $this->_allowedTags;
	}
	
	
	public function format($value)
	{
		$allowed = $this->getAllowedTags();
		$allowedTags = '';
		
		if (!empty($allowed))
		{
			$allowedTags = '<' . implode('><', $allowed) . '>';
		}
		
		return strip_tags($value, $allowedTags);
	}
}