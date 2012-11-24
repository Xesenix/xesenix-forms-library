Xesenix Forms Library
====================

About
---------------------

Its a micro framework for creating forms in php.
To start using just download run composer for adding dependencies and class autoloader.


How to start
---------------------

First download this project second run composer to install dependencies:

	./php composer.phar install

When finished go see examples.


Example
---------------------

It`s in early stage of development but can be quite usefull see examples.

	<?php
	// autoloader and request handling may be altered if you run it from diffrent path then examples are placed.
	include(__DIR__ . '/../vendor/autoload.php');
	
	$form = new Xes_Form('formNameUsedAssNamespaceForItsData');

For main form (not subforms) you should setup action and method. 

	$form
	->setAction('?validate')
	->setMethod('POST');

If you want create subform you can do it something like that:

	$subform = new Xes_Form('subform');
	$subform->setTag(null); // disable form tag as it will be used as subform
	$form->add($subform);

Next you can assemble your form elements. Its very similar to forms in ZendFramework.

	$form
	->add(array(null, 'name', array(
		'label' => 'Name and Surname',
		'attr' => array(
			'class' => 'text-field', // those attributes are used by form
		),
		'formatters' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
			array('Xes_Formatter_NullToString', ''), // converts field element value to string 
		),
		'validators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
			array('Xes_Validator_NotNull', 'This param is required!'), // used for form validation
		),
		'decorators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
			array('Xes_Decorator_Tag', 'value', 'div', array('class' => 'text-field-container'),),
			array('Xes_Decorator_FormFieldLabel', 'label', array('class' => 'label-class'), array('position' => Xes_Decorator::PREPEND)), // for displaying label
			array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors-list'), array('position' => Xes_Decorator::APPEND)), // for displaying errors
			array('Xes_Decorator_Tag', 'header', 'h3', array(), 'But is a lot easier than in ZF!', array('position' => Xes_Decorator::PREPEND)), // field will be prepended with header tag
			array('Xes_Decorator_Tag', 'fieldset', 'div', array(), 'Strange Place for adding header!', array('position' => Xes_Decorator::OVERRIDE)), // field will be embraced with div tag
		),
		'errorBubbling' => false, // if errors should be pass to parent element
	)));

Or alternatively (equivalent of above method):

	$form
	->add(new Xes_Form_Field('name', array(
		'label' => 'Name and Surname',
		'attr' => array(
			'class' => 'text-field', // those attributes are used by form
		),
		'formatters' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
			new Xes_Formatter_NullToString(''), // converts field element value to string 
		),
		'validators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
			new Xes_Validator_NotNull('This param is required!'), // used for form validation
		),
		'decorators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
			new Xes_Decorator_Tag('value', 'div', array('class' => 'text-field-container'),),
			new Xes_Decorator_FormFieldLabel('label', array('class' => 'label-class'), array('position' => Xes_Decorator::PREPEND)), // for displaying label
			new Xes_Decorator_FormFieldErrors('errors', array('class' => 'errors-list'), array('position' => Xes_Decorator::APPEND)), // for displaying errors
			new Xes_Decorator_Tag('header', 'h3', array(), 'But is a lot easier than in ZF!', array('position' => Xes_Decorator::PREPEND)), // field will be prepended with header tag
			new Xes_Decorator_Tag'('fieldset', 'div', array(), 'Strange Place for adding header!', array('position' => Xes_Decorator::OVERRIDE)), // field will be embraced with div tag
		),
		'errorBubbling' => false, // if errors should be pass to parent element
	)));
 
 To populate form with data and validate it.
 
	$data = array(
		'mainFormFieldName1' => 1,
		'mainFormFieldName2' => 'asdfs',
		...,
		'subFormFieldName' => array(
			'subFormFieldName1' => 1,
			'subFormFieldName2' => 'zxc',
			...,
			'subsubFormFieldName' => array(
				'subsubFormFieldName1' => 1,
				'subsubFormFieldName2' => 'zxc',
				...,
			),
		),
	);
	$form->setValue($data); // populates form with data
	$form->isValid(); // returns true if data is valid form must be first populated width data by using setValue
 
TODO
---------------------

* Build helper classes for fast building form fields. 
* Build serialization and deserialization helpers.