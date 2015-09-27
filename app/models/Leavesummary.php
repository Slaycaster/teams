<?php

class Leavesummary extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'employee_id' => 'required',
		'start_date' => 'required',
		'end_date' => 'required',
		'request_type' => 'required'
	);
}
