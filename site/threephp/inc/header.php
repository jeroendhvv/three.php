<?php if( !defined( "VERSION" ) ) exit( "No direct script access allowed" ); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $this->parent->name; ?> | <?php echo $this->name; ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<?php

// project styles
if( isset( $this->parent->styles ) ):
	foreach( $this->parent->styles as $style ):
		echo $style->render( "head" );
	endforeach;
endif;

// project scripts
if( isset( $this->parent->scripts ) ):
	foreach( $this->parent->scripts as $script ):
		echo $script->render( "head" );
	endforeach;
endif;

// my and my childrens styles and scripts
echo parse( $this, "head" );

?>
</head>
<body>
