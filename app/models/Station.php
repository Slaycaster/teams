<?php

class Station extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'status' => 'required',
		'station_name' => 'required',
		'type' => 'required',
		'source' => 'required',
		'branch_id' => 'required'
	);
}
