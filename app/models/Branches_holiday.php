<?php

class Branches_holiday extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'branch_id' => 'required',
		'holiday_id' => 'required'
	);
}
