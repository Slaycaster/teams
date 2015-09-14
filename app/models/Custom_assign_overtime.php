<?php

class Custom_assign_overtime extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'active_after' => 'required',
		'Allowed_number_of_hours' => 'required',
		'name' => 'required',
		'range_from' => 'required',
		'range_to' => 'required',
		'employee_id' => 'required'
	);
}
