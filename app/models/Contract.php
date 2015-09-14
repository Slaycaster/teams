<?php

class Contract extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'contract_name' => 'required',
		'duration' => 'required'
	);
}
