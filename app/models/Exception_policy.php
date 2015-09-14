<?php

class Exception_policy extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'exceptiongroup_name'=> 'required',
		'is_active' => 'required',
		'code' => 'required',
		'exception_name' => 'required',
		'severity' => 'required',
		'email_notification' => 'required'
	);
}
