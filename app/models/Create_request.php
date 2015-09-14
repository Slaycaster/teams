<?php

class Create_request extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'status' => 'required',
		'request_date' => 'required',
		'start_date' => 'required',
		'start_time' => 'required',
		'end_date' => 'required',
		'end_time' => 'required',
		'request_type' => 'required',
		
	);
}
