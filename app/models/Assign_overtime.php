<?php

class Assign_overtime extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'range_from' => 'required',
		'range_to' => 'required',
		'overtime_id' => 'required',
		
	);
}
