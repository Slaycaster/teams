<?php

class LeaveCredit extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'employee_id' => 'required',
		'sick_leave' => 'required',
		'vacation_leave' => 'required'
	);
}
