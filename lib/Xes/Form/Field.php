<?php

class Xes_Form_Field extends Xes_Dom_Node implements Xes_Visitable_NodeInterface {
	
	
	protected $_tag = 'input';
	
	
	protected $_label = '';
	
	
	protected $_value = null;
	
	
	protected $_name;
	
	
	protected $_options = array();
	
	
	protected $_attributes = array();
	
	
	protected $_validators = array();
	
	
	protected $_errors = array();
	
	
	protected $_formatter = null;
	
	
	protected $_decorator;
	
	
	public function __construct($name, array $options = array())
	{
		parent::__construct($this->_tag);
		
		$this->setId($name);
		$this->setName($name);
		$this->_options = array_merge($this->getDefaultOptions(), $options);
		
		$this->_formatter = new Xes_Formatter('root');
		
		$this->_decorator = new Xes_Decorator_FormField('root');
		$this->_decorator->setField($this);
		
		if (isset($this->_options['label']))
		{
			$this->setLabel($this->_options['label']);
		}
		else
		{
			$this->setLabel($name);
		}
		
		if (isset($this->_options['formatters']))
		{
			$this->getFormatter()->setFormatters($this->_options['formatters']);
		}
		
		if (isset($this->_options['value']))
		{
			$this->setValue($this->_options['value']);
		}
		
		if (isset($this->_options['id']))
		{
			$this->_id = $this->_options['id'];
		}
		
		if (isset($this->_options['attr']))
		{
			foreach($this->_options['attr'] as $key => $value)
			{
				$this->setAttribute($key, $value);
			}
		}
		
		$this->_validators = array();
		$this->_errors = array();
		
		if (isset($this->_options['validators']))
		{
			$this->setValidators($this->_options['validators']);
		}
		
		if (isset($this->_options['decorators']))
		{
			$this->getDecorator()->setDecorators($this->_options['decorators']);
		}
	}
	
	
	public function setParent(&$parent)
	{
		$this->_parent = $parent;
		
		return $this;
	}
	
	
	// FormField methods
	
	public function setName($name)
	{
		$this->_name = $name;
		
		return $this;
	}
	
	
	public function getFullName()
	{
		return $this->_parent != null ? ($this->_parent->getFullName() . '[' . $this->getName() . ']') : $this->getName();
	}
	
	
	public function getName()
	{
		return $this->_name;
	}
	
	
	public function setLabel($value)
	{
		$this->_label = $value;
		
		return $this;
	}
	
	
	public function getLabel()
	{
		return $this->_label;
	}
	
	
	public function getFullId()
	{
		return $this->_parent != null ? ($this->_parent->getFullId() . '_' . $this->getId() ) : $this->getId();
	}
	
	
	public function setValue($value)
	{
		$this->_value = $value;
		
		return $this;
	}
	
	
	public function getValue()
	{
		return $this->_value;
	}
	
	
	public function setValidators($validators)
	{
		$this->_validators = $validators;
		
		return $this;
	}
	
	
	public function getValidators()
	{
		foreach ($this->_validators as $key => $validator)
		{
			if (!$validator instanceof Xes_Validator_Interface)
			{
				$reflection = new ReflectionClass($validator[0]);
				
				array_shift($validator);
				
				$this->_validators[$key] =  $reflection->newInstanceArgs($validator);
			}
		}
		
		return $this->_validators;
	}
	
	
	public function addValidator($validator)
	{
		$this->_validators[] = $validator;
		
		return $this;
	}
	
	
	public function isValid()
	{
		$this->clearErrors();
		
		foreach ($this->getValidators() as $validator)
		{
			if (!$validator->validate($this))
			{
				$this->addError($validator->getErrorMessage());
				$this->addCssClass('error');
				
				return false;
			}
		}
		
		return true;
	}
	
	
	public function addError($error)
	{
		if (isset($this->_options['errorBubbling']) && $this->_options['errorBubbling'] && $this->_parent != null)
		{
			$this->_parent->addError($error);
		}
		else
		{
			$this->_errors[] = $error;
		}
		
		return $this;
	}
	
	
	public function hasErrors()
	{
		return !empty($this->_errors);
	}
	
	
	public function clearErrors()
	{
		$this->_errors = array();
		
		return $this;
	}
	
	
	public function getErrors()
	{
		return $this->_errors;
	}
	
	
	public function renderErrors()
	{
		$errors = '';
		
		if (!empty($this->_errors))
		{
			$errors = '<ul>';
			foreach($this->_errors as $error)
			{
				$errors .= '<li>' . $error . '</li>';
			}
			$errors .= '</ul>';
		}
		
		return $errors;
	}
	
	
	public function setFormatter(Xes_Formatter_Interface &$formatter)
	{
		$this->_formatter = $formatter;
		
		return $this;
	}
	
	
	public function &getFormatter()
	{
		return $this->_formatter;
	}
	
	
	public function setDecorator(Xes_Decorator_Intreface &$decorator)
	{
		$this->_decorator = $decorator;
		
		return $this;
	}
	
	
	public function getDecorator($name = null)
	{
		if ($name !== null)
		{
			return $this->_decorator->getDecorator($name);
		}
		
		return $this->_decorator;
	}
	
	
	public function getDefaultOptions()
	{
		return array(
			'type' => 'text',
			'errorBubbling' => true,
		);
	}
	
	
	public function render()
	{
		$value = $this->getValue();
		$value = $this->_formatter->format($value);
		
		$tag = $this->getTag();
		$id = $this->getFullId();
		$name = $this->getFullName();
		$options = $this->_options;
		$attributes = array_merge(
			$this->getAttributes(),
			array(
				'id' => $this->getFullId(),
				'type' => $options['type'],
				'name' => $this->getFullName(),
				'value' =>  $value,
			)
		);
		
		return $this->_renderer->renderNode($tag, $attributes);
	}
	
	
	public function __toString()
	{
		$content = $this->render();
		
		$content = $this->_decorator->decorate($content);
		
		return $content;
	}
}
