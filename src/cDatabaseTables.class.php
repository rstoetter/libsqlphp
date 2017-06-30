<?php

// cDatabaseTables.class.php
// alle Tabellen einer bestimmten Datenbank

namespace rstoetter\libsqlphp;

/**
  *
  * The class cDatabaseTables holds all tables in a database / schema. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

class cDatabaseTables {

    /**
      * The name of the database / schema
      *
      * @var string
      *
      *
      */

    public $m_schema_name = '';

    /**
      * The database connection
      *
      * @var mysqli
      *
      *
      */

    public $m_mysqli = null;

    /**
      * The tables in the database as array of strings
      *
      * @var array
      *
      *
      */

    public $m_a_tables = array( );	// Feld aus Zeichenketten mit den Tabellennamen der Datenbank


    /**
      *
      * The method GetTable returns the name of the table with the index $index
      *
      * Example:
      *
      *
      * @param int $index is the index of the table
      * @return string the name of the table with the index $index
      *
      */

    public function GetTable( $index ) {

	return ( $this->m_a_tables[ $index ] );

    }	// function GetTable( )



    /**
      *
      * The method GetCount returns the number of the tables in the database
      *
      * Example:
      *
      *
      * @return int the number of tables in the databse
      *
      */


    public function GetCount( ) {

	return count( $this->m_a_tables );

    }	// function GetCount( )


    /**
      *
      * The method ExistsTable returns true, if a table with the name $table_name exists in the databsse
      *
      * Example:
      *
      *
      * @param string $table_name is the name of the table
      * @return bool true, if a table with the name $table_name exists in the databsse
      *
      */


    public function ExistsTable( $table_name ) {

	for ( $i = 0; $i < count( $this->m_a_tables ); $i++ ) {

	    if ( $this->m_a_tables[ $i ] == $table_name ) {
		// echo '<br> ExistsTable: vgl von "' . $table_name . '" mit "' . $this->m_a_tables[ $i ] . '"';
		return true;
	    }

	}

	return false;


    }	// function ExistsTable( )


    /**
      *
      * The method ScanForTables reads all table names out of the databsse
      *
      * Example:
      *
      *
      */

    protected function ScanForTables( ) {

    $this->m_a_tables = array( );

    $query ="
    show tables
";

    $result = $this->m_mysqli->query( $query );

    if ( $result === false ) {

	throw new \Exception("<br>ScanForConstraints( ) Errormessage: %s SQL: %s", $mysqli->error, $query );

    } else {

	// Tables_in_db2phpsite_test

	while ( $row = $result->fetch_row( ) ) {

	    $this->m_a_tables[] = trim( $row[ 0 ] );
	    // echo '<br>' . $row[ 0 ];

	}

    }


    }	// function ScanForConstraints( )


    /**
      *
      * The constructor of cDatabaseTables
      *
      * Example:
      *
      * @param mysqli $mysqli the database connection
      * @param string  $schema_name the name of the database / schema
      *
      * @return cDatabaseTables a new instance of cDatabaseTables
      *
      */


    function __construct( $mysqli, $schema_name ) {

	assert( is_a( $mysqli, 'mysqli' ) );

	$this->m_mysqli = $mysqli;
	$this->m_schema_name = $schema_name;
	$this->m_a_tables = array( );

	$this->ScanForTables( );

    }	// function __construct( )

    /**
      *
      * The destructor of cDatabaseTables
      *
      * Example:
      *
      */


    function __destruct( ) {
    }	// function __destruct( )

}	// class cDatabaseTables



?>