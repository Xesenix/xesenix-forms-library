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

It's in early stage of development but can be quite usefull see examples.

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
	->add(array(null, 'formFieldName', array(// if passed null default class Xes_Form_Field is used 
		'label' => 'Value used as field label',
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
			array('Xes_Decorator_Tag', 'value', 'div', array('class' => 'input-field-container-class'),),
			array('Xes_Decorator_FormFieldLabel', 'label', array('class' => 'label-class'), array('position' => Xes_Decorator::PREPEND)), // for displaying label
			array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors-list-class'), array('position' => Xes_Decorator::APPEND)), // for displaying errors
			array('Xes_Decorator_Tag', 'header', 'h3', array('class' => 'strange-header-class'), 'Strange Place for adding header!', array('position' => Xes_Decorator::PREPEND)), // field will be prepended with header tag
			array('Xes_Decorator_Tag', 'fieldset', 'div', array('class' => 'full-composited-field-class'), 'Will be ignored as position is override', array('position' => Xes_Decorator::OVERRIDE)), // field will be embraced with div tag
		),
		'errorBubbling' => false, // if errors should be pass to parent element
	)));

Or alternatively (equivalent of above method):

	$form
	->add(new Xes_Form_Field('formFieldName', array(
		'label' => 'Value used as field label',
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
			new Xes_Decorator_Tag('value', 'div', array('class' => 'input-field-container-class'),),
			new Xes_Decorator_FormFieldLabel('label', array('class' => 'label-class'), array('position' => Xes_Decorator::PREPEND)), // for displaying label
			new Xes_Decorator_FormFieldErrors('errors', array('class' => 'errors-list-class'), array('position' => Xes_Decorator::APPEND)), // for displaying errors
			new Xes_Decorator_Tag('header', 'h3', array('class' => 'strange-header-class'), 'Strange Place for adding header!', array('position' => Xes_Decorator::PREPEND)), // field will be prepended with header tag
			new Xes_Decorator_Tag'('fieldset', 'div', array('class' => 'full-composited-field-class'), 'Will be ignored as position is override', array('position' => Xes_Decorator::OVERRIDE)), // field will be embraced with div tag
		),
		'errorBubbling' => false, // if errors should be pass to parent element
	)));

To change form elements you can ask for them by their formFieldName or decoratorName

	$form->formFieldName->getDecorator('decoratorName')->getNode()->addCssClass('another-css-class');

In this way you can even add decorators that will decorate decorator base output (I don't know if it's even posible in Zend Framework):

	$form->formField
	->getDecorator()
	->setDecorators(// those decorators are for form field
		array(
			array('Xes_Decorator_Tag', 'tag1', 'div', array('class' => 'field-decorator-1'),),// default override
			array('Xes_Decorator_FormFieldLabel', 'label', array('class' => 'field-decorator-2'), array('position' => Xes_Decorator::PREPEND)), // for displaying label
			array('Xes_Decorator_Tag', 'tag2', 'div', array('class' => 'field-decorator-3'),),// default override
		)
	)
	->getDecorator('label')// those decorators are for label not for form field
	->setDecorators(
		array(
			array('Xes_Decorator_Tag', 'star', 'div', array('class' => 'label-decorator-1'), '*', array('position' => Xes_Decorator::APPEND)),// default override
			array('Xes_Decorator_Tag', 'tag', 'div', array('class' => 'label-decorator-2')),// default override
		)
	);

This will result in:

	<div class="field-decorator-3">
		<div class="label-decorator-2">
			<label class="field-decorator-2" for="fieldId">Value of field label</label>
			<span class="label-decorator-1">*</span>
		</div>
		<div class="field-decorator-1">
			<input type="text" name="formField" value="value of field"/>
		</div>
	</div>

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
	$form->isValid(); // returns true if data is valid form must be first populated with data by using setValue

TODO
---------------------

* Add more field and validator types.
* Easier way to group fields.
* Add path access for fields and decorators.
* Add some multilanguage support.
* Build helper classes for fast building form fields. 
* Build serialization and deserialization helpers.