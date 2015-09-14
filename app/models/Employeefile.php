<?php

class Employeefile extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'file_name' => 'required',
		'path' => 'required',
		'employee_id' => 'required'
	);
}
