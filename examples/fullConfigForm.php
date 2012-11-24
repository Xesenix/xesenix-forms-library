<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

include(__DIR__ . '/../vendor/autoload.php');

//Creating form
$form = new Xes_Form('test');

// ========== BUILDING FORM =============

$subform = new Xes_Form('subform');

$subform
->setTag(null) // disable form tag as it will be used as subform
->add(array('Xes_Form_Field_Select', 'size', array(
	'label' => 'I would choose',
	'options' => array(
		'1' => 'small',
		'2' => 'medium',
		'3' => 'large',
	),
	'value' => '1',
	'decorators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Decorator_FormFieldLabel', 'label', array(), array('position' => Xes_Decorator::APPEND)),
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors'), array('position' => Xes_Decorator::APPEND)),
	),
	'errorBubbling' => false,
)))
->add(array('Xes_Form_Field_Select', 'type', array(
	'label' => '',
	'options' => array(
		'1' => 'orange juice',
		'2' => 'cole',
	),
	'value' => '1',
	'decorators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors'), array('position' => Xes_Decorator::APPEND)),
	),
	'errorBubbling' => false,
)))
->add(array(null, 'xemail', array(
	'label' => 'Cancel e-mail',
	'attr' => array(
		'class' => 'email',
	),
	'formatters' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Formatter_NullToString', 'null'),
	),
	'validators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Validator_NotNull', 'Please fill with valid email addres.'),
		array('Xes_Validator_Email', 'Please fill with valid email addres.'),
	),
	'decorators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Decorator_Tag', 'value', 'div', array('class' => 'text-field-container'),),
		array('Xes_Decorator_FormFieldLabel', 'label', array('class' => 'label-class'), array('position' => Xes_Decorator::PREPEND)),
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors-list'), array('position' => Xes_Decorator::APPEND)),
		array('Xes_Decorator_Tag', 'container', 'div', array('class' => 'field w-4 float-left')),
	),
	'errorBubbling' => false,
)))
->getDecorator()
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'description1', // decorator id unique otherwise it can overrided exising one
		'p', // tag
		array(), // attributes
		'This is sub form.', // tag content
		array('position' => Xes_Decorator::PREPEND)// decorator options
	)
)
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'description2', // decorator id unique otherwise it can overrided exising one
		'div', // tag
		array('style' => 'padding: 8px; margin: 5px 0; border: 1px solid #ddd; background-color: #dfd; color: #444;'), // attributes
		'', // tag content
		array('position' => Xes_Decorator::OVERRIDE)// decorator options
	)
);

$form
->setAction('?validate')
->setMethod('POST')
->add(array(null, 'name', array(
	'label' => 'Name and Surname',
	'attr' => array(
		'class' => 'text-field',
	),
	'formatters' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Formatter_NullToString', 'null'),
	),
	'validators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Validator_NotNull', 'This param is required!'),
	),
	'decorators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Decorator_Tag', 'value', 'div', array('class' => 'text-field-container'),),
		array('Xes_Decorator_FormFieldLabel', 'label', array('class' => 'label-class'), array('position' => Xes_Decorator::PREPEND)),
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors-list'), array('position' => Xes_Decorator::APPEND)),
		array('Xes_Decorator_Tag', 'container', 'div', array('class' => 'field w-4 float-left')),
		array('Xes_Decorator_Tag', 'header2', 'h2', array(), 'But is a lot easier than in ZF!', array('position' => Xes_Decorator::PREPEND)),
		array('Xes_Decorator_Tag', 'header1', 'h1', array(), 'Strange Place for adding header!', array('position' => Xes_Decorator::PREPEND)),
	),
	'errorBubbling' => false,
)))
->add(array(null, 'email', array(
	'label' => 'Your e-mail',
	'attr' => array(
		'class' => 'email',
	),
	'formatters' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Formatter_NullToString', ''),
	),
	'validators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Validator_NotNull', 'Please fill with valid email addres.'),
		array('Xes_Validator_Email', 'Please fill with valid email addres.'),
	),
	'decorators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Decorator_Tag', 'value', 'div', array('class' => 'text-field-container'),),
		array('Xes_Decorator_FormFieldLabel', 'label', array('class' => 'label-class'), array('position' => Xes_Decorator::PREPEND)),
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors-list'), array('position' => Xes_Decorator::APPEND)),
		array('Xes_Decorator_Tag', 'container', 'div', array('class' => 'field w-4 float-left')),
	),
	'errorBubbling' => false,
)))
->add($subform)
->add(array('Xes_Form_Field_Checkbox', 'rules', array(
	'label' => 'I have read the rules.',
	'value' => '1',
	'attr' => array(
	),
	'validators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Validator_IsChecked', 'Acceptance of rules is required.')
	),
	'decorators' => array(// each array is equivalent for 'new param[0](param[1], param[2], ...)'
		array('Xes_Decorator_FormFieldLabel', 'label', array(), array('position' => Xes_Decorator::APPEND)),
		array('Xes_Decorator_Tag', 'container', 'div', array('class' => 'field w-4')),
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors'), array('position' => Xes_Decorator::APPEND)),
	),
	'errorBubbling' => false,
)))
->add(array('Xes_Form_Field_Submit', 'submit', array(
	'label' => 'Send',
	'attr' => array(
	),
)));

// ======= DECORATING =========

$form
->getDecorator()
->addDecorator(// example form config array
	array(// order as in class constructor
		'Xes_Decorator_FormFieldErrors', // special decorator class for handling fields errors
		'errors', // decorator id unique otherwise it can overrided exising one
		array('class' => 'errors'), // attributes
		array('position' => Xes_Decorator::APPEND)// decorator options
	)
)
->addDecorator(// example form config array
	array(// order as in class constructor
		'Xes_Decorator_Tag', // decorator class
		'description1', // decorator id unique otherwise it can overrided exising one
		'p', // tag
		array(), // attributes
		'Probably better place for adding things to form.', // tag content
		array('position' => Xes_Decorator::PREPEND)// decorator options
	)
)
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'description2', // decorator id unique otherwise it can overrided exising one
		'div', // tag
		array('style' => 'padding: 8px; background-color: #ffd; color: #444;'), // attributes
		'I hope this example shows most of thise little framework capabilities.', // tag content
		array('position' => Xes_Decorator::PREPEND)// decorator options
	)
);
// You can even get to some deper decorators and adjust them.
$form->email->getDecorator('label')
->addDecorator(
	array(// order as in class constructor
		'Xes_Decorator_Tag', // decorator class
		'special1', // decorator id unique otherwise it can overrided exising one
		'strong', // tag
		array(), // attributes
		'Special label decoration: ', // tag content
		array('position' => Xes_Decorator::PREPEND)// decorator options
	)
)
->addDecorator(
	array(// order as in class constructor
		'Xes_Decorator_Tag', // decorator class
		'special2', // decorator id unique otherwise it can overrided exising one
		'strong', // tag
		array(), // attributes
		'*', // tag content
		array('position' => Xes_Decorator::APPEND)// decorator options
	)
);

// ============= DATA FLOW HANDLING ==================

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

if ($request->getMethod() === 'POST')
{
	$form->setValue($request->request->get('test'));
	
	if ($form->isValid())
	{
		$form->getDecorator()->addDecorator(//example from adding decorator object
			new Xes_Decorator_Tag(
				'description3', // decorator id unique otherwise it can overrided exising one
				'div', // tag
				array('class' => 'valid-form', 'style' => 'padding: 4px; background-color: #0c0; color: #fff;'), // attributes
				'Everything is OK.', // tag content
				array('position' => Xes_Decorator::APPEND)// decorator options
			)
		);
	}
	else
	{
		$form->getDecorator()->addDecorator(//example from adding decorator object
			new Xes_Decorator_Tag(
				'description3', // decorator id unique otherwise it can overrided exising one
				'div', // tag
				array('class' => 'invalid-form', 'style' => 'padding: 4px; background-color: #c00; color: #fff;'), // attributes
				'You have some errors.', // tag content
				array('position' => Xes_Decorator::APPEND)// decorator options
			)
		);
	}
}

// ================= LOADING LAYOUT AND SENDING RESPONSE ==================
// laoyut
include('layout.php');

$response = new Response($form);
$response->setCharset('UTF-8');
$response->prepare($request);
$response->send();