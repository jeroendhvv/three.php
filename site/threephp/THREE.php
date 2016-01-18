<?php

/***************************************************************
 *                                                             *
 *  three.php version 0.0.1                                    *
 *                                                             *
 *  Three.php is a framework to store and verify game data     *
 *  on the server in order to create a cheat-proof html5 game  *
 *  It includes server side user login, php > js and js > php  * 
 *  bridges to aid in verification                             *
 *                                                             *
 ***************************************************************/

define( "VERSION", "0.0.1" );
define( "DEBUG", false );

// user config
include( "tpl/inc/config.php" );

// default includes
include( "threephp/config.php" );
include( "threephp/project.php" );
include( "threephp/console.php" );

/***************
 * base object *
 ***************/
class THREE {
	
	var $id;
	var $parent;
	var $name;

	function __construct( $parent=null, $params_json="{}" ){

		$class = get_class( $this );
		$multiple = strtolower( $class ) . "s";

		$this->id = ( isset( $parent->$multiple ) ? count( $parent->$multiple ) : 0 );
		$this->parent = $parent;
		$this->name = strtolower( $class ) . $this->id;

		$params = json_decode( $params_json );

		if( $params != null ):
			if( isset( $params->parent ) ):
				unset( $params->parent );
			endif;
			foreach( $params as $param => $value ):
				if( isset( $this->$param ) ):
					$this->$param = $value;
				endif;
			endforeach;
		endif;

	}

	function root(){
		if( $this->parent == null ):
			return $this;
		else:
			return $this->parent->root();
		endif;
	}

	function add( $object ){

		if( gettype( $object ) == "object" ):
			
			//create properties based on passed object
			$property = strtolower( get_class( $object ) ) . "s";
			if( isset( $this->$property ) == false ):
				$this->$property = array();
			endif;

			//no doubles
			$add = true;
			foreach( $this->$property as $obj ):
				if( $object->name == $obj->name ):
					$add = false;
				endif;
			endforeach;
			if( $add ):
				
				array_push( $this->$property, $object );
				
				return $object;

			endif;

		endif;

		return false;

	}

}

/*********************
 * utility functions *
 *********************/
function parse( $object, $region="" ){

	$out = "";
	
	if( method_exists( $object, "render" ) ):
		
		$render = $object->render( $region );
		$out .= $render;

	endif;

	foreach( $object as $property => $value ):
		
		if( gettype( $value ) == "object" AND $property != "parent" ):

			$render = parse( $value, $region );
			if( $render != "" ):
				//var_dump( strlen( $out ) . " " . strpos( $out, $render ) );
				if( strpos( $out, $render ) === false ):
					$out .= $render;
				endif;
			endif;

		endif;

		if( gettype( $value ) == "array" ):

			foreach( $value as $key => $val ):

				if( gettype( $val ) == "object" ):

					$render = parse( $val, $region );
					//var_dump( $render );
					if( $render != "" ):
						//var_dump( strpos( $out, $render ) );
						//if( $region == "script" ):
							//$name = ( isset( $object->name ) ? $object->name . " " : "" );
							//$out .= "/* " . $region . " " . get_class( $object ) . " " . $name . strlen( $out ) . " " . strpos( $out, $render ) . " */\n";
						//endif;
						//var_dump( strlen( $out ) . " " . strpos( $out, $render ) );
						if( strpos( $out, $render ) === false ):
							$out .= $render;
						endif;
					endif;

				endif;

			endforeach;

		endif;

	endforeach;

	return $out;

}


//make it so it finds more than one.

function find( $object, $class="", $param="", $match="" ){

	$out = null;
	
	foreach( $object as $property => $value ):
		
		if( gettype( $value ) == "object" AND $property != "parent" ):

			if( $out == null ):
				$out = find( $value, $class, $param, $match );
			endif;

		endif;

		if( gettype( $value ) == "array" ):

			foreach( $value as $prop => $val ):

				if( gettype( $val ) == "object" ):

					if( $out == null ):
						$out = find( $val, $class, $param, $match );
					endif;

				endif;

			endforeach;

		endif;

	endforeach;

	if( $class == "" ):

		if( isset( $object->$param ) AND $object->$param == $match ):

			$out = $object;

		endif;

	else:
	
		if( get_class( $object ) == $class ):
			
			if( $param == "" ):
			
				$out = $object;

			else:

				if( isset( $object->$param ) AND $object->$param == $match ):
					 
					$out = $object;

				endif;

			endif;

		endif;

	endif;

	return $out;

}

function findall( $object, $class="", $param="", $match="" ){

	$out = array();
	
	foreach( $object as $property => $value ):
		
		if( gettype( $value ) == "object" AND $property != "parent" ):

			//if( $out == null ):
				$out += findall( $value, $class, $param, $match );
			//endif;

		endif;

		if( gettype( $value ) == "array" ):

			foreach( $value as $prop => $val ):

				if( gettype( $val ) == "object" ):

					//if( $out == null ):
						$out += findall( $val, $class, $param, $match );
					//endif;

				endif;

			endforeach;

		endif;

	endforeach;

	if( $class == "" ):

		if( isset( $object->$param ) AND $object->$param == $match ):

			$out[] = $object;

		endif;

	else:
	
		if( get_class( $object ) == $class ):
			
			if( $param == "" ):
			
				$out[] = $object;

			else:

				if( isset( $object->$param ) AND $object->$param == $match ):
					 
					$out[] = $object;

				endif;

			endif;

		endif;

	endif;

	return $out;

}
function clean( $object, $arrays=true ){
	
	$copy = clone $object;

	if( is_object( $copy->parent ) ):
		$copy->parent = $copy->parent->name;
	endif;

	//unset( $copy->parent );

	foreach( $copy as $property => $value ):
		
		if( gettype( $value ) == "array" AND $arrays ):
			
			unset( $copy->$property );
		
		else:

			//convert properties
			if( gettype( $value ) != "object" ):
				
				//string to integer
				if( in_array( $property, array( "id", "x", "y", "z", "color", "cost", "profit" ) ) ):
					$copy->$property = intval( $value );
				endif;

				//string to float
				if( in_array( $property, array( "rotation" ) ) ):
					$copy->$property = floatval( $value );
				endif;

				//true and false
				//if( in_array( $value, array( "\"true\"", "\"false\"" ) ) ):
					//var_dump( $value );
					//var_dump( str_replace( "\"", "", $value ) );
					//$copy->$property = str_replace( "\"", "", $value );
				//endif;
				
			endif;

		endif;

	endforeach;

	return $copy;
}

function root( $object ){
	
	if( isset( $object->parent ) AND $object->parent != null ):
		
		return root( $object->parent );

	else:

		return $object;

	endif;

}

function debug( $out="" ){

	if( $out == "" ):
		
		// are we in debug mode
		if( $_SERVER['REMOTE_ADDR'] == DEBUG_IP OR $_SERVER['REMOTE_ADDR'] == LOCALHOST ):
			return true;
		else:
			return false;
		endif;

	else:

		// output variable if we are debugging
		if( $_SERVER['REMOTE_ADDR'] == DEBUG_IP OR $_SERVER['REMOTE_ADDR'] == LOCALHOST ):
			if( DEBUG ):
				var_dump( $out );
			endif;
		endif;

	endif;

}

?>