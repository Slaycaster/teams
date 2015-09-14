<?php

class Overtime_subordinate extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'overtime_id' => '',
		'employee_id' => 'required',
		'active_after' => '',
		'Allowed_number_of_hours' =>'',
		'range_from' =>'required',
		'range_to' => 'required'
	);
}
