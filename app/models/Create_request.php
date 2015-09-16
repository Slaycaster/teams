<?php

class Create_request extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'status' => 'required',
		'request_date' => 'required',
		'start_date' => 'required',
		
		'end_date' => 'required',
		
		'request_type' => 'required',
		
	);
}
