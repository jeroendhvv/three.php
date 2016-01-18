<?php 

class Board extends THREE {
	
	var $x;
	var $y;
	var $rotation;
	var $js;

	function __construct( $parent=null, $params_json="{}" ){

		$this->x = 0;
		$this->y = 0;
		$this->rotation = 0 - ( M_PI / 2 );
		$this->js = "";//"board_click";

		parent::__construct( $parent, $params_json );

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "script" ):

			$out .= "var Board = function( threephp ){\n";
			$out .= "	var board;\n";
			$out .= "	var top_texture, side_texture;\n";
			$out .= "	var top_material, side_material;\n";
			$out .= "	var geometry, materials, material;\n";
	   		$out .= "	this.geometry = new THREE.BoxGeometry( 1024, 1024, 10, 32, 32 );\n";
	  		$out .= "	this.top_texture = THREE.ImageUtils.loadTexture( 'tpl/img/board.png', {}, function(){\n";
	   		$out .= "		scene.getObjectByName( threephp.name, true ).visible = true;\n";
	   		$out .= "	});\n";
	   		$out .= "	this.top_texture.needsUpdate = true;\n";
	  		$out .= "	this.top_material = new THREE.MeshLambertMaterial( { map: this.top_texture, overdraw: 0.5 } );\n";
	    	$out .= "	this.side_material = new THREE.MeshLambertMaterial( { color: 0x000000, overdraw: 0.5 } );\n";
	    	$out .= "	this.material = new THREE.MeshFaceMaterial( [ this.side_material, this.side_material, this.side_material, this.side_material, this.top_material, this.side_material ] );\n";
	    	$out .= "	this.board = new THREE.Mesh( this.geometry, this.material );\n";
	    	$out .= "	this.board.userData = threephp;\n";
			$out .= "	this.board.name = threephp.name;\n";
			$out .= "	this.board.rotation.z = - threephp.rotation;\n";
	    	$out .= "	this.board.rotation.x = - Math.PI / 2;\n";
	    	$out .= "	this.board.receiveShadow = true;\n";
	    	$out .= "	this.board.castShadow = false;\n";
	    	$out .= "	this.board.visible = false;\n";
	    	$out .= "	return this.board;\n";
	    	$out .= "}\n";

			$out .= "function board_click( params_json ){\n";
			//$out .= "	console.log( params_json );\n";
			//$out .= "	if( params_json != false ){\n";
			//$out .= "		var params = $.parseJSON( params_json );\n";
			//$out .= "		console.log( params );\n";
			//$out .= "		var object = scene.getObjectByName( params.name, true );\n";
			//$out .= "		console.log( object );\n";
			//$out .= "		group.remove( scene.getObjectByName( params.name, true ) );\n";
			//$out .= "		animate();\n";
			//$out .= "	}\n";
			$out .= "}\n";

		endif;

		if( $region == "main" ):
	
			$out .= "group.add( new Board( " . json_encode( clean( $this ) ) . " ) );\n";

		endif;

		return $out;

	}

}

?>