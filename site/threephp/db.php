<?php 

class DB extends THREE {

	var $host;
	var $user;
	var $pass;
	var $db;

	function __construct( $parent=null, $params_json="" ){

		$this->host = "localhost";
		$this->user = "root";
		$this->pass = "";
		$this->db = "threedb";

		parent::__construct( $parent, $params_json );

	}
	
	function query( $sqli ){
		
		$mysqli = new mysqli( $this->host, $this->user, $this->pass, $this->db );
		if( $mysqli->connect_errno ):
			trigger_error( 'Error connection to db: ' . $mysqli->connect_errno );
		endif;
		
		$result = $mysqli->query( $sqli );
		if( $mysqli->error ):
			trigger_error( 'Error in query: ' . $mysqli->error );
		endif;

		if( $mysqli->insert_id ):
			$result = $mysqli->insert_id;
		endif;
		
		$mysqli->close();
		
		return $result;

	}

	function save( $object ){

		$out = 0;

		$sqli = "SELECT \n";
		$sqli .= "  * \n";
		$sqli .= "FROM \n";
		$sqli .= "  `objects` \n";
		$sqli .= "WHERE \n";
		$sqli .= "  `session`='" . root( $this )->session->cookie . "' \n";
		$sqli .= "AND \n";
		$sqli .= "  `class`='" . get_class( $object ) . "' \n";
		$sqli .= "AND \n";
		$sqli .= "  `object`='" . json_encode( clean( $object ) ) . "' \n";
		$sqli .= "AND \n";
		$sqli .= "  `status`=1 \n";
		$result = $this->query( $sqli );
		if( $row = $result->fetch_object() ):
		
			$out = $row->id;

		else:

			$sqli  = "INSERT INTO \n";
			$sqli .= "   `objects` \n";
			$sqli .= "SET \n";
			$sqli .= "   `session`='" . root( $this )->session->cookie . "' \n";
			$sqli .= ",  `parent`='" . $object->parent->name . "' \n";
			$sqli .= ",  `class`='" . get_class( $object ) . "' \n";
			$sqli .= ",  `object`='" . json_encode( clean( $object ) ) . "' \n";
			$sqli .= ",  `time`=CURRENT_TIMESTAMP \n";
			$sqli .= ",  `status`=1 \n";
			$out = $this->query( $sqli ); //returns mysql insert id

		endif;
		
		$result->free();

		return $out;

	}

	function load( $class="", $param="", $match="", $last=false ){
	//function load( $class="", $parent="", $last=false ){
		
		$out = array();

		$sqli  = "SELECT \n";
		$sqli .= "  * \n";
		$sqli .= "FROM \n";
		$sqli .= "  `objects` \n";
		$sqli .= "WHERE \n";
		$sqli .= "  `session`='" . root( $this )->session->cookie . "' \n";
		if( $class != "" ):
			$sqli .= "AND \n";
			$sqli .= "  `class`='" . $class . "' \n";
		endif;
		if( $param != "" AND $match != "" ):
			$sqli .= "AND \n";
			$sqli .= "  `" . $param . "`='" . $match . "' \n";
		endif;
		$sqli .= "AND \n";
		$sqli .= "  `status`=1 \n";
		if( $last ):
			$sqli .= "ORDER BY \n";
			$sqli .= "  `time` DESC \n";
			$sqli .= "LIMIT \n";
			$sqli .= "  0, 1 \n";
		endif;

		$result = $this->query( $sqli );

		while( $row = $result->fetch_object() ):
			$out[] = $row;
		endwhile;

		$result->free();

		return $out;

	}

	function delete( $object ){

		$out = 0;

		$sqli = "SELECT \n";
		$sqli .= "  * \n";
		$sqli .= "FROM \n";
		$sqli .= "  `objects` \n";
		$sqli .= "WHERE \n";
		$sqli .= "  `session`='" . root( $this )->session->cookie . "' \n";
		$sqli .= "AND \n";
		$sqli .= "  `class`='" . get_class( $object ) . "' \n";
		$sqli .= "AND \n";
		$sqli .= "  `object`='" . json_encode( clean( $object ) ) . "' \n";
		$sqli .= "AND \n";
		$sqli .= "  `status`=1 \n";
		//return $sqli;

		$result = $this->query( $sqli );
		
		if( $row = $result->fetch_object() ):
			
			//return var_dump( $row );
			//$result->free();

			$sqli  = "UPDATE \n";
			$sqli .= "  `objects` \n";
			$sqli .= "SET \n";
			$sqli .= "  `status`=0 \n";
			$sqli .= "WHERE \n";
			$sqli .= "  `id`=" . $row->id . " \n";
			
			//return $sqli;
			//$this->query( $sqli );
			$result->free();
			$result = $this->query( $sqli );
			$out = 1;

		endif;

		return $out;

	}

	/* store everything with the current session to reduce queries */

}

?>