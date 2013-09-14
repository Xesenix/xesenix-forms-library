<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

interface Xes_Visitable_NodeInterface
{
	function getAttribute($name);
	
	
	function setAttribute($name, $value);
}