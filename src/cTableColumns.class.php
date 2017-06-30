<?php

// cTableColumns.class.php
// alle Spaltendefinitionen einer bestimmten Tabelle

/*

cTableColumnsEntry:: (9 methods):
  Dump()
  IsInt()
  IsNullable()
  IsString()
  IsVarChar()
  KeyIsMultiple()
  KeyIsPrimary()
  KeyIsUnique()
  __construct()
  __destruct()

cTableColumns:: (8 methods):
  Dump()
  ExistsColumn()
  GetColumn()
  GetColumnNames()
  GetColumnObject()
  GetCount()
  ScanForConstraints()
  __construct()
  __destruct()

*/

namespace rstoetter\libsqlphp;


/**
  *
  * The class cTableColumnsEntry implements objects managed by cTableColumns. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

// TODO eventuell zusmmenlegen mit cDatabaseField


class cTableColumnsEntry {

    // an entry of cTableConstraints

    /**
      * The name of the database field
      *
      * @var string
      *
      *
      */

    public $m_COLUMN_NAME ='';

    /**
      * The default value of the column
      *
      * @var mixed
      *
      *
      */

    public $m_COLUMN_DEFAULT ='';

    /**
      * Whether the database field is nullable
      *
      * @var bool
      *
      *
      */

    public $m_IS_NULLABLE ='';

    /**
      * The data type of the database field
      *
      * @var string
      *
      *
      */

    public $m_DATA_TYPE ='';

    /**
      * The lebgth of the database field in characters
      *
      * @var int
      *
      *
      */

    public $m_CHARACTER_MAXIMUM_LENGTH ='';

    /**
      * The numerical precision of the database field
      *
      * @var int
      *
      *
      */

    public $m_NUMERIC_PRECISION ='';

    /**
      * The numeric scale of the database field
      *
      * @var int
      *
      *
      */

    public $m_NUMERIC_SCALE ='';

    /**
      * The column type of the database field - ie: // int(10) unsigned, varchar(255)
      *
      * @var string
      *
      *
      */

    public $m_COLUMN_TYPE='';

    /**
      * The column key of the database field - ie: "PRI" ..
      *
      * @var string
      *
      *
      */

    public $m_COLUMN_KEY ='';

    /**
      * The extra part of the database field
      *
      * @var string
      *
      *
      */

    public $m_EXTRA ='';



    public $m_PRIVILEGES ='';

    /**
      *
      * Dumps the contents of the field
      *
      * Example:
      *
      *
      */

    public function Dump( ) {

	echo "<br>.. Column name = $this->m_COLUMN_NAME und Type = $this->m_COLUMN_TYPE und Datatype = $this->m_DATA_TYPE";

    }	// function Dump( )

    /**
      *
      * The method IsString( ) returns true, if the data type of the object is a string type
      *
      * Example:
      *
      *
      * @return bool true, if the data type of the object is a string type
      *
      */

    public function IsString( ) {

	return ( 	   $this->m_DATA_TYPE == 'char' ||
			   $this->m_DATA_TYPE == 'binary' ||
			   $this->m_DATA_TYPE == 'varchar' ||
			   $this->m_DATA_TYPE == 'varbinary' ||
			   $this->m_DATA_TYPE == 'tinyblob' ||
			   $this->m_DATA_TYPE == 'tinytext' ||
			   $this->m_DATA_TYPE == 'blob' ||
			   $this->m_DATA_TYPE == 'text' ||
			   $this->m_DATA_TYPE == 'mediumblob' ||
			   $this->m_DATA_TYPE == 'mediumtext' ||
			   $this->m_DATA_TYPE == 'longblob' ||
			   $this->m_DATA_TYPE == 'longtext' ||
			   $this->m_DATA_TYPE == 'enum' ||
			   $this->m_DATA_TYPE == 'set'
			  );


    }	// function IsString( )

    /**
      *
      * The method IsDate( ) returns true, if the data type of the object is a date or a datetiem
      *
      * Example:
      *
      *
      * @return bool true, if the data type of the object is a date or a datetiem
      *
      */


    public function IsDate( ) {

	// date oder datetiem werden wie Zeichenketten abgehandelt!

	return ( 	   $this->m_DATA_TYPE == 'date' ||
			   $this->m_DATA_TYPE == 'datetiem'
			  );


    }	// function IsDate( )

    /**
      *
      * The method KeyIsUnique( ) returns true, if the key is an unique one
      *
      * Example:
      *
      *
      * @return bool true, if the key is an unique one
      *
      */



    public function KeyIsUnique( ) {

	return $this->m_COLUMN_KEY == 'UNI';

    }	// function IsNullable( )

    /**
      *
      * The methods KeyIsPrimary( ) returns true, if the field is part of a primary key
      *
      * Example:
      *
      *
      * @return bool true, if the field is part of a primary key
      *
      */


    public function KeyIsPrimary( ) {

	return $this->m_COLUMN_KEY == 'PRI';

    }	// function IsNullable( )


    /**
      *
      * The method KeyIsMultiple( ) returns true, if the field has a MUL-Key
      *
      * If Key is MUL, the column is the first column of a nonunique index in which multiple occurrences
      * of a given value are permitted within the column.
      *
      * Example:
      *
      *
      * @return bool true, if the field has a MUL-Key
      *
      */


    public function KeyIsMultiple( ) {

	// "If Key is MUL, the column is the first column of a nonunique index in which multiple occurrences
	// of a given value are permitted within the column."

	return $this->m_COLUMN_KEY == 'MUL';

    }	// function IsNullable( )


    /**
      *
      * The method IsNullable( ) returns true, if the field can be NULL
      *
      * Example:
      *
      *
      * @return bool true, if the field can be NULL
      *
      */

    public function IsNullable( ) {

	return $this->m_IS_NULLABLE == 'YES';

    }	// function IsNullable( )

    /**
      *
      * The method IsInt( ) returns true, if the field is an integer
      *
      * Example:
      *
      *
      * @return bool true, if the field is an integer
      *
      */


    public function IsInt( ) {

	return $this->m_DATA_TYPE == 'int';

    }	// function IsInt( )

    /**
      *
      * The method IsVarChar( ) returns true, if the field is a varchar
      *
      * Example:
      *
      *
      * @return bool true, if the field is a varchar
      *
      */


    public function IsVarChar( ) {

	return $this->m_DATA_TYPE == 'varchar';

    }	// function IsVarChar( )

    /**
      *
      * The constructor returns a new object of type cTableColumnsEntry
      *
      * Example:
      *
      *
      * @return cTableColumnsEntry
      *
      */


    function __construct( $row  ) {		// cTableColumnsEntry

	assert( $row );

	$this->m_COLUMN_NAME = trim( $row->COLUMN_NAME );
	$this->m_COLUMN_DEFAULT = $row->COLUMN_DEFAULT;
	$this->m_IS_NULLABLE = $row->IS_NULLABLE;
	$this->m_DATA_TYPE = trim( $row->DATA_TYPE );
	$this->m_CHARACTER_MAXIMUM_LENGTH = $row->CHARACTER_MAXIMUM_LENGTH;
	$this->m_NUMERIC_PRECISION = $row->NUMERIC_PRECISION;
	$this->m_NUMERIC_SCALE = $row->NUMERIC_SCALE;
	$this->m_COLUMN_TYPE = trim( $row->COLUMN_TYPE );
	$this->m_COLUMN_KEY = $row->COLUMN_KEY;
	$this->m_EXTRA = $row->EXTRA;
	$this->m_PRIVILEGES = $row->PRIVILEGES;

    }	// function __construct( )

    /**
      *
      * The destructor of cTableColumnsEntry
      *
      * Example:
      *
      *
      */


    function __destruct( ) {
    }	// function __destruct( )

}	// class cTableColumnsEntry


/**
  *
  * The class cTableColumns implements a mysql table, which consists of several columns. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

class cTableColumns {

    /**
      * The name of the database schema
      *
      * @var string
      *
      *
      */


    public $m_schema_name = '';


    /**
      * The name of the table
      *
      * @var string
      *
      *
      */


    public $m_table_name = '';

    /**
      * The database connection
      *
      * @var mysqli
      *
      *
      */


    public $m_mysqli = null;


    /**
      * An array with elements of type cTableColumnsEntry
      *
      * @var array
      *
      *
      */

    public $m_a_columns = null;	// Feld aus Elementen vom Typ cTableColnstraintsEntry


    /**
      *
      * The method GetColumn( ) returns the column with the index $index
      *
      * Example:
      *
      *
      * @param int $index the index of the wanted field
      * @return cTableColumnsEntry the column with the index $index
      *
      */

    public function GetColumn( $index ) {

	return $this->m_a_columns[ $index ];

    }	// function GetColumn( )


    /**
      *
      * The method GetColumnNames( ) returns an array with the names of the columns managed by the object
      *
      * Example:
      *
      *
      * @param array $a_columns an array with the names of the columns managed by the object
      * @param $add_table_name bool true, if the name of the table should be added to the column names. Defaults to false
      *
      */


    public function GetColumnNames( & $a_columns, $add_table_name = false ) {

	$a_columns = array( );

	foreach( $this->m_a_columns as $obj_column ) {

	    if ( ! $add_table_name ) {

		$a_columns[] = $obj_column->m_COLUMN_NAME;

	    } else {

		$a_columns[] = $this->m_table_name . '.' . $obj_column->m_COLUMN_NAME;

	    }

	}

    }	// function GetColumnNames( )


    /**
      *
      * The method Dump( ) dumps the object to the screen
      *
      * Example:
      *
      *
      */



    public function Dump( ) {

	echo '<br>Object cTableColumns with entries:';

	for ( $i = 0; $i < count( $this->m_a_columns ); $i++ ) {

		$this->m_a_columns[ $i ]->Dump( );

	}

    }	// function Dump( )


    /**
      *
      * The method GetColumnObject( ) returns the object of type cTableColumnsEntry of the column with the field name $field_name
      *
      * Example:
      *
      *
      * @param string $field_name the name of the field to examine
      * @return cTableColumnsEntry|null the object of type cTableColumnsEntry
      *
      */


    public function GetColumnObject( $field_name ) {

	for ( $i = 0; $i < count( $this->m_a_columns ); $i++ ) {

	    if ( $this->m_a_columns[ $i ]->m_COLUMN_NAME == $field_name ) {

		return $this->m_a_columns[ $i ];

	    }

	}

	return null;

    }	// function GetColumnObject( )


    /**
      *
      * The method GetCount( ) returns the number of column objects managed by cTableColumns
      *
      * Example:
      *
      *
      * @return int the number of column objects managed by cTableColumns
      *
      */

    public function GetCount( ) {

	return count( $this->m_a_columns );

    }	// function GetCount( )


    /**
      *
      * The method ExistsColumn( ) returns true, if a column object with the column name $column_name is managed by cTableColumns
      *
      * Example:
      *
      *
      * @return bool true, if a column object with the column name $column_name is managed by cTableColumns
      *
      */


    public function ExistsColumn( $column_name ) {

	for ( $i = 0; $i < count( $this->m_a_columns ); $i++ ) {

	    if ( $this->m_a_columns[ $i ]->m_COLUMN_NAME == $column_name ) return true;

	}

	if ( false ) {
	    echo "<br> ExistsColumn() findet '$column_name' nicht mit der  Aufstellung : ";
	    $this->Dump( );
	}

	return false;


    }	// function ExistsColumn( )

    /**
      *
      * The method ScanForConstraints( ) scans the database for fitting constraints for the table.
      * If a schema name is given, it is used.
      *
      * Example:
      *
      *
      */


    protected function ScanForConstraints( ) {

    $schema = ( strlen( $this->m_schema_name ) ? " TABLE_SCHEMA = '{$this->m_schema_name}' AND " : '' );

    $query ="
SELECT
COLUMN_NAME, COLUMN_DEFAULT, IS_NULLABLE, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE,
COLUMN_TYPE, COLUMN_KEY, EXTRA, PRIVILEGES
FROM
INFORMATION_SCHEMA.COLUMNS
WHERE
{$schema} TABLE_NAME = '{$this->m_table_name}';
";

    $result = $this->m_mysqli->query( $query );

    if ( $result === false ) {

	throw new \Exception( sprintf( "<br>ScanForConstraints( ) Errormessage: %s SQL: %s", $this->m_mysqli->error, $query ) );

    } else {

	while ( $row = $result->fetch_object( ) ) {

	    $obj = new cTableColumnsEntry( $row ) ;
	    $this->m_a_columns[] = $obj;

	}

    }


    }	// function ScanForConstraints( )


    /**
      *
      * The constructor of cTableColumns returns new instances of cTableColumns
      *
      * Example:
      *
      *
      * @param mysqli the database connection
      * @param string $schema_name is the name of the schema to scan for columns
      * @param string $tablename is the name of the table to scan for columns
      * @return cTableColumns a new instances of cTableColumns
      *
      */


    function __construct( $mysqli, $schema_name, $tablename ) {	// cTableColumns

	assert( is_a( $mysqli, 'mysqli' ) );

	$this->m_mysqli = $mysqli;
	$this->m_table_name = $tablename;
	$this->m_schema_name = $schema_name;
	$this->m_a_columns = array( );

	$this->ScanForConstraints( );

    }	// function __construct( )

    /**
      *
      * The destructor of cTableColumns
      *
      * Example:
      *
      */


    function __destruct( ) {

	$this->m_a_columns[] = null;

    }	// function __destruct( )


}	// class cTableColumns
?>