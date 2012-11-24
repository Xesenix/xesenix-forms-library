<?php 
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

// Layout builded by form decorators 

$form->getDecorator()
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'layout',// decorator id unique otherwise it can overrided exising one
		'div',// tag
		array('class' => 'layout'),// attributes
		'',// tag content
		array('position' => Xes_Decorator::OVERRIDE)// decorator options
	)
)
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'styles',// decorator id unique otherwise it can overrided exising one
		'style',// tag
		array('type' => 'text/css'),// attributes
<<<EOD

body {
	background-color: #def;
}

.layout {
	width: 600px;
	padding: 20px;
	margin: 20px auto;
	border: 1px solid #ddd;
	background-color: #fff;
}

\n
EOD
		,// tag content
		array('position' => Xes_Decorator::PREPEND)// decorator options
	)
)
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'body',// decorator id unique otherwise it can overrided exising one
		'body',// tag
		array(),// attributes
		'',// tag content
		array('position' => Xes_Decorator::OVERRIDE)// decorator options
	)
)
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'metaCharset',// decorator id unique otherwise it can overrided exising one
		'meta',// tag
		array('charset' => 'utf-8'),// attributes
		'',// tag content
		array('position' => Xes_Decorator::PREPEND)// decorator options
	)
)
->getDecorator('metaCharset')
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'title',// decorator id unique otherwise it can overrided exising one
		'title',// tag
		array(),// attributes
		'Full layout form test',// tag content
		array('position' => Xes_Decorator::APPEND)// decorator options
	)
)
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'head',// decorator id unique otherwise it can overrided exising one
		'head',// tag
		array(),// attributes
		'',// tag content
		array('position' => Xes_Decorator::OVERRIDE)// decorator options
	)
);

$form->getDecorator()
->addDecorator(//example from adding decorator object
	new Xes_Decorator_Tag(
		'html',// decorator id unique otherwise it can overrided exising one
		'html',// tag
		array(),// attributes
		'',// tag content
		array('position' => Xes_Decorator::OVERRIDE)// decorator options
	)
);