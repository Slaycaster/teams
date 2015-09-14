<?php

class Exception_group extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'exceptiongroup_name' => 'required'
	
	);
}
