<?php 

class Dice extends THREE {
	
	var $dice1;
	var $dice2;
	var $js;
	var $numhouses;

	function __construct( $parent=null, $params_json="{}" ){

		$this->dice1 = 6;
		$this->dice2 = 6;
		$this->js = 'dice_roll';
		$this->numhouses = 0;

		parent::__construct( $parent, $params_json );

		find( $this->root(), "Scene" )->physics = true;

		$this->name = "dice";

		//load last value??
		$db_dices = root( $this )->db->load( "Dice", "", "", true );
		if( count( $db_dices ) ):
			$dice = json_decode( $db_dices[0]->object );
			$this->dice1 = $dice->dice1;
			$this->dice2 = $dice->dice2;
		endif;

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "style" ):

			$out .= "#dice{\n";
			$out .= "text-align: left;\n";
			$out .= "position: absolute;\n";
			$out .= "top: 50px;\n";
			$out .= "left: 30%;\n";
			$out .= "padding: 5px;\n";
			$out .= "background-color: #fff;\n";
			$out .= "border: 1px solid #ccc;\n";
			$out .= "}\n";

		endif;

		if( $region == "main" ):
			
			$out .= "$( '#dice' ).bind( 'click', function(){\n";
			//start animation
			//$out .= "	console.log( pawn.userData.position );\n";	
			$out .= "	interactive = false;\n";
			$out .= "	call( { 'js':'show_dice', 'target':'dice' } );\n";	
			$out .= "});\n";	
			$out .= "function show_dice( params_json ){\n";
			//$out .= "	console.log( 'show_dice' ); \n";
			//$out .= "	console.log( params_json ); \n";
			$out .= "	if( params_json == false ){ \n";
			$out .= "		call( { 'target':'dialog', 'js':'show_dialog', 'message':'Plaats eerst minimaal een huis.' } );\n";
			$out .= "	} else { \n";
			$out .= "		var params = $.parseJSON( params_json );\n";
			$out .= "		$( '#dice' ).html( 'Dice ' + params.dice1 + ' ' + params.dice2 );\n";
			$out .= "		var amount = params.dice1 + params.dice2;\n";
			$out .= "		params = new Object();\n";
			$out .= "		params.amount = amount;\n";
			$out .= "		move_pawn( JSON.stringify( params ) );\n";
			//$out .= "		call( { 'js':'move_pawn', 'target':'pawn' } );\n";
			$out .= "	}\n";
			$out .= "}\n";


		endif;

		if( $region == "body" ):

			$out .= "<div id='dice'>Dice " . $this->dice1 . " " . $this->dice2 . "</div>\n";

		endif;

		return $out;
		
	}

	function call( $params ){

		$houses = findall( root( $this ), "House" );
		$this->numhouses = count( $houses );
		//return json_encode( $houses );
		//return $this->numhouses;
		if( count( $houses ) > 0 ):
			$this->dice1 = rand( 1, 6 );
			$this->dice2 = rand( 1, 6 );
			//save to db
			root( $this )->db->save( $this );
			//root( $this )->db->save( $house );
			return json_encode( clean( $this ) );
		else:
			//dialog
			return false;
		endif;

	}

}

?>