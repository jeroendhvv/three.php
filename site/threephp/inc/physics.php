<?php 

class Physics extends THREE {
	
	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );
		//$this->add( new Script( $this, '{ "path":"threejs/threex/vendor/oimo.js", "region":"head" }' ) );
		//$this->add( new Script( $this, '{ "path":"threejs/threex/threex.oimo.js", "region":"head" }' ) );
		//$this->add( new Script( $this, '{ "path":"threejs/threex/threex.oimo.js", "region":"head" }' ) );

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "main" ):
			
			//$out .= "var world   = new OIMO.World();\n";
			//$out .= "var world	= new OIMO.World( 1/360, 2, 8 );\n";
			//$out .= "setInterval(function(){\n";
			//$out .= "world.step();\n";
			//$out .= "}, 1000/180);\n";
			//$out .= "var world = new CANNON.World();\n";
			//$out .= "world.gravity.set( 0, 0, -9.8 * 800 );\n";
        	//$out .= "world.broadphase = new CANNON.NaiveBroadphase();\n";
        	//$out .= "world.solver.iterations = 8;\n";

		endif;

		return $out;
	}

}

?>