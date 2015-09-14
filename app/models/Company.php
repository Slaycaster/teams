<?php

class Company extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'company_name' => 'required',
		'address' => 'required',
		'city' => 'required',
		'country' => 'required',
		'phone' => 'required'
	);
}
