<?php 

class House extends THREE {
	
	var $x;
	var $y;
	var $z;
	//var $rotation;
	var $js;
	var $render;
	var $target;

	function __construct( $parent=null, $params_json="{}" ){

		$this->x = -78;
		$this->y = 78;
		$this->z = -10;

		$num = 0;
		if( isset( $parent->houses ) ):
			$num = count( $parent->houses );
		endif;
		$this->x += $num * 51;

		$this->js = "";
		$this->render = true;
		$this->target = "";

		parent::__construct( $parent, $params_json );

		//var_dump( find( root( $this ), "Game" )->interactive );
		if( find( root( $this ), "Game" )->interactive != 'false' ):
			$this->js = "house_click";
		endif;

		if( $this->render ):
			find( root( $this ), "Bank" )->amount -= $parent->cost;
		endif;

		//unique name 
		$this->name = "house" . $parent->id . $this->id;

		//set new target based on new name
		$this->target = $this->name;

		//recalculate guid based on new name
		//$this->guid = md5( serialize( clean( $this ) ) );

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "script" ):

			$out .= "var House = function( threephp ){\n";
			$out .= "	var extrude, shape, house;\n";
			$out .= "	var geometry, material, hover;\n";
			$out .= "	this.shape = new THREE.Shape();\n";
			$out .= "	this.shape.moveTo( 5, 0 );\n";
			$out .= "	this.shape.lineTo( 5, 35 );\n";
			$out .= "	this.shape.lineTo( 0, 35 );\n";
			$out .= "	this.shape.lineTo( 25, 50 );\n";
			$out .= "	this.shape.lineTo( 50, 35 );\n";
			$out .= "	this.shape.lineTo( 45, 35 );\n";
			$out .= "	this.shape.lineTo( 45, 0 );\n";
			$out .= "	this.shape.lineTo( 5, 0 );\n";
			$out .= "	this.extrude = { amount: 46, steps: 10, bevelEnabled: false };\n";
			$out .= "	this.geometry = new THREE.ExtrudeGeometry( this.shape, this.extrude );\n";
			$out .= "	this.geometry.applyMatrix( new THREE.Matrix4().makeTranslation( -25, 10, -23 ) );\n";
			$out .= "	this.material = new THREE.MeshLambertMaterial( { color: 0x18a522, overdraw: 0.5, transparent: true } );\n";
			$out .= "	this.house = new THREE.Mesh( this.geometry, this.material );\n";
			$out .= "	this.house.userData = threephp;\n";
			$out .= "	this.house.name = threephp.name;\n";
			$out .= "	this.house.position.x = threephp.x;\n";
			$out .= "	this.house.position.y = threephp.y;\n";
			$out .= "	this.house.rotation.x = Math.PI / 2;\n";
			$out .= "	this.house.position.z = threephp.z;\n";
			$out .= "	this.house.castShadow = true;\n";
			$out .= "	this.house.receiveShadow = true;\n";
			$out .= "	console.log( this.house.name + ' ' + this.house.userData.js );\n";
			//only animate when added otherwise just place
 			//$out .= "	TweenMax.to( this.house.position, Math.random() * 1 + 1, { ease: Bounce.easeOut, z: -10 } );\n";
			$out .= "	return this.house;\n";
			$out .= "}\n";

			$out .= "function house_click( params_json ){\n";
			$out .= "	console.log( 'house_click' );\n";
			//$out .= "	console.log( params_json );\n";
			$out .= "	if( params_json != false ){\n";
			$out .= "		var params = $.parseJSON( params_json );\n";
			$out .= "		if( params.message != undefined ){\n";
			$out .= "			console.log( params.message );\n";
			$out .= "			call( { 'target':'dialog', 'js':'show_dialog', 'message':params.message } );\n";
			$out .= "		} else {\n";
			$out .= "			var street = scene.getObjectByName( params.parent );\n";
			$out .= "			street.remove( scene.getObjectByName( params.name, true ) );\n";
			//$out .= "		animate();\n";
			//tween??
			$out .= "			call( { 'target':'bank', 'js':'show_bank', 'target':'bank' } );\n";
			$out .= "		}\n";
			$out .= "	}\n";
			$out .= "}\n";

		endif;

		if( $region == "main" AND $this->render ):
	
			$out .= "scene.getObjectByName( '" . $this->parent->name . "', true ).add( new House( " . json_encode( clean( $this ) ) . " ) );\n";

		endif;

		return $out;

	}

	function call( $params ){
		
		//if dices in db no remove
		$db_dices = root( $this )->db->load( "Dice" );

		if( count( $db_dices ) ):

			//return dialog data?
			return '{ "message":"Cannot remove after start" }';

		else:

			$house = find( root( $this ), "House", "name", $params["name"] );
		
			if( root( $this )->db->delete( $house ) ):
			
				return json_encode( $params );

			else:

				return false;

			endif;

		endif;

	}

}

?>