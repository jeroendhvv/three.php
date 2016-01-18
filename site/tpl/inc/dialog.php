<?php 

class Dialog extends THREE {
	
	var $message;

	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );
		
		$this->name = "dialog";
	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "style" ):

			$out .= "#dialog{\n";
			$out .= "text-align: left;\n";
			$out .= "position: absolute;\n";
			$out .= "top: 50%;\n";
			$out .= "left: 50%;\n";
			$out .= "padding: 5px;\n";
			$out .= "background-color: #fff;\n";
			$out .= "border: 1px solid #ccc;\n";
			$out .= "display: none;\n";
			$out .= "}\n";

		endif;

		if( $region == "main" ):
			
			$out .= "function show_dialog( params_json ){\n";
			$out .= "	console.log( 'show_dialog' ); \n";
			$out .= "	console.log( params_json ); \n";
			$out .= "	if( params_json != false ){ \n";
			$out .= "		var params = $.parseJSON( params_json );\n";
			$out .= "		$( '#dialog' ).html( params.message ).show().animate( { 'opacity':'1'}, 1000, function(){\n";
			$out .= "			$( this ).animate( { 'opacity':'0' }, 250, function(){\n";
			$out .= "				$( this ).hide();\n";	
			$out .= "			});\n";
			$out .= "		});\n";
			$out .= "	}\n";
			$out .= "}\n";


		endif;

		if( $region == "body" ):

			$out .= "<div id='dialog'></div>\n";

		endif;

		return $out;
		
	}

	function call( $params ){

		return json_encode( $params );

	}

}

?>