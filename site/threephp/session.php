<?php

class Session extends THREE {
	
	var $cookie;

	function __construct( $parent=null, $params_json="" ){
			
		parent::__construct( $parent, $params_json );

		if( isset( $_COOKIE["threephp"] ) ):
			$this->cookie = $_COOKIE["threephp"];
		else:
			$this->cookie = md5( uniqid( rand(), true ) );
			setcookie( "threephp", $this->cookie, 0, "/" );
		endif;

	}

	function render( $region="" ){

		$out = "";
		return $out;

	}
}