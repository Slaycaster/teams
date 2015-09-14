<?php

class Empschedule extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'schedule_id' => 'required'
	);
}
