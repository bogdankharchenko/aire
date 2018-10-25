<?php

namespace Galahad\Aire\Elements\Attributes;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class Attributes implements Htmlable, ArrayAccess, Arrayable
{
	/**
	 * Attributes to except when generating HTML
	 *
	 * @var array
	 */
	protected $except = [];
	
	/**
	 * @var callable
	 */
	protected $attribute_listener;
	
	/**
	 * @var array
	 */
	protected $items;
	
	/**
	 * Callbacks to mutate attribute values
	 *
	 * @var array
	 */
	protected $mutators = [];
	
	public function __construct(array $items, callable $attribute_listener)
	{
		$this->items = $items;
		
		$this->attribute_listener = $attribute_listener;
	}
	
	public function registerMutator(string $attribute, callable $mutator) : self
	{
		$this->mutators[$attribute] = $mutator;
		
		return $this;
	}
	
	public function get($key, $default = null)
	{
		if ($this->offsetExists($key)) {
			return $this->offsetGet($key);
		}
		
		return value($default);
	}
	
	public function has($key) : bool
	{
		return $this->offsetExists($key);
	}
	
	public function set($key, $value) : self
	{
		$this->offsetSet($key, $value);
		
		return $this;
	}
	
	public function offsetExists($key) : bool
	{
		return isset($this->items[$key]);
	}
	
	public function offsetGet($key)
	{
		$value = $this->items[$key];
		
		if (isset($this->mutators[$key])) {
			$value = call_user_func($this->mutators[$key], $value);
		}
		
		return $value;
	}
	
	public function offsetSet($key, $value) : void
	{
		if ('class' === $key) {
			$this->items['class']->set($value);
		} else {
			$this->items[$key] = $value;
		}
		
		call_user_func($this->attribute_listener, $key, $value);
	}
	
	public function offsetUnset($key) : void
	{
		unset($this->items[$key]);
		
		call_user_func($this->attribute_listener, $key, null);
	}
	
	public function except(...$keys) : self
	{
		$this->except = array_merge($this->except, $keys);
		
		return $this;
	}
	
	public function toHtml() : string
	{
		return $this->toCollection()
			->except($this->except)
			->filter(function($value) {
				return false !== $value && null !== $value;
			})
			->map(function($value, $name) {
				if (true === $value) {
					return $name;
				}
				
				$name = strtolower($name);
				$value = e($value);
				
				return "{$name}=\"{$value}\"";
			})
			->implode(' ');
	}
	
	public function toCollection() : Collection
	{
		return new Collection($this->toArray());
	}
	
	/**
	 * Get the instance as an array.
	 *
	 * @return array
	 */
	public function toArray() : array
	{
		$array = $this->items;
		
		$keys_to_mutate = array_intersect(array_keys($array), array_keys($this->mutators));
		
		foreach ($keys_to_mutate as $key) {
			$array[$key] = $this->offsetGet($key);
		}
		
		return $array;
	}
}
