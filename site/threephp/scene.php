<?php 

include( "inc/renderer.php" );
include( "inc/camera.php" );
include( "inc/ambient.php" );
include( "inc/light.php" );
include( "inc/resize.php" );
include( "inc/stat.php" );
include( "inc/click.php" );
//include( "inc/info.php" );
include( "inc/control.php" );
include( "inc/animate.php" );
include( "inc/tween.php" );
include( "inc/physics.php" );

class Scene extends THREE {
	
	var $resize;
	var $stat;
	var $click;
	//var $info;
	var $control;
	var $tween;
	var $physics;
	

	function __construct( $parent=null, $params_json="{}" ){

		$this->resize = false;
		$this->stat = false;
		$this->click = false;
		//$this->info = false;
		$this->control = false;
		$this->tween = false;
		$this->physics = false;
		
		parent::__construct( $parent, $params_json );

		$this->name = "scene";

		$this->add( new Script( $this, '{ "path":"threejs/build/three.min.js", "region":"head" }' ) );
		
		$this->add( new Camera( $this, '{}' ) );
		$this->add( new Renderer( $this, '{}' ) );
		$this->add( new Ambient( $this, '{}' ) );
		$this->add( new Light( $this, '{}' ) );

		if( $this->resize ):
			$this->add( new Resize( $this, '{}' ) );
		endif;

		if( $this->stat ):
			$this->add( new Stat( $this, '{}' ) );
		endif;
		
		if( $this->click ):
			$this->add( new Click( $this, '{}' ) );
		endif;

		//if( $this->info ):
		//	$this->add( new Info( $this, '{}' ) );
		//endif;

		if( $this->control ):
			$this->add( new Control( $this, '{}' ) );
		endif;
		
		if( $this->tween ):
			$this->add( new Tween( $this, '{}' ) );
		endif;

		if( $this->physics ):
			$this->add( new Physics( $this, '{}' ) );
		endif;

		$this->add( new Animate( $this, '{ "stat":"' . $this->stat . '", "control":"' . $this->control . '", "physics":"' . $this->physics . '" }' ) );

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "style" ):

			$out .= "body{\n";
			$out .= "color: #808080;\n";
			$out .= "font-family:Monospace;\n";
			$out .= "font-size:13px;\n";
			$out .= "background-color: #efefef;\n";
			$out .= "margin: 0px;\n";
			$out .= "overflow: hidden;\n";
			$out .= "}\n";
			
		endif;

		if( $region == "body" ):

			$out .= "<div id='container'></div>\n";

		endif;

		if( $region == "main" ):
			
    		$out .= "var container = document.getElementById( 'container' );\n";
			$out .= "var scene = new THREE.Scene();\n";
			$out .= "var group = new THREE.Object3D();\n";
    		$out .= "scene.add( group );\n";

		endif;
		
		return $out;

	}

}

?>