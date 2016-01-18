<?php

class User extends THREE {
	
	var $username;
	var $password;

	function __construct( $parent=null, $params_json="" ){
		
		parent::__construct( $parent, $params_json );

	}

	function render( $region="" ){

		$out = "";
		return $out;

	}
}