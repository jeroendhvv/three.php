<?php 

class Click extends THREE {
	
	function __construct( $parent=null, $params_json="" ){

		parent::__construct( $parent, $params_json );
	}

	function render( $region="" ){
		
		$out = "";
		
		if( $region == "script" ):
			
			$out .= "function onDocumentTouchStart( event ){\n";
			$out .= "	event.preventDefault();\n";
			$out .= "	event.clientX = event.touches[0].clientX;\n";
			$out .= "	event.clientY = event.touches[0].clientY;\n";
			$out .= "	onDocumentMouseDown( event );\n";
			$out .= "}\n";
			$out .= "function onDocumentMouseDown( event ){\n";
			$out .= "	event.preventDefault();\n";
			$out .= "	mouse.x = ( event.clientX / window.innerWidth ) * 2 - 1;\n";
			$out .= "	mouse.y = - ( event.clientY / window.innerHeight ) * 2 + 1;\n";
			$out .= "	raycaster.setFromCamera( mouse, camera );\n";
			$out .= "	var intersects = raycaster.intersectObjects( group.children, true );\n";
			$out .= "	var threephp;\n";
			$out .= "	if( intersects.length > 0 ){\n";
			$out .= "		if( intersects[ 0 ].object.userData !== undefined ){\n";
			$out .= "			threephp = intersects[ 0 ].object.userData;\n";
			$out .= "			if( threephp.js !== '' ){\n";
			$out .= "				console.log( 'click: ' + threephp.name );\n";
			$out .= "				call( threephp );\n";
			$out .= "			}\n";
			$out .= "		}\n";
			$out .= "	}\n";
			$out .= "}\n";
			$out .= "function onDocumentMouseMove( event ){\n";
			$out .= "	event.preventDefault();\n";
			$out .= "	mouse.x = ( event.clientX / window.innerWidth ) * 2 - 1;\n";
			$out .= "	mouse.y = - ( event.clientY / window.innerHeight ) * 2 + 1;\n";
			$out .= "	raycaster.setFromCamera( mouse, camera );\n";
			$out .= "	var intersects = raycaster.intersectObjects( group.children, true );\n";
			$out .= "	var threephp;\n";
			$out .= "	if( intersects.length > 0 ){\n";
			$out .= "		if( intersected != intersects[ 0 ].object ){\n";
			$out .= "			console.log( intersects[ 0 ].object.userData.js );\n";
			$out .= "			if( intersects[ 0 ].object.userData.js !== '' ){\n";
			$out .= "				if( intersected ){\n";
			$out .= "					//console.log( 'mouseout ' + intersected.name );\n";
			$out .= "					//intersected.material.emissive.setHex( intersected.currentHex );\n";
			$out .= "				}\n";
			$out .= "				intersected = intersects[ 0 ].object;\n";
			$out .= "				//console.log( 'mouseover ' + intersected.name );\n";
			$out .= "				$( 'body' ).css( { 'cursor':'pointer' } );\n";
			$out .= "				//intersected.currentHex = intersected.material.emissive.getHex();\n";
			$out .= "				//intersected.material.emissive.setHex( 0xff0000 );\n";
			$out .= "			}\n";
			//$out .= "			if( intersects[ 0 ].object.userData !== undefined ){\n";
			//$out .= "			threephp = intersects[ 0 ].object.userData;\n";
			//$out .= "			if( threephp.click !== undefined ){\n";
			//$out .= "				if( intersects[ 0 ].object.material.emissive ){\n";
			//$out .= "					intersects[ 0 ].object.material.emissive.setHex( 0xff0000 );\n";
			//$out .= "				}\n";
			//$out .= "			}\n";
			$out .= "		}\n";
			$out .= "	}else{\n";
			$out .= "		if( intersected ){\n";
			$out .= "			//console.log( 'mouseout ' + intersected.name );\n";
			$out .= "			//intersected.material.emissive.setHex( intersected.currentHex );\n";
			$out .= "			intersected = null;\n";
			$out .= "			$( 'body' ).css( { 'cursor':'default' } );\n";
			$out .= "		}\n";
			$out .= "	}\n";
			$out .= "}\n";
			
		endif;

		if( $region == "main" ):
			
			$out .= "var raycaster, mouse, intersected;\n";
			$out .= "raycaster = new THREE.Raycaster();\n";
			$out .= "mouse = new THREE.Vector2();\n";
			$out .= "document.addEventListener( 'mousedown', onDocumentMouseDown, false );\n";
			$out .= "document.addEventListener( 'touchstart', onDocumentTouchStart, false );\n";
			$out .= "document.addEventListener( 'mousemove', onDocumentMouseMove, false );\n";

		endif;

		return $out;
	}

}

?>