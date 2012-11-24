<?php
/**
 * @author Xesenix Paweł Kapalla <pkapalla@xesenix.pl>
 * @copyright Copyright (c) 2010, Xesenix Paweł Kapalla - all rights reserved.
 */

class Xes_Dom_Renderer_Xhtml implements Xes_Dom_Renderer_Interface {
	
	
	protected static $_instance = null;
	
	
	public static function getInstance()
	{
		if (self::$_instance === null)
		{
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	
	public function renderNode($tag, array $attributes = array(), $content = '')
	{
		$attr = $this->renderAttributes($attributes);
		
		if (empty($content))
		{
			$xhtml = "<$tag$attr/>";
		}
		else
		{
			$xhtml = "<$tag$attr>$content</$tag>";
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