<?php 

class Stat extends THREE {
	
	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );

		$this->add( new Script( $this, '{ "path":"threejs/examples/js/libs/stats.min.js", "region":"head" }' ) );
		
	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
			
			$out .= "var Statistics = function(){\n";
			$out .= "	var statistics;\n";
    		$out .= "	this.statistics = new Stats();\n";
    		$out .= "	this.statistics.domElement.style.position = 'absolute';\n";
    		$out .= "	this.statistics.domElement.style.top = '0px';\n";
    		$out .= "	this.statistics.domElement.style.right = '0px';\n";
    		$out .= "	document.body.appendChild( this.statistics.domElement );\n";
    		$out .= "	return this.statistics;\n";
			$out .= "}\n";

		endif;

		if( $region == "main" ):
			
			$out .= "var statistics = new Statistics();\n";

		endif;

		return $out;
	}

}

?>