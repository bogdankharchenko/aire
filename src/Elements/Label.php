<?php

namespace Galahad\Aire\Elements;

use Galahad\Aire\Aire;

class Label extends \Galahad\Aire\DTD\Label
{
	/**
	 * @var \Galahad\Aire\Elements\Group
	 */
	public $group;
	
	public function __construct(Aire $aire, Group $group = null)
	{
		parent::__construct($aire);
		
		$this->group = $group;
	}
	
	public function text($text) : self
	{
		$this->view_data['text'] = $text;
		
		return $this;
	}
}
