<?php

class Jobtitle extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'jobtitle_name' => 'required'
	);
}
