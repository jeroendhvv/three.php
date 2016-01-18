<?php 

class Call extends THREE {
	
	function __construct( $parent=null, $params_json="{}" ){

		parent::__construct( $parent, $params_json );

	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
			
			$out .= "function call( parameters ){ \n";
			//$out .= "	console.log( parameters );\n";
			$out .= "	var fn = window[ parameters.js ]; \n";
			$out .= "	if( typeof fn === 'function' ){ \n";
			$out .= "		$.ajax({ \n";
			$out .= "			method: 'POST', \n";
			$out .= "			url: 'call/" . rand() . "', \n";
			$out .= "			data: parameters, \n";
			$out .= "			success: fn, \n";
			$out .= "		}); \n";
			$out .= "	} \n";
			$out .= "} \n";

		endif;

		return $out;

	}

}

?>