<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

include(__DIR__ . '/../vendor/autoload.php');

/**
 * Example of using DOM node elements.
 */

// ========================
// building simple nodes:
// ========================

$page = new Xes_Dom_Node('html');
$page->append(array('Xes_Dom_Node', 'head'));
$page->get(0)
	->append(array('Xes_Dom_Node', 'meta', array('encoding' => 'UTF-8')))
	->append(array('Xes_Dom_Node', 'title', array(), 'Xes_Dom_Model example'))
	->append(array('Xes_Dom_Node', 'meta', array('author' => 'Paweł Kapalla, Xesenix')));
$page->append(array('Xes_Dom_Node', 'body'));

$header = new Xes_Dom_Node('div', array('style' => 'width: 940px; margin: 10px auto; padding: 20px;'));
$header->getDecorator()
	->setDecorators(array(
		array('Xes_Decorator_Tag', 'top-bar', 'header', array('style' => 'width: 100%; margin: 0 auto 20px; background-color: #f8f8f8;'), null, array('position' => Xes_Decorator::OVERRIDE))
	));

$content = new Xes_Dom_Node('div', array('style' => 'width: 940px; margin: 0px auto 0px; padding: 10px;'));

$page->get(1)
	->append($header);

$title = new Xes_Dom_Node('h1', array(), 'Xes_Dom_Node examples');
$subtitle = new Xes_Dom_Node('h2', array(), 'Testing various method of using Xes_Dom_Node and DOM node decorators');
$sectionTitle = new Xes_Dom_Node('h3', array('style' => 'border-bottom: 1px solid #ddd;'));
$sectionDesc = new Xes_Dom_Node('p');

$section = new Xes_Dom_Node('section', array('style' => 'margin: 20px auto 20px; padding: 20px;'));
$article = new Xes_Dom_Node('article', array('style' => 'margin: 20px auto 20px; padding: 20px;'));
$article->getDecorator()
	->setDecorators(array(
		array('Xes_Decorator_Node', 'section-desc', $sectionDesc, array('position' => Xes_Decorator::PREPEND))
	));

$section->set($sectionTitle)->append($article);
$content->set($section);

$header->append($title);
$header->append($subtitle);

$data = array(
	array('label' => 'Test label 1', 'value' => 'A'),
	array('label' => 'Test label 2', 'value' => 'B'),
	array('label' => 'Test label 3', 'value' => 'C'),
);

$p = new Xes_Dom_Node('p', array('style' => 'color: green;'), 'Some simple example od &lt;p&gt; node');
$container = new Xes_Dom_Node('div', array('style' => 'padding: 4px; border: 1px solid #000; background-color: #ffa;'));

foreach ($data as $item)
{
	$label = new Xes_Dom_Node('label', array(), $item['label']);
	$container->append($label);
	
	$value = new Xes_Dom_Node('span', array('style' => 'color: blue; font-weight: bold; font-size: 24pt;'), $item['value']);
	$label->prepend($value);
}

$select = new Xes_Dom_Node('select', array('name' => 'test_select'));

foreach ($data as $item)
{
	$option = new Xes_Dom_Node('option', array('value' => $item['value']), $item['label']);
	$select->append($option);
}

$container->append($select);
$article->set($p)->append($container);

$sectionTitle->set('Simple test');
$sectionDesc->set('Creating container and appending it with labels prepended by spans.');

$page->get(1)->append('render pass 1:<hr/>' . $content->render());

// ========================
// something more advanced:
// ========================

// === template node - initialization ===


$li = new Xes_Dom_Node('li', array(), '%pos%(item %id%)');

$ul = new Xes_Dom_Node('ul');
// rememmber to clone if its an template node
$ul->append(clone $li);
$ul->append(clone $li);
$ul->append(clone $li);
// equivalent creating new item by calling new 
$ul->prepend(new Xes_Dom_Node('li', array(), '%pos%(new item %id%)'));
// or by passing config array (first element is className any additional are pushed as arguments for constructor)
$ul->append(array('Xes_Dom_Node', 'li', array(), '%pos%(special item %id%)'));

// setting content to render list
$article->set($ul);

// adding decorator for rendering of template list
$ul->getDecorator()
	->setDecorators(array(
		array('Xes_Decorator_Tag', 'template-list', 'div', array('style' => 'padding: 10px; background-color: #000; color: #eee;'), null, array('position' => Xes_Decorator::OVERRIDE))
	));

$sectionTitle->set('Creating template node structure for list');
$sectionDesc->set('Creating list tamplate. Remember to clone template nodes if you don`t want to have dependencies between them.');
// rendering list without modifications
$page->get(1)->append('render pass 2:<hr/>' . $content->render());

// removing decorator after rendering of template list
$ul->getDecorator()
	->removeDecorator('template-list');

// === template node - random modifications ===

$i = 0;
$children = $ul->getContent();

foreach ($children as $key => $child)
{
	$template = $child->getContent()->render();
	$child->set(array('Xes_Dom_Node', 'strong', array(), str_replace(array('%id%', '%pos%'), array('B' . ++$i, 'set'), $template)));
	$child->append(array('Xes_Dom_Node', null, array(), str_replace(array('%id%', '%pos%'), array('C' . ++$i, 'append'), $template)));
	$child->prepend(array('Xes_Dom_Node', null, array(), str_replace(array('%id%', '%pos%'), array('A' . ++$i, 'prepend'), $template)));
	
	$color = dechex(rand() % 16) . dechex(rand() % 16) . dechex(rand() % 16) . dechex(rand() % 16) . dechex(rand() % 16) . dechex(rand() % 16);
	
	$child
		->get(0)
		->getDecorator()
		->addDecorators(array(
			array('Xes_Decorator_Tag', 'em', 'em', array('style' => 'color: #' . $color . ';'), null, array('position' => Xes_Decorator::OVERRIDE)),
		));
	
	// copy current list and add it as sublist with 60% chance
	if (rand() % 50 > 20)
	{
		$sublist = clone $ul;
		$sublist->pop();
		$child->append($sublist);
	}
}

$sectionTitle->setContent('Modifing and randomizing display of template list');
$sectionDesc->set(null);
// rendering list with modifications
$page->get(1)->append('render pass 3:<hr/>' . $content->render());

echo $page;
