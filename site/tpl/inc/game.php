<?php 

class Game extends THREE {
	
	var $game;
	var $round;
	var $interactive;

	function __construct( $parent=null, $params_json="{}" ){

		$this->interactive = true;
		$this->game = 0;
		$this->round = 0;

		parent::__construct( $parent, $params_json );
		
		$this->name = "game";

		$db_dices = root( $this )->db->load( "Dice" );

		if( count( $db_dices ) ):

			$this->interactive = false;

		endif;

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "style" ):

			$out .= "#game{\n";
			$out .= "text-align: left;\n";
			$out .= "position: absolute;\n";
			$out .= "top: 50px;\n";
			$out .= "left: 60%;\n";
			$out .= "padding: 5px;\n";
			$out .= "background-color: #fff;\n";
			$out .= "border: 1px solid #ccc;\n";
			$out .= "}\n";
			$out .= "#round{\n";
			$out .= "text-align: left;\n";
			$out .= "position: absolute;\n";
			$out .= "top: 50px;\n";
			$out .= "left: 65%;\n";
			$out .= "padding: 5px;\n";
			$out .= "background-color: #fff;\n";
			$out .= "border: 1px solid #ccc;\n";
			$out .= "}\n";

		endif;

		if( $region == "main" ):
			
			$out .= "var interactive = " . $this->interactive . "\n";
			$out .= "function show_game( params_json ){\n";
			$out .= "	console.log( 'show_game' ); \n";
			$out .= "	console.log( params_json ); \n";
			$out .= "	if( params_json != false ){ \n";
			$out .= "		var params = $.parseJSON( params_json );\n";
			$out .= "		$( '#game' ).html( 'Game ' + ( params.game + 1 ) );\n";
			$out .= "		$( '#round' ).html( 'Round ' + ( params.round + 1 ) );\n";
			$out .= "	}\n";
			$out .= "}\n";


		endif;

		if( $region == "body" ):

			$out .= "<div id='game'>Game " . ( $this->game + 1 ) . "</div>\n";
			$out .= "<div id='round'>Round " . ( $this->round + 1 ) . "</div>\n";

		endif;

		return $out;
		
	}

	function call( $params ){

		return json_encode( $params );

	}

}

?>