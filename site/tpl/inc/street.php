<?php 

class Street extends THREE {
	
	var $x;
	var $z;
	var $rotation;
	var $label;
	var $type;
	var $city;
	var $cost;
	var $profit;
	var $houses;
	var $target;
	var $js;

	function __construct( $parent=null, $params_json="{}" ){

		$this->x = 0;
		$this->z = 0;
		$this->rotation = 0;
		$this->label = "";
		$this->type = "";
		$this->city = "";
		$this->cost = 0;
		$this->profit = 0;
		$this->houses = array();
		$this->js = "";
		$this->target = "";

		parent::__construct( $parent, $params_json );

		$game = find( $this->root(), "Game" );
		//var_dump( $game );

		if( $this->cost AND $game->interactive ):
			$this->js = "street_click";
		endif;
		//var_dump( $this->id );
		//var_dump( count( $parent->streets ) );
		/* get houses from db */
		//var_dump( clean( $this ) );
		//var_dump( root( $this ) );
		$this->target = $this->name;

		$db_houses = root( $this )->db->load( "House", "parent", $this->name );
		//var_dump( $this->name . " " . count( $db_houses ) );

		if( count( $db_houses ) ):
			foreach( $db_houses as $db_house ):
				$this->add( new House( $this, $db_house->object ) );
			endforeach;
		endif;
		
		//var_dump( $db_houses );
		//$this->parent->add( new Script( $this->parent, '{ "path":"tpl/js/house.js", "region":"head" }' ) );

	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
		
			$out .= "var Street = function( threephp ){\n";
			//$out .= "	console.log( threephp );\n";
			$out .= "	var street, geometry;\n";
			$out .= "	var material;\n";
			$out .= "	var canvas, context, texture, material;\n";
			$out .= "	this.canvas = document.createElement( 'canvas' );\n";
			$out .= "	this.canvas.width = 256;\n";
			$out .= "	this.canvas.height = 256;\n";
			$out .= "	this.context = this.canvas.getContext( '2d' );\n";
			$out .= "	this.context.fillStyle = 'white';\n";
			$out .= "	this.context.fillRect( 0, 0, this.canvas.width, this.canvas.height);\n";
			$out .= "	this.context.font = 'Bold 50px Arial';\n";
			$out .= "	this.context.fillStyle = 'rgba( 0, 0, 0, 1 )';\n";
			$out .= "	this.context.fillText( threephp.id, 0, 50 );\n";
			$out .= "	this.texture = new THREE.Texture( this.canvas );\n";
			$out .= "	this.texture.needsUpdate = true;\n";
			$out .= "	this.material = new THREE.MeshBasicMaterial( { map: this.texture, overdraw: 0.5 } );\n";

			//$out .= "	this.material = new THREE.MeshBasicMaterial( { color: 0xFFFFFF, transparent: true, opacity:0, overdraw: 0.5 } );\n";
			$out .= "	this.geometry = new THREE.PlaneBufferGeometry( 202, 202, 1, 1 );\n";
		    $out .= "	this.street = new THREE.Mesh( this.geometry, this.material );\n";
		    $out .= "	this.street.userData = threephp;\n";
		    $out .= "	this.street.name = threephp.name;\n";
		    $out .= "	this.street.position.x = threephp.x;\n";
			$out .= "	this.street.position.y = 7;\n";
			$out .= "	this.street.position.z = threephp.z;\n";
			$out .= "	this.street.castShadow = true;\n";
			$out .= "	this.street.receiveShadow = true;\n";
			$out .= "	this.street.rotation.x = -Math.PI / 2;\n";
			$out .= "	this.street.rotation.z = threephp.rotation;\n";
			$out .= "	return this.street;\n";
			$out .= "}\n";

			$out .= "function street_click( params_json ){\n";
			$out .= "	console.log( 'street_click' );\n";
			$out .= "	console.log( params_json );\n";
			//$out .= "	var params = $.parseJSON( params_json );\n";
			//$out .= "	params.target = 'name=bank';\n";
			//$out .= "	params.js = 'add_house';\n";
			//$out .= "	console.log( params );\n";
			//$out .= "	ajax( params );\n";
			//$out .= "}\n";
			//$out .= "function add_house( params_json ){\n";
			//$out .= "	console.log( 'add_house' );\n";
			//$out .= "	console.log( params_json );\n";
			$out .= "	if( params_json != false ){ \n";
			$out .= "		var params = $.parseJSON( params_json );\n";
			//$out .= "		console.log( params.parent );\n";
			$out .= "		var street = scene.getObjectByName( params.parent );\n";
			$out .= "		params.z = 300;\n";
			$out .= "		var house = new House( params );\n";
			$out .= "		street.add( house );\n";
			$out .= "		TweenMax.to( house.position, 1, { ease: Bounce.easeOut, z: -10 } );\n";
			$out .= "		call( { 'js':'show_bank', 'target':'bank' } );\n";
			$out .= "	}\n";
			$out .= "}\n";
			
		endif;
		
		if( $region == "main" ):
			
			$out .= "group.add( new Street( " . json_encode( clean( $this ) ) . " ) );\n";

		endif;
		
		return $out;

	}

	function call( $params ){

		$num = count( $this->houses );
		$bank = find( root( $this ), "Bank" );
		
		if( $this->cost AND $num < 4 AND $bank->amount > $this->cost ):
			$bank->amount -= $this->cost;
			$house = $this->add( new House( $this, '{}' ) );
			root( $this )->db->save( $house );
			return json_encode( clean( $house ) );
		else:
			return false;
		endif;

	}

}

?>