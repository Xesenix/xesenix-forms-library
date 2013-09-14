<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

interface Xes_Tree_Node_Interface
{
	public function set($config);
	
	
	public function prepend($config);
	
	
	public function append($config);
	
	
	public function get($name);
}