<?php
header( "Content-Type: application/javascript" );

$region = root( $this )->path;

echo parse( root( $this ), $region );

?>