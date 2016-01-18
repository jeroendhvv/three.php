<?php 

class Animate extends THREE {
	
	var $stat;
	var $control;
	var $physics;
	//var $tween;

	function __construct( $parent=null, $params_json="" ){

		$this->stat = false;
		$this->control = false;
		$this->physics = false;
		
		parent::__construct( $parent, $params_json );

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "main" ):
			
			$out .= "function animate(){\n";
    		$out .= "	requestAnimationFrame( animate );\n";
    		$out .= "	render();\n";
    		if( $this->control ):
    			$out .= "	controls.update();\n";
    		endif;
    		if( $this->stat ):
    			$out .= "	statistics.update( renderer );\n";
    		endif;
    		if( $this->physics ):
    			//$out .= "	world.step();\n";
    		endif;
    		//if( $this->tween ):
    		//	$out .= "	TWEEN.update();\n";
    		//endif;
			$out .= "}\n";
			$out .= "animate();\n";

		endif;

		return $out;
	}

}

?>