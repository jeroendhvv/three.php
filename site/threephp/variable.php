<?php

class Variable {
	
	var $value;

	function __construct( $parent=null, $params_json="" ){
	
		$this->value = "";	

		parent::__construct( $parent, $params_json );

	}

}