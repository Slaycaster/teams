<?php

class Hierarchy extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'hierarchy_name' => 'required'
	);
}
