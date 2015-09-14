<?php

class Overtime_policy extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'overtime_name' => 'required',
		'active_after' => 'required'
	);
}
