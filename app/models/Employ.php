<?php

class Employ extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		
		'lname' => 'required',
		'fname' => 'required',
		'picture_path' => 'required',
		'street'=> 'required',
		'city' => 'required',
		'barangay' => 'required',
		'date_of_birth' => 'required',
		'phone' => 'required',
		'email' => 'required',
		'hire_date' => 'required',
		'status' => 'required',
		'qr_code' => 'required',
		'department_id' => 'required',
		'contract_id' => 'required',
		'jobtitle_id' => 'required'
		
	);
}
