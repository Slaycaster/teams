<?php

class Premium_policy extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'premium_name' => 'required',
	);
}
