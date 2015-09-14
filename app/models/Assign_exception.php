<?php

class Assign_exception extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'group_id' => 'required',
		'exception_id' => 'required'
	);
}
