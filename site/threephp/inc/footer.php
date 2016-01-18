<?php if( !defined( "VERSION" ) ) exit( "No direct script access allowed" ); ?>
<?php
if( $this->all ):
	if( isset( $this->parent->scripts ) ):
		foreach( $this->parent->scripts as $script ):
			$out .= $script->render( "footer" );
		endforeach;
	endif;
	//$out .= parse( $this, "body" );
endif;
?>
</body>
</html>