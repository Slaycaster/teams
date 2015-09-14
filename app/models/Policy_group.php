<?php

class Policy_group extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'policygroup_name' => 'required'
	);
}
