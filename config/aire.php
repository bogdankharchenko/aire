<?php

return [
	
	/*
	|--------------------------------------------------------------------------
	| Default Grouping Behavior
	|--------------------------------------------------------------------------
	|
	| Elements that can be grouped (like <input> tags) are grouped by default.
	| You can disable this on an element-by-element basis by using the
	| `withoutGroup()` method, but if you would like to turn grouping off
	| by default, you can set this configuration value.
	|
	*/
	'group_by_default' => true,
	
	/*
	|--------------------------------------------------------------------------
	| Default Attributes
	|--------------------------------------------------------------------------
	|
	| If you would like to configure default attributes for certain elements,
	| you can do so here (for example, setting a <form>'s method to 'GET' by
	| default).
	|
	*/
	'default_attributes' => [
		'form' => [
			'method' => 'POST',
		],
	],
	
	/*
	|--------------------------------------------------------------------------
	| Default Classes
	|--------------------------------------------------------------------------
	|
	| If you would like to configure default CSS class names for certain elements,
	| you can do so here (for example, changing all <input> elements to have
	| the class .form-control for Bootstrap compatibility).
	|
	*/
	'default_classes' => [
		'input' => 'text-grey-darkest bg-white border rounded-sm',
	],
	
	/*
	|--------------------------------------------------------------------------
	| Validation Classes
	|--------------------------------------------------------------------------
	|
	| A grouped element can optionally have a validation state set. This can
	| be not validated, invalid, or valid. You can configure these class names
	| on an element-by-element basis here.
	|
	*/
	'validation_classes' => [
		
		/*
		|--------------------------------------------------------------------------
		| Not Validated
		|--------------------------------------------------------------------------
		|
		| These classes will be applied to elements that have not been validated.
		|
		*/
		'none' => [],
		
		/*
		|--------------------------------------------------------------------------
		| Valid
		|--------------------------------------------------------------------------
		|
		| These classes will be applied to elements that have passed validation.
		|
		*/
		'valid' => [
			'label' => 'text-green-dark',
			'input' => 'border-green-dark',
		],
		
		/*
		|--------------------------------------------------------------------------
		| Invalid
		|--------------------------------------------------------------------------
		|
		| These classes will be applied to elements that failed validation.
		|
		*/
		'invalid' => [
			'label' => 'text-red-dark',
			'input' => 'border-red-dark',
		],
	],
	
];
