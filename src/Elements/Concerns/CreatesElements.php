<?php

namespace Galahad\Aire\Elements\Concerns;

use Galahad\Aire\Elements\Button;
use Galahad\Aire\Elements\Element;
use Galahad\Aire\Elements\Input;
use Galahad\Aire\Elements\Label;
use Galahad\Aire\Elements\Textarea;

trait CreatesElements
{
	public function label(string $label) : Label
	{
		return (new Label($this->aire))->text($label);
	}
	
	public function button(string $label) : Button
	{
		return $this->injectDefaultValue(
			(new Button($this->aire, $this))->label($label)
		);
	}
	
	public function submit(string $label) : Button
	{
		return $this->button($label)->type('submit');
	}
	
	public function input($name = null, $label = null) : Input
	{
		$input = new Input($this->aire, $this);
		
		if ($name) {
			$input->name($name);
		}
		
		if ($label) {
			$input->label($label);
		}
		
		return $this->injectDefaultValue($input);
	}
	
	public function textarea($name = null, $label = null) : Textarea
	{
		$input = new Textarea($this->aire, $this);
		
		if ($name) {
			$input->name($name);
		}
		
		if ($label) {
			$input->label($label);
		}
		
		return $this->injectDefaultValue($input);
	}
	
	/**
	 * Inject the default value for an element
	 *
	 * @param \Galahad\Aire\Elements\Element $element
	 * @return mixed
	 */
	protected function injectDefaultValue($element)
	{
		return tap($element, function(Element $element) {
			if (null !== $element->getAttribute('value')) {
				return;
			}
			
			if (!method_exists($element, 'value')) {
				return;
			}
			
			if (!$name = $element->getAttribute('name')) {
				return;
			}
			
			$default = $this->defaults->get($name);
			
			if (null !== $default) {
				$element->value($default);
			}
		});
	}
}