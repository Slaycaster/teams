<?php

class Download extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'file_name' => 'required',
		'path' => 'required'
	);
}
