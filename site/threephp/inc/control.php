<?php 

class Control extends THREE {
	
	var $rotation;

	function __construct( $parent=null, $params_json="" ){

		$this->rotation = M_PI / 4;

		parent::__construct( $parent, $params_json );
		
		$this->add( new Script( $this, '{ "path":"threejs/examples/js/controls/OrbitControls.js", "region":"head" }' ) );
		
	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "main" ):
			
			$out .= "var controls = new THREE.OrbitControls( camera );\n";
    		$out .= "controls.minPolarAngle = " . $this->rotation . ";\n";
    		$out .= "controls.maxPolarAngle = " . $this->rotation . ";\n";
    		$out .= "controls.addEventListener( 'change', render );\n";

		endif;

		return $out;
	}

}

?>