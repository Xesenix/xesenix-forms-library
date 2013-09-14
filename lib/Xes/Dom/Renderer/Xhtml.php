<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Dom_Renderer_Xhtml implements Xes_Dom_Renderer_Interface
{
	/**
	 * List of tags that should be rendered with both open and close tags.
	 * TODO: add all other
	 * @var array
	 */
	protected $_blockTags = array('a', 'div', 'optgroup', 'option', 'p', 'select', 'span', 'textarea');
	
	
	/**
	 * Instance of renderer for xhtml nodes.
	 * Singleton pattern.
	 *
	 * @var Xes_Dom_Renderer_Xhtml
	 */
	protected static $_instance = null;
	
	
	/**
	 * Singleton pattern.
	 * 
	 * @result Xes_Dom_Renderer_Xhtml
	 */
	public static function getInstance()
	{
		if (self::$_instance === null)
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	
	protected function __construct()
	{
	}
	
	
	public function renderNode($tag, array $attributes = array(), $content = '')
	{
		if ($tag === null)
		{
			return $content;
		}
		
		$attr = $this->renderAttributes($attributes);
		
		if (empty($content) && !in_array($tag, $this->_blockTags))
		{
			$xhtml = "<$tag$attr/>\n";
		}
		else
		{
			$xhtml = "<$tag$attr>$content</$tag>\n";
		}
		
		return $xhtml;
	}
	
	
	public function renderAttributes(array $attributes)
	{
		$result = '';
		
		foreach($attributes as $key => $value)
		{
			if (is_string($value))
			{
				$result .= ' ' . $key . "=\"{$value}\"";
			}
			elseif ($key === 'class')
			{
				$result .= ' ' . $key . '="' . implode(' ', $value) . '"';
			}
			else
			{
				$result .= ' ' . $key . '="' . json_encode($value) . '"';
			}
		}
		
		return $result;
	}
	
	
	public function renderCssClasses(array $cssClasses)
	{
		if (empty($cssClasses))
		{
			return '';
		}
		
		return implode(' ', $cssClasses);
	}
}