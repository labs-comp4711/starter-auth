<?php
class Users extends MY_MODEL {
	
	public function __construct() {
		parent::__construct('users', 'id');
	}
}