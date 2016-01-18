<?php 

class Camera extends THREE {
	
	function __construct( $parent=null, $params_json="" ){

		parent::__construct( $parent, $params_json );
		
	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
			
			$out .= "var Camera = function(){ \n";
			$out .= "	var camera; \n";
			$out .= "	this.camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 100000 ); \n";
			$out .= "	this.camera.name = 'camera'; \n";
			$out .= "	this.camera.position.set( 1200, 800, -750 ); \n";
			$out .= "	this.camera.lookAt( new THREE.Vector3( 0, 0, 0 ) ); \n";
			$out .= "	return this.camera; \n";
			$out .= "} \n";

		endif;

		if( $region == "main" ):
			
			$out .= "var camera = new Camera(); \n";

		endif;

		return $out;
	}

}

?>