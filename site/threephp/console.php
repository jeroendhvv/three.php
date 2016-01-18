<?php 

class Console extends THREE {
	
	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );
		
	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "style" ):

			$out .= "#console{\n";
			$out .= "text-align: left;\n";
			$out .= "position: absolute;\n";
			$out .= "bottom: 0px;\n";
			$out .= "width: 100%;\n";
			$out .= "padding: 0px;\n";
			$out .= "height: 20px;\n";
			$out .= "background-color: #fff;\n";
			$out .= "border-top: 1px solid #ccc;\n";
			$out .= "z-index:100;\n";
			$out .= "}\n";
			$out .= "#console iframe{\n";
			$out .= "padding: 15px 0px 0px 0px;\n";
			$out .= "border:0px;\n";
			$out .= "width:100%;\n";
			$out .= "height:100%;\n";
			$out .= "}\n";
		endif;

		if( $region == "main" ):

			$out .= "$( '#console' ).on( 'click', function(){\n";
			//$out .= "	console.log( $( this ).css( 'height' ) );\n";	
			$out .= "	if( $( this ).css( 'height' ) == '20px' ){\n";
			$out .= "		$( this ).css( { 'height': $(window).height() + 'px' } );\n";
			$out .= "	}else{\n";
			$out .= "		$( this ).css( { 'height': '20px' } );\n";
			$out .= "	}\n";
			$out .= "});\n";
		endif;

		if( $region == "body" ):
			
			$out .= "<div id='console'><iframe src='console' ></iframe></div>\n";

		endif;

		return $out;
	}

}

?>