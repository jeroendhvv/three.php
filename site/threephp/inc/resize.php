<?php 

class Resize extends THREE {
	
	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );
		
	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
			
			$out .= "function onWindowResize(){ \n";
			$out .= "	windowHalfX = window.innerWidth / 2; \n";
			$out .= "	windowHalfY = window.innerHeight / 2; \n";
			$out .= "	camera.aspect = window.innerWidth / window.innerHeight; \n";
			$out .= "	camera.updateProjectionMatrix(); \n";
			$out .= "	renderer.setSize( window.innerWidth, window.innerHeight ); \n";
			$out .= "} \n";

		endif;

		if( $region == "main" ):
			
			$out .= "window.addEventListener( 'resize', onWindowResize, false );\n";
			
		endif;

		return $out;
	}

}

?>