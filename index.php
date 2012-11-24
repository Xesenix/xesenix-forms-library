<?php

include(__DIR__ . '/vendor/autoload.php');

$form = new Xes_Form('test');

$form
->setAction('?send')
->setMethod('POST')
->add('name', null, array(
	'label' => 'Imię i nazwisko',
	'attr' => array(
		'class' => 'kod-promocyjny',
	),
	'formatters' => array(
		array('Xes_Formatter_NullToString', 'null'),
	),
	'validators' => array(
		array('Xes_Validator_NotNull', 'Podaj kod promocyjny.'),
	),
	'decorators' => array(
		array('Xes_Decorator_Tag', 'value', 'div', array('class' => 'text-field'),),
		array('Xes_Decorator_FormFieldLabel', 'label', array(), array('position' => Xes_Decorator::PREPEND)),
		array('Xes_Decorator_Tag', 'container', 'div', array('class' => 'field w-4')),
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors'), array('position' => Xes_Decorator::APPEND)),
	),
	'errorBubbling' => false,
))
->add('email', null, array(
	'label' => 'Twój e-mail',
	'attr' => array(
		'class' => 'email-promocyjny',
	),
	'validators' => array(
		array('Xes_Validator_NotNull', 'Proszę podać swój adres e-mail.'),
		array('Xes_Validator_Email', 'Proszę podać adres e-mail w prawidłowym formacie.'),
	),
	'decorators' => array(
		array('Xes_Decorator_Tag', 'value', 'div', array('class' => 'text-field'),),
		array('Xes_Decorator_FormFieldLabel', 'label', array(), array('position' => Xes_Decorator::PREPEND)),
		array('Xes_Decorator_Tag', 'container', 'div', array('class' => 'field w-4')),
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors'), array('position' => Xes_Decorator::APPEND)),
	),
	'errorBubbling' => false,
))
->add('regulamin', 'Xes_Form_Field_Checkbox', array(
	'label' => 'Zapoznałem się z regulaminem zakupu',
	'value' => '1',
	'attr' => array(
	),
	'validators' => array(
		array('Xes_Validator_IsChecked', 'Akceptacja regulaminu jest wymagana.')
	),
	'decorators' => array(
		array('Xes_Decorator_FormFieldLabel', 'label', array(), array('position' => Xes_Decorator::APPEND)),
		array('Xes_Decorator_Tag', 'container', 'div', array('class' => 'field w-4')),
		array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors'), array('position' => Xes_Decorator::APPEND)),
	),
	'errorBubbling' => false,
))
->add('submit', 'Xes_Form_Field_Submit', array(
	'label' => 'Wyślij',
	'attr' => array(
	),
));

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

if ($request->getMethod() === 'POST')
{
	$form->setData($request->request->all());
	$form->isValid();
}

/*echo 'data';
var_dump($request->request->all());
echo 'method';
var_dump($request->getMethod());
echo 'ajax';
var_dump($request->isXmlHttpRequest());
echo 'valid';
var_dump($form->isValid());*/

$form->getDecorator()->addDecorator(array('Xes_Decorator_FormFieldErrors', 'errors', array('class' => 'errors'), array('position' => Xes_Decorator::APPEND)));

$response = new Response($form);
$response->setCharset('UTF-8');
$response->prepare($request);
$response->send();