<?php

class Attendance extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'employee_name' => 'required',
		'attendance_time' => 'required',
		'attendance_date' => 'required',
		'punch_type' => 'required',
		'in_out' => 'required'
	);
}
