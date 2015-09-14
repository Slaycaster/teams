<?php

class Level extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'number' => 'required',
		'name' => 'required',
		'description' => 'required'
	);
}
