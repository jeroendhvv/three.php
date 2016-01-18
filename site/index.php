<?php

include( "threephp/THREE.php" );

include( "tpl/inc/board.php" );
include( "tpl/inc/street.php" );
include( "tpl/inc/bank.php" );
include( "tpl/inc/house.php" );
include( "tpl/inc/pawn.php" );
include( "tpl/inc/dice.php" );
include( "tpl/inc/game.php" );
include( "tpl/inc/logo.php" );
include( "tpl/inc/dialog.php" );


$project = new Project( null, '{ "name":"Example" }' );

$page = new Page( $project, '{ "name":"Main", "file":"tpl/index.php", "path":"index" }' );
$project->add( $page );

$scene = new Scene( $page, '{ "resize":"true", "stat":"true", "click":"true", "info":"true", "control":"true", "tween":"true", "physics":"true" }' );
$page->add( $scene );

$scene->add( new Bank( $scene, '{ "amount": 24500000 }' ) );

$page->add( new Console( $page, '{}' ) );

$board = new Board( $scene, '{}' );
$scene->add( $board );

$scene->add( new Game( $scene, '{}' ) );

$board->add( new Street( $board, '{ "x":-406, "z":406, "label":"Start" }' ) );
$board->add( new Street( $board, '{ "x":-406, "z":203, "rotation":' . ( 0 - ( M_PI / 2 ) ) . ', "label":"Business Park", "type":"Bedrijfspand", "city":"Vught", "cost":1500000, "profit":12250000 }' ) );
$board->add( new Street( $board, '{ "x":-406, "z":0, "rotation":' . ( 0 - ( M_PI / 2 ) ) . ', "label":"Koningsweg", "type":"Kantoor", "city":"\'s-Hertogenbosch", "cost":2000000, "profit":13750000 }' ) );
$board->add( new Street( $board, '{ "x":-406, "z":-203, "rotation":' . ( 0 - ( M_PI / 2 ) ) . ', "label":"Hooge Steenweg", "type":"Winkels en woningen", "city":"\'s-Hertogenbosch", "cost":3000000, "profit":15000000 }' ) );
$board->add( new Street( $board, '{ "x":-406, "z":-406, "label":"Op bezoek" }' ) );
$board->add( new Street( $board, '{ "x":-203, "z":-406, "rotation":' . ( 0 - M_PI ) . ', "label":"Noble", "type":"Restaurant", "city":"\'s-Hertogenbosch", "cost":3000000, "profit":17500000 }' ) );
$board->add( new Street( $board, '{ "x":0, "z":-406, "rotation":' . ( 0 - M_PI ) . ', "label":"Schapenmarkt", "type":"Winkels", "city":"\'s-Hertogenbosch", "cost":4000000, "profit":20000000 }' ) );
$board->add( new Street( $board, '{ "x":203, "z":-406, "rotation":' . ( 0 - M_PI ) . ', "label":"Kerkstraat", "type":"Winkels", "city":"\'s-Hertogenbosch", "cost":4500000, "profit":21500000 }' ) );
$board->add( new Street( $board, '{ "x":406, "z":-406, "label":"Vrij parkeren" }' ) );
$board->add( new Street( $board, '{ "x":406, "z":-203, "rotation":' . ( M_PI / 2 ) . ', "label":"Borchwerf II", "type":"Distributiecentrum", "city":"Roosendaal", "cost":5000000, "profit":20000000 }' ) );
$board->add( new Street( $board, '{ "x":406, "z":0, "rotation":' . ( M_PI / 2 ) . ', "label":"Noordland", "type":"Distributiecentrum", "city":"Bergen op Zoom", "cost":6000000, "profit":30000000 }' ) );
$board->add( new Street( $board, '{ "x":406, "z":203, "rotation":' . ( M_PI / 2 ) . ', "label":"Stichtsekant", "type":"Distributiecentrum", "city":"Almere", "cost":7000000, "profit":35000000 }' ) );
$board->add( new Street( $board, '{ "x":406, "z":406, "label":"Naar de gevangenis" }' ) );
$board->add( new Street( $board, '{ "x":203, "z":406, "rotation":' . 0 . ', "label":"Siberië", "type":"Distributiecentrum", "city":"Venlo", "cost":7500000, "profit":45000000 }' ) );
$board->add( new Street( $board, '{ "x":0, "z":406, "rotation":' . 0 . ', "label":"Doemere", "type":"Winkelcentrum", "city":"Almere", "cost":8500000, "profit":52000000 }' ) );
$board->add( new Street( $board, '{ "x":-203, "z":406, "rotation":' . 0 . ', "label":"De Markies", "type":"Winkels", "city":"Den Haag", "cost":12250000, "profit":61250000 }' ) );

/*
$board->add( new Street( $board, '{ "x":-406, "z":-406, "label":"Start" }' ) );
$board->add( new Street( $board, '{ "x":-203, "z":-406, "rotation":' . ( M_PI ) . ', "label":"Business Park", "type":"Bedrijfspand", "city":"Vught", "cost":1500000, "profit":12250000 }' ) );
$board->add( new Street( $board, '{ "x":0, "z":-406, "rotation":' . ( 0 - M_PI ) . ', "label":"Koningsweg", "type":"Kantoor", "city":"\'s-Hertogenbosch", "cost":2000000, "profit":13750000 }' ) );
$board->add( new Street( $board, '{ "x":203, "z":-406, "rotation":' . ( 0 - M_PI ) . ', "label":"Hooge Steenweg", "type":"Winkels en woningen", "city":"\'s-Hertogenbosch", "cost":3000000, "profit":15000000 }' ) );
$board->add( new Street( $board, '{ "x":406, "z":-406, "label":"Op bezoek" }' ) );
$board->add( new Street( $board, '{ "x":406, "z":-203, "rotation":' . ( M_PI / 2 ) . ', "label":"Noble", "type":"Restaurant", "city":"\'s-Hertogenbosch", "cost":3000000, "profit":17500000 }' ) );
$board->add( new Street( $board, '{ "x":406, "z":0, "rotation":' . ( M_PI / 2 ) . ', "label":"Schapenmarkt", "type":"Winkels", "city":"\'s-Hertogenbosch", "cost":4000000, "profit":20000000 }' ) );
$board->add( new Street( $board, '{ "x":406, "z":203, "rotation":' . ( M_PI / 2 ) . ', "label":"Kerkstraat", "type":"Winkels", "city":"\'s-Hertogenbosch", "cost":4500000, "profit":21500000 }' ) );
$board->add( new Street( $board, '{ "x":406, "z":406, "label":"Vrij parkeren" }' ) );
$board->add( new Street( $board, '{ "x":203, "z":406, "label":"Borchwerf II", "type":"Distributiecentrum", "city":"Roosendaal", "cost":5000000, "profit":20000000 }' ) );

$board->add( new Street( $board, '{ "x":0, "z":406, "label":"Noordland", "type":"Distributiecentrum", "city":"Bergen op Zoom", "cost":6000000, "profit":30000000 }' ) );
$board->add( new Street( $board, '{ "x":-203, "z":406, "label":"Stichtsekant", "type":"Distributiecentrum", "city":"Almere", "cost":7000000, "profit":35000000 }' ) );
$board->add( new Street( $board, '{ "x":-406, "z":406, "label":"Naar de gevangenis" }' ) );
$board->add( new Street( $board, '{ "x":-406, "z":203, "rotation":' . ( 0 - ( M_PI / 2 ) ) . ', "label":"Siberië", "type":"Distributiecentrum", "city":"Venlo", "cost":7500000, "profit":45000000 }' ) );
$board->add( new Street( $board, '{ "x":-406, "z":0, "rotation":' . ( 0 - ( M_PI / 2 ) ) . ', "label":"Doemere", "type":"Winkelcentrum", "city":"Almere", "cost":8500000, "profit":52000000 }' ) );
$board->add( new Street( $board, '{ "x":-406, "z":-203, "rotation":' . ( 0 - ( M_PI / 2 ) ) . ', "label":"De Markies", "type":"Winkels", "city":"Den Haag", "cost":12250000, "profit":61250000 }' ) );
*/

$board->add( new Pawn( $board, '{}' ) );

// for scripts
$board->add( new House( $board, '{ "render":false }' ) );

$scene->add( new Dice( $scene, '{}' ) );

$scene->add( new Logo( $scene, '{}' ) );

$scene->add( new Dialog( $scene, '{}' ) );

//var_dump( find( root( $project ), "", "name", "bank" ) );

$project->render( "project" );


/*

base javascript object with update functionality
threephp javascript objects (board, pawn enz) inherit from this object.


var button = document.getElementById( 'helix' );
	button.addEventListener( 'click', function ( event ) {

		transform( targets.helix, transformLength );

	}, false );



phase.php
scene add var bank
scene add phase start
add var active phase

dialog object?
button objects?

*/
?>