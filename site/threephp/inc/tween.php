<?php 

class Tween extends THREE {
	
	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );

		$this->add( new Script( $this, '{ "path":"threephp/js/TweenMax.min.js", "region":"head" }' ) );

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "main" ):
			
			//$out .= "var objects = [], object;\n";
			//$out .= "TweenLite.ticker.addEventListener( 'tick', render );\n";

		endif;

		return $out;
	}

}

?>