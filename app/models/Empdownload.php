<?php

class Empdownload extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'employee_id' => 'required',
		'file_name' => 'required',
		'path' => 'required'
	);
}
