<?php
if( !defined( "VERSION" ) ) exit( "No direct script access allowed" );

if( isset( $_POST["target"] ) ):

	$object = find( root( $this ), "", "name", $_POST["target"] );

	if( method_exists( $object, "call" ) ):
		echo $object->call( $_POST );
	endif;

endif;

?>