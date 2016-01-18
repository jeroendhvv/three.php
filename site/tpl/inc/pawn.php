<?php 

class Pawn extends THREE {
	
	var $color;
	var $x;
	var $y;
	var $z;
	var $rotation;
	var $position;
	var $target;
	var $js;

	function __construct( $parent=null, $params_json="{}" ){

		$this->color = 0x666666;
		//$this->x = -400;
		$this->y = 3;
		//$this->z = -400;
		$this->rotation = 0 - ( M_PI / 2 );
		$this->position = 0;
		$this->target = 0;
		$this->js = "";
		
		parent::__construct( $parent, $params_json );

		$this->name = "pawn";

		//load all dices from db and base position on it
		//in separate function
		$db_dices = root( $this )->db->load( "Dice" );

		if( count( $db_dices ) ):
			if( $this->root()->path == "call" ):
				array_pop( $db_dices );
			endif;
			if( count( $db_dices ) ):
				foreach( $db_dices as $db_dice ):
					$dice = new Dice( $this, $db_dice->object );
					$this->position += $dice->dice1;
					$this->position += $dice->dice2;
					if( $this->position > 15 ):
						$this->position -= 16;
					endif;
					//var_dump( $this->position );
				endforeach;
			endif;		
		endif;
		$this->target = $this->position;

		$street = find( root( $this ), "Street", "name", "street" . $this->position );
		$this->x = $street->x;
		$this->z = $street->z;

		//var_dump( "position: " . $this->position . " target: " . $this->target );

	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "style" ):

			$out .= "#position{\n";
			$out .= "text-align: left;\n";
			$out .= "position: absolute;\n";
			$out .= "top: 50px;\n";
			$out .= "left: 43%;\n";
			$out .= "padding: 5px;\n";
			$out .= "background-color: #fff;\n";
			$out .= "border: 1px solid #ccc;\n";
			$out .= "}\n";

		endif;

		if( $region == "script" ):
			
			$out .= "var Pawn = function( threephp ){\n";
			$out .= "	var pawn, points;\n";
			$out .= "	var geometry, material;\n";
			$out .= "	this.points = [\n";
			$out .= "	new THREE.Vector3( 0, 0, 0 ),\n";
			$out .= "		new THREE.Vector3( 40, 0, 6 ),\n";
			$out .= "		new THREE.Vector3( 40, 0, 12 ),\n";
			$out .= "		new THREE.Vector3( 25, 0, 8 ),\n";
			$out .= "		new THREE.Vector3( 33, 0, 52 ),\n";
			$out .= "		new THREE.Vector3( 0, 0, 52 ),\n";
			$out .= "		new THREE.Vector3( 0, 0, 0 )\n";
			$out .= "	];\n";
			$out .= "	this.geometry = new THREE.LatheGeometry( this.points, 32 );\n";
			$out .= "	this.material = new THREE.MeshLambertMaterial( { color: 0xAAAAAA, overdraw: 0.5 } );\n";
			$out .= "	this.pawn = new THREE.Mesh( this.geometry, this.material );\n";
			$out .= "	this.pawn.userData = threephp;\n";
			$out .= "	this.pawn.name = threephp.name;\n";
			$out .= "	this.pawn.castShadow = true;\n";
			$out .= "	this.pawn.receiveShadow = true;\n";
			$out .= "	this.pawn.position.x = threephp.x;\n";
			$out .= "	this.pawn.position.y = threephp.y;\n";
			$out .= "	this.pawn.position.z = threephp.z;\n";
			$out .= "	this.pawn.rotation.x = threephp.rotation;\n";
			$out .= "	return this.pawn;\n";
			$out .= "}\n";
			
			$out .= "function move_pawn( params_json ){\n";
			//$out .= "	console.log( 'move_pawn' );\n";
			//$out .= "	console.log( params_json );\n";
			$out .= "	if( params_json != false ){ \n";
			$out .= "		var params = $.parseJSON( params_json );\n";
			//$out .= "		console.log( params );\n";
			$out .= "		if( params.amount ){\n";
			$out .= "			pawn.userData.position++;\n";
			$out .= "			params.amount--;\n";
			$out .= "			if( pawn.userData.position > 15 ){\n";
			$out .= "				pawn.userData.position -= 16;\n";
			$out .= "			}\n";
			$out .= "			$( '#position' ).html( 'Position ' + pawn.userData.position + ' Target ' + ( pawn.userData.position + params.amount ) );\n";
			//$out .= "			if( params.position != params.target ){\n";
			$out .= "			var street = scene.getObjectByName( 'street' + pawn.userData.position );\n";
			//$out .= "			console.log( 'street' + params.position );\n";
			$out .= "			TweenMax.to( pawn.position, 0.2, { x: street.position.x, z: street.position.z, onComplete:function(){\n";
			$out .= "					if( pawn.userData.position != params.target ){\n";
			$out .= "						move_pawn( JSON.stringify( params ) );\n";
			$out .= "					}\n";
			$out .= "				}\n";
			$out .= "			});\n";
			$out .= "		}\n";
			$out .= "	}\n";
			$out .= "}\n";

		endif;

		if( $region == "main" ):
			
			$out .= "var pawn = new Pawn( " . json_encode( clean( $this ) ) . " );";
			$out .= "group.add( pawn ); \n";

		endif;

		if( $region == "body" ):
			$out .= "<div id='position'>Position " . $this->position . " Target " . $this->target . "</div>\n";
		endif;

		return $out;
	}

	function call( $params ){
		
		//load last dice roll
		//might not have saved yet???
		$db_dices = root( $this )->db->load( "Dice", "", "", true );

		if( count( $db_dices ) ):
			
			$dice = new Dice( $this, $db_dices[ 0 ]->object );
			
			//already set after finishing last roll??
			
			$this->target += $dice->dice1;
			$this->target += $dice->dice2;

			//$this->dice1 = $dice->dice1;
			//$this->dice2 = $dice->dice2;

			//use num streets as param??
			if( $this->target > 15 ):
				$this->target -= 15;
			endif;

			//$street = find( root( $this ), "Street", "name", "street" . $this->target );
			$position = new stdClass();
			$position->dice1 = $dice->dice1;
			$position->dice2 = $dice->dice2;
			//$position->z = $street->z;
			$position->target = $this->target;
			$position->position = $this->position;
			//debugging
			//$position->dices = count( $db_dices );
			//update my position
			$this->position = $this->target;
			return json_encode( $position );

		else:
			return false;
		endif;

	}

}

?>