<?php

class Leave_grant extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'allowed_leave' => 'required',
		'grant_automatically' => 'required',
		'withrawable' => 'required'
	);
}
