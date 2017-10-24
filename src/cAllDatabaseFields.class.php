<?php

// The COLUMNS table provides information about columns in tables.

/*
cDatabaseField:: (5 methods):
  Dump()
  IsAutoincrement()
  WriteToFile()
  __construct()
  __destruct()

cAllDatabaseFields:: (19 methods):
  AddDatabaseField()
  CollectFieldNamesOfTable()
  CollectFieldsOfTable()
  CollectTablenames()
  Dump()
  ExistsFieldname()
  ExistsTablename()
  GetActiveDatabase()
  GetCount()
  GetDatabaseField()
  GetIndexOf()
  GetTableCount()
  ReadAllFields()
  SortEntries()
  UseDatabase()
  WriteEntriesToFile()
  __construct()
  __destruct()
  fn_compare()
*/

namespace rstoetter\libsqlphp;

/**
  *
  * The class cDatabaseField implements the description of a database field. The namespace is rstoetter\libsqlphp.
  * Normally this class is managed by the class cAllDatabaseFields
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */


class cDatabaseField {

    /**
      * The name of the database field
      *
      * @var string
      *
      *
      */

    public $m_column_name = '';

    /**
      * The type of the field ie "int"
      *
      * @var string
      *
      *
      */

    public $m_field_type = '';		// int

    /**
      * The table the database field belongs to
      *
      * @var string
      *
      *
      */

    public $m_table_name = '';

    /**
      * The databbase / schema the database field belongs to
      *
      * @var string
      *
      *
      */

    public $m_name_database = '';

    /**
      * The data type of the database field
      *
      * @var string
      *
      *
      */

    public $m_datatype = '';		// int

    /**
      * The lebgth of the database field in characters
      *
      * @var int
      *
      *
      */

    public $m_character_maximum_length = 0;

    /**
      * The numerical precision of the database field
      *
      * @var int
      *
      *
      */

    public $m_numeric_precision = 0;

    /**
      * The numeric scale of the database field
      *
      * @var int
      *
      *
      */

    public $m_numeric_scale = 0;

    /**
      * Whether the database field is nullable
      *
      * @var bool
      *
      *
      */

    public $m_is_nullable = false;

    /**
      * The default value of the database field
      *
      * @var string
      *
      *
      */

    public $m_column_default = '';

    /**
      * The column type of the database field - ie: // int(10) unsigned, varchar(255)
      *
      * @var string
      *
      *
      */

    public $m_column_type = '';		// int(10) unsigned, varchar(255)

    /**
      * The column key of the database field - ie: "PRI" ..
      *
      * @var string
      *
      *
      */

    public $m_column_key = '';		// PRI usw

    /**
      * The extra part of the database field
      *
      * @var string
      *
      *
      */

    public $m_extra = '';

    /**
      * The comment of the database field ie: auto_increment
      *
      * @var string
      *
      *
      */

    public $m_column_comment = '';


    /**
      *
      * Writes the column with the index $i to a file with the file handle $file_handle
      *
      * Example:
      *
      *
      * @param resource file_handle the file_handle the file was opened
      * @param int $i the index of the database field
      *
      */

    public function WriteToFile( $file_handle, $i ) {

	$index = sprintf( '%7d', $i );

	fwrite( $file_handle, "\n{$index} " . str_pad( $this->m_name_database . '.' . $this->m_table_name . '.' . $this->m_column_name, 65 ). "\t{$this->m_data_type}" );

    }	// function WriteToFile( )


    /**
      *
      * Dumps the contents of the field
      *
      * Example:
      *
      *
      */

    function Dump( $in_detail = false ) {

	if ( ! $in_detail ) {

	    echo "\n cDatabaseField:" . $this->m_name_database . ',' . $this->m_table_name . ',' . $this->m_column_name ;

	    echo  ',' . $this->m_field_type . ',' . $this->m_datatype;
	    echo ',' . $this->m_character_maximum_length . ',' . $this->m_numeric_precision . ',' . $this->m_numeric_scale;
	    echo ',' . $this->m_is_nullable . ',' . $this->m_column_default;
	    echo ',' . $this->m_column_type . ',' . $this->m_column_key;

	} else {
	    echo "\n cDatabaseField:" . $this->m_name_database . ',' . $this->m_table_name . ',' . $this->m_column_name ;
	    echo  "\n   m_data_type = " . $this->m_data_type;
	    echo  "\n   m_datatype = " . $this->m_datatype;
	    echo  "\n   m_character_maximum_length = " . $this->m_character_maximum_length;
	    echo  "\n   m_numeric_precision = " . $this->m_numeric_precision;
	    echo  "\n   m_numeric_scale = " . $this->m_numeric_scale;
	    echo  "\n   m_is_nullable = " . ( $this->m_is_nullable ? ' nullable ' : ' not nullable ');
	    echo  "\n   m_column_default = " . $this->m_column_default;
	    echo  "\n   m_column_type = " . $this->m_column_type;
	    echo  "\n   m_column_key = " . $this->m_column_key;
	    echo  "\n   m_extra = " . $this->m_extra;
	}

    }	// function Dump( );

    /**
      *
      * The constructor of cDatabaseField
      *
      * Example:
      *
      * @param object $obj_mysqli_row the result of mysqli::fetch_object( )
      *
      * @return cDatabaseField a new instance of cDatabaseField
      *
      */

    function __construct( $obj_mysqli_row  ) {		// cDatabaseField

	assert( $obj_mysqli_row );

	$this->m_column_name = $obj_mysqli_row->COLUMN_NAME;
	$this->m_data_type = $obj_mysqli_row->DATA_TYPE;
	$this->m_table_name = $obj_mysqli_row->TABLE_NAME;
	$this->m_name_database = $obj_mysqli_row->TABLE_SCHEMA;
	$this->m_datatype = $obj_mysqli_row->DATA_TYPE;

	$this->m_character_maximum_length = $obj_mysqli_row->CHARACTER_MAXIMUM_LENGTH;
	$this->m_numeric_precision = $obj_mysqli_row->NUMERIC_PRECISION;
	$this->m_numeric_scale = $obj_mysqli_row->NUMERIC_SCALE;
	$this->m_is_nullable = $obj_mysqli_row->IS_NULLABLE == 'YES';
	$this->m_column_default = $obj_mysqli_row->COLUMN_DEFAULT;
	$this->m_column_type = $obj_mysqli_row->COLUMN_TYPE;
	$this->m_column_key = $obj_mysqli_row->COLUMN_KEY;
	$this->m_extra = $obj_mysqli_row->EXTRA;
	$this->m_column_comment = $obj_mysqli_row->COLUMN_COMMENT;

    }	// function __construct( )

    /**
      *
      * The destructor of cDatabaseField
      *
      * Example:
      *
      *
      */


    function __destruct( ) {
    }	// function __destruct( )

    /**
      *
      * Returns true, if the database field is autoincremented
      *
      * Example:
      *
      * @return bool true, if the database field is autoincremented
      *
      */

    public function IsAutoincrement( ) {

        return ( strpos( $this->m_extra, 'auto_increment' ) !== false );

    }	// function IsAutoincrement( )

}	// class cDatabaseField



/**
  *
  * The class cAllDatabaseFields manages the all fields of a database. The namespace is rstoetter\libsqlphp.
  *
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

class cAllDatabaseFields {

    /**
      * The databbase cobnnection
      *
      * @var mysqli
      *
      *
      */

    public $m_mysqli = null;

    /**
      * The name of the database the table is in
      *
      * @var string
      *
      *
      */

    public $m_database_name = '';

    /**
      * The name of the database the query has used
      *
      * @var string
      *
      *
      */

    protected $m_database_org = '';		// Die Datenbank, die beim Aufruf benutzt wurde

    /**
      * The managed database fields of type cDatabaseField
      *
      * @var array
      *
      *
      */

    public $m_a_database_fields = null;		// Die Datenbankfelder aus Objekten der Klasse cDatabaseField


    /**
      *
      * Retturns the number of tables in the database
      *
      * Example:
      *
      *
      * @return int the number of tables in the database
      *
      */

    function GetTableCount( ) {

        $ret = 0;

        $last_table_name = '';
        for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {

            if ( $this->m_a_database_fields[$i]->m_table_name != $last_table_name )  {

            $ret++;
            $last_table_name = $this->m_a_database_fields[$i]->m_table_name;
            }

        }

        return $ret;

    }	// function GetTableCount( )


    /**
      *
      * Retturns true, if the table name $tablename exists in the database
      *
      * Example:
      *
      *
      * @return bool true, if $tablename exists in the database
      * @param string $tablename the name of the table
      *
      */

    function ExistsTablename( $tablename ) {

	   // liefert alle Felder der Tabelle $tablename im Feld a_fields

	for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {

	    if ( $this->m_a_database_fields[$i]->m_table_name == $tablename )  {

		  return true;
	    }

	}

	return false;

    }	// function ExistsTablename( )

    /**
      *
      * Returns true, if the fieldname $fieldname exists in the database in teh table $tablename
      *
      * Example:
      *
      *
      * @return bool true, if the fieldname $fieldname exists in the database in teh table $tablename
      * @param string $tablename the name of the table
      * @param string $fieldname the name of the field
      *
      */

    function ExistsFieldname( $tablename, $fieldname ) {

	   // liefert alle Felder der Tabelle $tablename im Feld a_fields

	for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {

	    if ( ( $this->m_a_database_fields[$i]->m_table_name == $tablename )  &&
		 ( $this->m_a_database_fields[$i]->m_column_name == $fieldname ) ) {

		  return true;
	    }

	}

	return false;

    }	// function ExistsFieldname( )

    /**
      *
      * returns all fields of a table $tablename in an array of cDatabaseField
      *
      * Example:
      *
      *
      * @return array an array with elements of cDatabaseField
      * @param string $tablename the name of the table
      * @param array $a_fields the resulting array with the table names
      *
      */

    function CollectFieldsOfTable( $tablename, &$a_fields ) {

	   // liefert alle Felder der Tabelle $tablename im Feld a_fields

	$a_fields = array( );

	for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {
	    //  echo "\n " . $this->m_a_database_fields[$i]->m_table_name . '.' . $this->m_a_database_fields[$i]->m_column_name;

	    if ( $this->m_a_database_fields[$i]->m_table_name == $tablename )  {


		  $a_fields[] = $this->m_a_database_fields[$i];
		  // echo "\n trage Feld ein " . $this->m_a_database_fields[$i]->m_table_name . '.' . $this->m_a_database_fields[$i]->m_column_name;
	    }

	}

    }	// function CollectFieldsOfTable( )

    /**
      *
      * returns all field names of a table $tablename in an array of strings
      *
      * Example:
      *
      *
      * @return array an array with elements of string
      * @param string $tablename the name of the table
      * @param array $a_fields the resulting array with the table names
      *
      */


    function CollectFieldNamesOfTable( $tablename, &$a_fields ) {

	   // liefert alle Felder der Tabelle $tablename im Feld a_fields

	$a_fields = array( );

	for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {
	    //  echo "\n " . $this->m_a_database_fields[$i]->m_table_name . '.' . $this->m_a_database_fields[$i]->m_column_name;

	    if ( $this->m_a_database_fields[$i]->m_table_name == $tablename )  {


		  $a_fields[] = $this->m_a_database_fields[$i]->m_column_name;
		  // echo "\n trage Feld ein " . $this->m_a_database_fields[$i]->m_table_name . '.' . $this->m_a_database_fields[$i]->m_column_name;
	    }

	}

    }	// function CollectFieldNamesOfTable( )

    /**
      *
      * returns all tables in the database as an array of strings with the table names
      *
      * Example:
      *
      *
      * @return array an array with elements of cDatabaseField
      * @param array $aTables the resulting array with the table names
      *
      */

    function CollectTablenames( &$aTables ) {

	   // liefert alle Tabellennamen im Feld aTables

	$aTables = array( );

	for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {

	    $found = false;
	    for ( $j = 0; $j < count( $aTables ); $j++  ) {


		if ( $aTables[ $j ]->m_table_name == $this->m_a_database_fields[$i]->m_table_name ) {

		    $found = true;
		    break;

		}

	    }

	    if ( ! $found ) {

		$aTables[] = $this->m_a_database_fields[$i];

	    }

	}

    }	// function CollectTablenames( )

    /**
      *
      * Returns the index of the fieldname $fieldname in the table $tablename
      *
      * Example:
      *
      *
      * @return int -1 if the field $fieldname in $tablename was not find, else the index
      * @param string $tablename the name of the table
      * @param string $fieldname the name of the field
      *
      */

    function GetIndexOf( $tablename, $fieldname ) {

	//
	// liefert den Index für das Feld, welches einer bestimmten Tabelle und einem bestimmten Feld zugeordnet ist
	//
// echo "\n GetIndexOf() mit tn = '$tablename' und fn = '$fieldname'";
	for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {
//         if (  ( $this->m_a_database_fields[$i]->m_table_name == $tablename ) ) echo "\n" . $this->m_a_database_fields[$i]->m_column_name;
	    if (  ( $this->m_a_database_fields[$i]->m_table_name == $tablename ) &&
		  ( $this->m_a_database_fields[$i]->m_column_name == $fieldname ) ) {
		  
		  

		  return $i;
	    }

	}

	return -1;

    }	// function GetIndexOf( )

    /**
      *
      * Dumps the contents of all database fields on the screen
      *
      * Example:
      *
      *
      */

    public function Dump( $in_detail = false, $table_name = '' ) {

	echo "\n cAllDatabaseFields: " . count( $this->m_a_database_fields );
	for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {

	    if ( strlen( $table_name ) ) {
            if ( $this->m_a_database_fields[$i]->m_table_name == $table_name ) {
                $this->m_a_database_fields[$i]->Dump( $in_detail );
            }
	    } else {
            $this->m_a_database_fields[$i]->Dump( $in_detail );
	    }

	}

    }	// function Dump( )

    /**
      *
      * returns the database field with the index $index
      *
      * Example:
      *
      *
      * @return cDatabaseField the searched database field
      * @param int $index the index of the database field, the position in the array
      *
      */

    public function GetDatabaseField( $index ) {

	// liefert ein Objekt vom Typ cDatabaseField

	assert( $index >= 0 );

	return $this->m_a_database_fields[ $index ];

    }	// function GetDatabaseField( )

    /**
      *
      * Returns the number of elements ( database fields ) in the array
      *
      * Example:
      *
      *
      * @return int the number of cDatabaseField in the array
      *
      */

    public function GetCount( ) {

	return count( $this->m_a_database_fields );

    }	// function GetCount( )

    /**
      *
      * Returns the name of the active database
      *
      * Example:
      *
      *
      * @return string the name of the active database
      *
      */

    protected function GetActiveDatabase( ) {

	$ret = '';

	assert( is_a( $this->m_mysqli, 'mysqli' ) );

        $query = 'select Database() as name;';

        $result = $this->m_mysqli->query( $query );

        if ( $result === false ) {
	    var_dump(debug_backtrace());
	    die("\n cAllDatabaseFields: Abbruch wegen Fehlers bei $query");
        }

        $row = $result->fetch_object( );

	$ret = $row->name;

	$result->close( );

	return $ret;

    }		// function GetActiveDatabase( );

    /**
      *
      * changes the active database
      *
      * Example:
      *
      *
      * @param string the name of the target database
      *
      */

    protected function UseDatabase( $database_name ) {

	$ret = '';

        $query = 'use ' . $database_name . ';';

        $result = $this->m_mysqli->query( $query );

	return $ret;

    }		// function UseDatabase( );

    /**
      *
      * adds a database field $obj_database_field to the managed fields
      *
      * Example:
      *
      *
      * @param cDatabaseField the database field, which should be added
      *
      */

    protected function AddDatabaseField( $obj_database_field ) {

	assert( $obj_database_field );

	$this->m_a_database_fields[] = $obj_database_field;

    }	// function AddDatabaseField( )

    /**
      *
      * reads all fields of the database $name_database and stores them as cDatabaseField in the array
      *
      * @param string $name_database the name of the database
      * @param string $name_table the name of the table - if it is an empty string "" then all tables of the database $name_database are examined
      *
      * Example:
      *
      *
      *
      */


    protected function ReadAllFields( $name_database, $name_table ) {

        $ret = true;

// 	$this->UseDatabase( 'information_schema' );
// 	assert( $this->GetActiveDatabase( ) == 'information_schema' );

	if ( $name_table != '' ) {

	    $query = "select * from information_schema.COLUMNS where TABLE_SCHEMA = '{$name_database}'  AND TABLE_NAME = '{$name_table}' order by TABLE_NAME, COLUMN_NAME; ";
	    // echo "\n cAllDatabaseFields::query = " . $query;

	} else {

	    $query = "select * from information_schema.COLUMNS where TABLE_SCHEMA = '{$name_database}' order by TABLE_NAME, COLUMN_NAME; ";

	}

	// echo "\n cAllDatabaseFields::query für $name_table = \n" . $query;

        $result = $this->m_mysqli->query( $query );

        if ( $result === false ) {

	    throw new \Exception("\n cAllDatabaseFields: Abbruch wegen Fehler beim Einlesen !");

        }

        // echo "<br> scanning with '$query'";
        while( $row = $result->fetch_object( ) ) {

	    // $this->m_allTables[] = $row->TABLE_NAME;
	    $obj = new cDatabaseField( $row );
	    $this->AddDatabaseField( $obj );
	    // echo '<br>' . $row->TABLE_NAME;
	}

        $result->close( );

    }	// function ReadAllFields( )

    /**
      *
      * Writes all entries to the file $file_name after sort
      *
      * @param string $file_name the name of the file
      *
      * Example:
      *
      */


    public function WriteEntriesToFile( $file_name ) {

	$this->SortEntries( );

	$file_handle = fopen( $file_name, 'w+' );

	if ( $file_handle !== false ) {

	    for ( $i = 0; $i < count( $this->m_a_database_fields ); $i++ ) {

		$this->m_a_database_fields[ $i ]->WriteToFile( $file_handle, $i );

	    }

	    fclose( $file_handle );

	}

    }	// function WriteEntriesToFile( )

    /**
      *
      * The compare function of SortEntries( )
      *
      * The comparison function must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second. Note that before PHP 7.0.0 this integer had to be in the range from -2147483648 to 2147483647.
      *
      * Example:
      *
      * @param cDatabaseField $a is the first database field to compare
      * @param cDatabaseField $b is the second database field to compare
      *
      */

     static private function fn_compare($a,$b) {

	  // Define the custom sort function

          return $a->m_name_database . $a->m_table_name . $a->m_column_name > $b->m_name_database . $b->m_table_name . $b->m_column_name;

      }      // function fn_compare( )

    /**
      *
      * Sorts the managed entries
      *
      * Example:
      *
      */

      public function SortEntries( ) {

	  // Sort the multidimensional array - not necessary as the database does this job
	  usort( $this->m_a_database_fields, "\\rstoetter\\libsqlphp\\cAllDatabaseFields::fn_compare");


      }	// function SortEntries( )

    /**
      *
      * The constructor of cAllDatabaseFields
      *
      * Example:
      *
      * @param mysqli $mysqli the database connection
      * @param string $name_database the name of the target database to read the fields from
      * @param string $name_table the optional name of the table to examine - if it is an empty string, then all tables are examined. Defaults to an empty string.
      *
      * @return cAllDatabaseFields a new instance of cAllDatabaseFields
      *
      */

    function __construct( $mysqli, $name_database, $name_table = ''  ) {	// cAllDatabaseFields


	// Wenn name_table angegeben, dann nur diese Tabelle einlesen, ansonsten die gesamte Datenbank

	assert( is_a( $mysqli, 'mysqli') );
	if( ! is_a( $mysqli, 'mysqli') ) {

	    debug_print_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
	    die("\n Abbruch: cAllDatabaseFields mit falschem mysqli! " . debug_backtrace()[2]['function'] . ' /' . debug_backtrace()[1]['line']  );

	}

	if ( ! strlen( $name_database ) ) die( "\n Abbruch in cAllDatabaseFields, weil Datenbank = '{$name_database}' ist" );

	$this->m_a_database_fields = array( );

	$this->m_mysqli = $mysqli;
	$this->m_database_name = $name_database;

	$this->m_database_org = $this->GetActiveDatabase( );

	$this->ReadAllFields( $name_database, $name_table );

//	$this->UseDatabase( $this->m_database_org );

    }	// function __construct( )

    /**
      *
      * The destructor of cAllDatabaseFields
      *
      * Example:
      *
      */

    function __destruct( ) {
    }	// function __destruct( )

}	// class cAllDatabaseFields
?>
