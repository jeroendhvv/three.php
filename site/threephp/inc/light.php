<?php 

class Light extends THREE {

	var $color;
	var $x;
	var $y;
	var $z;
	var $shadow;
	var $box;
	var $size;

	function __construct( $parent=null, $params_json="{}" ){

		$this->name = "light";
		$this->color = 0xdfebff;
		$this->x = 300;
		$this->y = 500;
		$this->z = -250;
		$this->shadow = true;
		$this->box = false;
		$this->size = 2048;

		parent::__construct( $parent, $params_json );
		
	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
			
			$out .= "var Light = function( threephp ){\n";
			$out .= "	var light;\n";
			$out .= "	this.light = new THREE.DirectionalLight( threephp.color, 1 );\n";
    		$out .= "	this.light.userData = threephp;\n";
    		$out .= "	this.light.name = threephp.name;\n";
			$out .= "	this.light.position.x = threephp.x;\n";
			$out .= "	this.light.position.y = threephp.y;\n";
			$out .= "	this.light.position.z = threephp.z;\n";
			if( $this->shadow ):
				$out .= "	this.light.castShadow = true; \n";
				$out .= "	this.light.shadowMapWidth = threephp.size; \n";
				$out .= "	this.light.shadowMapHeight = threephp.size; \n";
				$out .= "	this.light.shadowCameraLeft = 0 - threephp.size; \n";
				$out .= "	this.light.shadowCameraRight = threephp.size; \n";
				$out .= "	this.light.shadowCameraTop = threephp.size; \n";
				$out .= "	this.light.shadowCameraBottom = 0 - threephp.size; \n";
				$out .= "	this.light.shadowCameraFar = threephp.size; \n";
				$out .= "	this.light.shadowDarkness = 0.45; \n";
			endif;
			if( $this->box ):
					$out .= "	this.light.shadowCameraVisible = true; \n";
			endif;
			$out .= "	return this.light; \n";
			$out .= "} \n";

		endif;

		if( $region == "main" ):
			
			$out .= "scene.add( new Light( " . json_encode( clean( $this ) ) . " ) );\n";

		endif;

		return $out;
	}

}

?>