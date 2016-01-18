<?php 

class Bank extends THREE {
	
	var $amount;

	function __construct( $parent=null, $params_json="{}" ){

		$this->amount = 0;

		parent::__construct( $parent, $params_json );

		$this->name = "bank";

	}

	function render( $region="" ){
		
		$out = "";

		if( $region == "style" ):

			$out .= "#bank{\n";
			$out .= "text-align: left;\n";
			$out .= "position: absolute;\n";
			$out .= "top: 50px;\n";
			$out .= "left: 10%;\n";
			$out .= "padding: 5px;\n";
			$out .= "background-color: #fff;\n";
			$out .= "border: 1px solid #ccc;\n";
			$out .= "}\n";

		endif;

		if( $region == "main" ):
			
			$out .= "function show_bank( amount ){\n";
			$out .= "	$( '#bank' ).html( 'Bank ' + amount );\n";
			$out .= "}\n";

		endif;

		if( $region == "body" ):

			$out .= "<div id='bank'>Bank " . $this->amount . "</div>\n";

		endif;

		return $out;
		
	}

	function call( $params ){
		
		return $this->amount;

	}

}

?>