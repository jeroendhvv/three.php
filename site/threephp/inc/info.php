<?php 

class Info extends THREE {
	
	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );
		
	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "style" ):

			$out .= "#info{\n";
			$out .= "text-align: left;\n";
			$out .= "position: absolute;\n";
			$out .= "top: 0px;\n";
			$out .= "width: 100%;\n";
			$out .= "padding: 5px;\n";
			$out .= "background-color: #fff;\n";
			$out .= "}\n";

		endif;

		if( $region == "body" ):
			
			$out .= "<div id='info'>Drag to spin</div>\n";

		endif;

		return $out;
	}

}

?>