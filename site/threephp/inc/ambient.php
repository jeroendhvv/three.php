<?php 

class Ambient extends THREE {
	
	var $color;

	function __construct( $parent=null, $params_json="" ){

		$this->color = 0x666666;

		parent::__construct( $parent, $params_json );

	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
			
			$out .= "var Ambient = function( threephp ){\n";
			$out .= "	var ambient;\n";
			$out .= "	this.ambient = new THREE.AmbientLight( threephp.color )\n";
			$out .= "	this.ambient.userData = threephp;\n";
    		$out .= "	return this.ambient;\n";
			$out .= "}\n";

		endif;

		if( $region == "main" ):
			
			$out .= "scene.add( new Ambient( " . json_encode( clean( $this ) ) . " ) ); \n";

		endif;

		return $out;
	}

}

?>