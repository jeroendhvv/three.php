<?php 

include( "threephp/scene.php" );

class Page extends THREE {
	
	var $secure;
	var $path;
	var $file;
	var $all;

	function __construct( $parent=null, $params_json="" ){

		$this->secure = false;
		$this->name = "Test page";
		$this->path = "";
		$this->file = "";
		$this->all = true;

		parent::__construct( $parent, $params_json );

		if( $this->secure ):
			//check project user
		endif;
	}

	function render( $region="" ){

		$out = "";

		if( $region == "page" ):

			if( $this->all ):
				ob_start();
				include( "inc/header.php" );
				$out .= ob_get_contents();
				ob_end_clean();
			endif;

			if( $this->all ):
				
				if( isset( $this->parent->scripts ) ):
					foreach( $this->parent->scripts as $script ):
						$out .= $script->render( "body" );
					endforeach;
				endif;

				$out .= parse( $this, "body" );

			endif;

			if( $this->file != "" and file_exists( $this->file ) ):
				ob_start();
				include( $this->file );
				$out .= ob_get_contents();
				ob_end_clean();
			else:
				$out .= "File not found: " . $this->file;
			endif;

			if( $this->all ):
				ob_start();
				include( "inc/footer.php" );	
				$out .= ob_get_contents();
				ob_end_clean();
			endif;

		endif;

		return $out;
		
	}

}

?>