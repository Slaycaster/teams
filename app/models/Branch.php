<?php

class Branch extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'branch_name' => 'required',
		'status' => 'required',
		'code' => 'required',
		'address' => 'required',
		'city' => 'required',
		'country' => 'required',
		'email' => 'required'
	);
}
