<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

interface Xes_Validator_Interface {
	
	
	function validate(Xes_Visitable_NodeInterface $element);
	
	
	function getErrorMessage();
}