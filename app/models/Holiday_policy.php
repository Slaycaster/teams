<?php

class Holiday_policy extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'holiday_name' => 'required',
		'default_schedule_status' => 'required',
		'holiday_type'=>'required'
	);
}
