<?php

include( "threephp/session.php" );
include( "threephp/db.php" );
include( "threephp/user.php" );
include( "threephp/page.php" );
include( "threephp/variable.php" );
include( "threephp/call.php" );
include( "threephp/style.php" );
include( "threephp/script.php" );

class Project extends THREE {
	
	var $path;
	var $session;
	var $db;
	var $user;
	var $call;

	function __construct( $parent=null, $params_json="{}" ){
		
		$this->name = "Test project";
			
		parent::__construct( $parent, $params_json );

		if( isset( $_SERVER["QUERY_STRING"] ) AND $_SERVER["QUERY_STRING"] != "" ):
			$this->path = substr( $_SERVER["QUERY_STRING"], 1 );
		else:
			$this->path = "index";
		endif;
		$this->session = new Session( $this, '{}' );
		$this->db = new DB( $this, '{ "host":"' . HOST . '", "database":"' . DB . '", "user":"' . USER . '", "pass":"' . PASS . '" }' );
		$this->user = new User( $this, '{}' );
		$this->call = new Call( $this, '{}' );

		/* system scripts */
		$this->add( new Style( $this, '{ "path":"styles", "region":"head" }' ) );
		$this->add( new Script( $this, '{ "path":"threephp/js/jquery-1.11.2.min.js", "region":"head" }' ) );
		$this->add( new Script( $this, '{ "path":"script", "region":"head" }' ) );
		$this->add( new Script( $this, '{ "path":"main", "region":"footer" }' ) );

		/* system pages */
		$this->add( new Page( $this, '{ "name":"Styles", "file":"threephp/tpl/styles.php", "path":"styles", "all":false }' ) );
		$this->add( new Page( $this, '{ "name":"Scripts head", "file":"threephp/tpl/scripts.php", "path":"script", "all":false }' ) );
		$this->add( new Page( $this, '{ "name":"Scripts footer", "file":"threephp/tpl/scripts.php", "path":"main", "all":false }' ) );
		$this->add( new Page( $this, '{ "name":"Login", "file":"threephp/tpl/login.php", "path":"login" }' ) );
		$this->add( new Page( $this, '{ "name":"Highscore", "file":"threephp/tpl/highscore.php", "path":"highscore" }' ) );
		$this->add( new Page( $this, '{ "name":"Call", "file":"threephp/tpl/call.php", "path":"call", "all":false }' ) );
		$this->add( new Page( $this, '{ "name":"Console", "file":"threephp/tpl/console.php", "path":"console", "all":false }' ) );

	}

	function render( $region="" ){
		
		if( $region == "project" ):
			
			$page = find( $this, "Page", "path", $this->path );
			if( $page == null ):
				if( strpos( $this->path, "/" ) !== false ):
					$parts = explode( "/", $this->path );
					$page = find( $this, "Page", "path", $parts[0] );
					if( $page == null ):
						$page = new Page( $this, '{ "name":"404", "file":"threephp/inc/404.php" }' );
					endif;
				endif;
			endif;
			echo $page->render( "page" );

		endif;

	}

	//find function??
	//with params_json??


}

?>