<?php

class Credit_policy extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'description' => 'required',
		'leave_type' => 'required',
		
	);
}
