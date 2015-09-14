<?php

class Accrual_policy extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'accrual_name' => 'required',
		'frequency' => 'required',
		'day_of_month' => 'required',
		'month' => 'required'
	);
}
