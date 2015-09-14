<?php

class Break_policy extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'break_name' => 'required',
		'type' => 'required',
		'active_after' => 'required',
		'autodetect_breaksby' => 'required'
	);
}
