<?php

class Request_type extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'request_type' => 'required'
	);
}
