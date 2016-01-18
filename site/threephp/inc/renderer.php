<?php 

class Renderer extends THREE {

	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );
		
		$this->add( new Script( $this, '{ "path":"threejs/examples/js/Detector.js", "region":"head" }' ) );
		$this->add( new Script( $this, '{ "path":"threejs/examples/js/renderers/Projector.js", "region":"head" }' ) );
		$this->add( new Script( $this, '{ "path":"threejs/examples/js/renderers/CanvasRenderer.js", "region":"head" }' ) );
		
	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
			
			$out .= "var Renderer = function(){ \n";
			$out .= "	var renderer; \n";
			$out .= "	this.renderer = Detector.webgl ? new THREE.WebGLRenderer( { antialias : true } ) : new THREE.CanvasRenderer( { antialias : true } ); \n";
			$out .= "	this.renderer.setClearColor( 0xf0f0f0 ); \n";
			$out .= "	this.renderer.setPixelRatio( window.devicePixelRatio ); \n";
			$out .= "	this.renderer.setSize( window.innerWidth, window.innerHeight ); \n";
			$out .= "	this.renderer.shadowMapEnabled = true; \n";
			$out .= "	this.renderer.shadowMapSoft = true; \n";
			//$out .= "	this.renderer.shadowMapType = THREE.PCFSoftShadowMap; // options are THREE.BasicShadowMap | THREE.PCFShadowMap | THREE.PCFSoftShadowMap\n";
			$out .= "	this.renderer.sortObjects = false; \n";
			$out .= "	return this.renderer; \n";
			$out .= "} \n";

		endif;

		if( $region == "main" ):

			$out .= "var renderer = new Renderer(); \n";
			$out .= "container.appendChild( renderer.domElement ); \n";
			$out .= "function render(){ \n";
    		$out .= "	renderer.render( scene, camera ); \n";
			$out .= "} \n";

		endif;

		return $out;
	}

}

?>