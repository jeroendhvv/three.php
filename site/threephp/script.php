<?php

class Script extends THREE {
	
	var $path;
	var $region;
	
	function __construct( $parent=null, $params_json="" ){
		
		$this->path = "";
		$this->region = "";	

		parent::__construct( $parent, $params_json );

	}

	function render( $region="" ){
		
		$out = "";


		if( $this->region == $region ):

			$out .= "<script src='" . $this->path . "'></script>\n";

		endif;
		
		return $out;

	}

}