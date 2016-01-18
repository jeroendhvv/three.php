<?php

setlocale( LC_ALL, "nl_NL", "nld_nld" );
setlocale( LC_NUMERIC, "C" );
date_default_timezone_set( "Europe/Amsterdam" );

// debug on localhost
if( debug() ):
	error_reporting( E_ALL ^ E_DEPRECATED );
	ini_set( "display_errors", true );
	//ini_set( "error_log", realpath( "." ) . "error.log" );
	ini_set( "xdebug.var_display_max_depth", -1 );
	ini_set( "xdebug.var_display_max_children", -1 );
	ini_set( "xdebug.var_display_max_data", -1 );
endif;

?>