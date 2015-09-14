<?php

class Department extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'name' => 'required',
		'code' => 'required',
		'status' => 'required',
		'branch_id' => 'required'
	);
}
