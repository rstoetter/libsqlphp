<?php

// Klasse zur Verwaltung eines Primary Keys

/*

cPrimaryKeyData:: (10 methods):
  Dump()
  GetDataValue()
  GetFieldCount()
  GetFieldIndex()
  GetFieldName()
  GetFrom()
  SetField()
  SetValue()
  __construct()
  __destruct()

cPrimaryKey:: (16 methods):
  AddField()
  AsSQLCodeConstraint()
  AsSQLConstraint()
  AsSQLDeleteCode()
  AsSQLDeleteStatement()
  Dump()
  GenerateFrom()
  GetFieldCount()
  GetFieldIndex()
  GetFieldName()
  GetLevel()
  GetPrimaryKey()
  GetValuesField()
  IsPrimaryKey()
  ScanValuesFrom()
  SetValues()
  __construct()
  __destruct()

*/

namespace rstoetter\libsqlphp;

/**
  *
  * The class cPrimaryKeyData implements the data part of a Primary Key. It is managed by objects of the class cPrimaryKey. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

class cPrimaryKeyData {

    /**
      * The field names
      *
      * @var array the fields for the primaray key
      *
      *
      */

    protected $m_a_fields = null;

    /**
      * The values
      *
      * @var array the values for the primaray key
      *
      *
      */


    protected $m_a_values = null;

    /**
      *
      * The method Dump( ) dumps the contents of an object of cPrimaryKeyData
      *
      * Example:
      *
      */

    public function Dump( ) {

	echo "\n PrimaryKeyData: \n (";

	for ( $i = 0; $i < count( $this->m_a_fields ); $i++ ){
	  echo ( $i > 0 ? ',' : '');
	  echo $this->m_a_fields[$i];
	}

	echo ")\n (";

	for ( $i = 0; $i < count( $this->m_a_fields ); $i++ ){
	  echo ( $i > 0 ? ',' : '');
	  echo $this->m_a_values[$i];
	}

	echo ")\n";

    } // function Dump( )


    /**
      *
      * The method GetFieldIndex( ) gets the field index of the field name $fieldname
      *
      * Example:
      *
      * @param string $fieldname the field name to look up
      * @return int the field index of $fieldname
      *
      */


    public function GetFieldIndex( $fieldname ) {

	$ret = -1;

	for ( $i = 0; $i < count( $this->m_a_fields ); $i++ ){

	    if ( $this->m_a_fields[ $i ] ) return $i;

	}

	return $ret;

    }	// function GetFieldIndex( )


    /**
      *
      * The method GetDataValue( ) returns the value of the field with the index $index
      *
      * Example:
      *
      * @param string $index the index of the field
      * @return string the value of the field with the index $index
      *
      */


    public function GetDataValue( $index ) {

	return $this->m_a_values[ $index ];

    }	// function GetDataValue( )


    /**
      *
      * The method GetFieldName( ) returns the name of the field with the index $index
      *
      * Example:
      *
      * @param string $index the index of the field
      * @return string the name of the field with the index $index
      *
      */


    public function GetFieldName( $index ) {

	assert( $index < count( $this->m_a_fields) );

	return $this->m_a_fields[ $index ];

    }	// function GetFieldName( )

    /**
      *
      * The method GetFieldCount( ) returns the number of fields managed
      *
      * Example:
      *
      * @return int the number of fields managed
      *
      */


    public function GetFieldCount( ) {

	return count( $this->m_a_fields );

    }	// function FieldCount( )


    /**
      *
      * The method SetField( ) sets the value of the field with the name $fieldname to $fieldval
      *
      * Example:
      *
      * @param string the name of the field
      * @param mixed the value of the field
      *
      */


    public function SetField( $fieldname, $fieldval ) {

	  $index = $this->GetFieldIndex( $fieldname );
	  // $this->m_a_fields[$index] = $fieldname;
	  $this->m_a_values[$index] = $fieldval;


    }	// function SetField( )

    /**
      *
      * The method SetValue( ) sets the value of the field with the index $fieldindex to $fieldval
      *
      * Example:
      *
      * @param int $fieldindex the index of the field
      * @param mixed the value of the field
      *
      */


    public function SetValue( $fieldindex, $fieldval ) {

	  // $this->m_a_fields[$index] = $fieldname;
	  $this->m_a_values[$fieldindex] = $fieldval;


    }	// function SetField( )

    /**
      *
      * The copy constructor
      *
      * Example:
      *
      * @param cPrimaryKey the object to copy the contents from
      *
      */

    public function GetFrom( $objPrimaryKey ) {

      $this->m_a_fields = array( );
      $this->m_a_values = array( );

	assert( get_class( $objPrimaryKey ) == 'rstoetter\libsqlphp\cPrimaryKey' );

	for ( $i = 0; $i < $objPrimaryKey->GetFieldCount( ); $i++ ) {

	    $this->m_a_fields[] = $objPrimaryKey->GetFieldName( $i );
	    $this->m_a_values[] = null;

	}


    }	// function GetFrom( )


    /**
      *
      * The constructor
      *
      * Example:
      *
      * @param cPrimaryKey $objPrimaryKey object to copy the contents from or null. Defaults to null
      *
      */


    function __construct( $objPrimaryKey = null ) {

      $this->m_a_fields = array( );
      $this->m_a_values = array( );

      if ( $objPrimaryKey != null ) {

	  assert( get_class( $objPrimaryKey ) == 'rstoetter\libsqlphp\cPrimaryKey' );
	  $this->GetFrom( $objPrimaryKey );

      }

    }	// $function __construct( )

    /**
      *
      * The destructor
      *
      * Example:
      *
      *
      */


    function __destruct( ) {



    }	// $function __destruct( )

}	// class cPrimaryKeyData


/**
  *
  * The class cPrimaryKey implements a Primary Key. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */


class cPrimaryKey {

    /**
      * The name of the table the primary key belongs to
      *
      * @var string the name of the table
      *
      *
      */

      public $m_table_name = "";


    /**
      * The name of the primary key constraint
      *
      * @var string the name of the primary key constraint
      *
      *
      */


      public $m_constraint_name = "PRIMARY";

    /**
      * The fields of the primary key
      *
      * @var array the fields of the primary key
      *
      *
      */

      public $m_a_fields = null;

    /**
      * The values of the primary key
      *
      * @var array the values of the primary key
      *
      *
      */

      public $m_a_values = null;

    /**
      *
      * The method ScanValuesFrom( ) sets our values from the values of an object of type cPrimaryKeyData
      *
      * Example:
      *
      *
      * @param cPrimaryKeyData $objPrimaryKeyData is the object to copy the values from
      *
      */

      public function ScanValuesFrom( $objPrimaryKeyData ) {

	  assert( get_class( $objPrimaryKeyData ) == 'rstoetter\libsqlphp\cPrimaryKeyData' );

	  for ( $i = 0; $i < count( $this->m_a_fields); $i++ ) {

	      $index = $objPrimaryKeyData->GetFieldIndex( $this->m_a_fields[$i] );

	      $this->m_a_values[ $i ] = $objPrimaryKeyData->GetDataValue( $index );

	  }


      }	// function ScanValuesFrom( )

    /**
      *
      * The method GetFieldName( ) returns the name of the field with the index $index
      *
      * Example:
      *
      *
      * @param int $index is the index of the field
      * @return string the name of the field with the index $index
      *
      */



      public function GetFieldName( $index ) {

	  return $this->m_a_fields[ $index ];

      }	// function GetFieldName( )


    /**
      *
      * The method GetFieldCount( ) returns the number of fields the primary key consists of
      *
      * Example:
      *
      *
      * @return int the number of fields the primary key consists of
      *
      */


      public function GetFieldCount( ) {

	  return count( $this->m_a_fields );

      }	// function FieldCount( )


    /**
      *
      * The method GetValuesField( ) returns an array of the keys for the primary key.
      *
      * The returned array consits of the field names and the data part is null. ie: ( (f1, NULL), ( f2, NULL ) usw. )
      *
      * Example:
      *
      *
      * @return array the array of the keys of the primary key
      * @see GetPrimaryKey
      *
      */


      public function GetValuesField( ) {

	//
      	// liefert ein Feld bestehend aus Schlüsseln für einen Primary Key
	// ( (f1, NULL), ( f2, NULL ) usw. )
	// Der Datenanteil ist NULL
	//

	$ret = array( );

	for ( $i = 0; $i < count( $this->m_a_fields); $i++ ) {

	      $ret[] = array( $this->m_a_fields[ $i ], null );

	}

	return $ret;


      }	// function GetValuesField( )

    /**
      *
      * The method GetPrimaryKey( ) returns an array of the keys for the primary key.
      *
      * The returned array consits of the field names and the data part is null. ie: ( (f1, NULL), ( f2, NULL ) usw. )
      *
      * Example:
      *
      * @param array $ary the returned array
      * @param bool $add_table_names if true, then the table name is added to the field names. Defaults to false.
      * @see GetValuesField
      *
      */


      public function GetPrimaryKey( & $ary, $add_table_names = false ) {

	//
      	// liefert ein Feld bestehend aus Schlüsseln für einen Primary Key
	// ( (f1, NULL), ( f2, NULL ) usw. )
	// Der Datenanteil ist NULL
	//

	$ary = array( );

	$table = ( $add_table_names ? $this->m_table_name . '.' : '' );

	for ( $i = 0; $i < count( $this->m_a_fields); $i++ ) {

	      $ary[] = $table . $this->m_a_fields[ $i ];

	}

      }	// function GetPrimaryKey( )

    /**
      *
      * The method IsPrimaryKey( ) returns true, if the field with the name $field_name is a primary key field
      *
      * Example:
      *
      * @param string $field_name the name of the field
      * @return bool true, if the field with the name $field_name is a primary key field
      *
      */


      public function IsPrimaryKey( $field_name ) {

	foreach ( $this->m_a_fields as $field ) {

	      if ( $field_name == $field ) {

		  return true;

	      }

	}

	return false;

      }	// function IsPrimaryKey( )


    /**
      *
      * The method AsSQLDeleteStatement( ) returns a SQL DELETE statement fitting for the managed primary key, which reflects the keys of the primary key and the values
      * The values are surrounded by "
      *
      * Example:
      *
      * @return string the SQL DELETE statement fitting for the managed primary key
      * @see AsSQLCodeConstraint
      * @see AsSQLConstraint
      * @see AsSQLDeleteCode
      * @see AsSQLDeleteStatement
      *
      */

       public function AsSQLDeleteStatement( ) {

	  $sql_delete ="DELETE FROM $this->m_table_name WHERE " . $this->AsSQLConstraint( );

	  return $sql_delete;

      }	// function AsSQLDeleteStatement( )

    /**
      *
      * The method AsSQLDeleteStatement( ) returns a SQL DELETE statement fitting for the managed primary key, which reflects the keys of the primary key and the values as %s
      * The values are surrounded by "
      *
      * Example:
      *
      * @return string the SQL DELETE statement fitting for the managed primary key
      * @see AsSQLCodeConstraint
      * @see AsSQLConstraint
      * @see AsSQLDeleteCode
      * @see AsSQLDeleteStatement
      *
      */


       public function AsSQLDeleteCode( ) {

	  $sql_delete ="DELETE FROM $this->m_table_name WHERE " . $this->AsSQLCodeConstraint( );

	  return $sql_delete;

      }	// function AsSQLDeleteCode( )

    /**
      *
      * The method AsSQLCodeConstraint( ) returns a SQL constraint fitting for the managed primary key, which reflects the keys of the primary key and sets %s for the values
      * The values are surrounded by "
      *
      * Example:
      *
      * @return string the SQL constraint fitting for the managed primary key
      * @see AsSQLCodeConstraint
      * @see AsSQLConstraint
      * @see AsSQLDeleteCode
      * @see AsSQLDeleteStatement
      *
      */


      public function AsSQLCodeConstraint( ) {

	  $sql_constraint ="";

	  for ( $i = 0; $i < count( $this->m_a_fields); $i++ ) {

	      $sql_constraint .= ( $i > 0 ? ' AND ' : '' );
	      $sql_constraint .= $this->m_a_fields[ $i ] . '= "%s"';

	  }

	  return $sql_constraint;

      }	// function AsSQLCodeConstraint( )


    /**
      *
      * The method AsSQLConstraint( ) returns a SQL statement fitting for the managed primary key, which reflects the keys of the primary key and the values
      * The values are surrounded by "
      *
      * Example:
      *
      * @return string the SQL constraint fitting for the managed primary key
      * @see AsSQLCodeConstraint
      * @see AsSQLConstraint
      * @see AsSQLDeleteCode
      * @see AsSQLDeleteStatement
      *
      */

// TODO AsSQLXXX() besser beschreiben

      public function AsSQLConstraint( ) {

	  $sql_constraint ="";

	  for ( $i = 0; $i < count( $this->m_a_fields); $i++ ) {

	      $sql_constraint .= ( $i > 0 ? ' AND ' : '' );
	      $sql_constraint .= $this->m_a_fields[ $i ] . '="' . $this->m_a_values[ $i ] . '"';

	  }

	  return $sql_constraint;

      }	// function AsSQLConstraint( )

    /**
      *
      * The method GenerateFrom( ) gets its data from $obj_key_column_usage.
      * the values are set to null.
      *
      * Example:
      *
      * @param cKEY_COLUMN_USAGE an object of type cKEY_COLUMN_USAGE
      *
      */


      public function GenerateFrom( $obj_key_column_usage ) {

	// liefert ein Feld bestehend aus den Datenbankfelder des Foreign Keys auf die Tabelle $tablename
	// die NULL-Felder werden nicht verwendet und können später mit Werten aufgefüllt werden

	if( get_class( $obj_key_column_usage ) != 'rstoetter\libsqlphp\cKEY_COLUMN_USAGE' ) {
        var_dump( $obj_key_column_usage );
        die( "\n Abbruch GenerateFrom" );
	}

	$this->m_a_fields = array( );
	$this->m_a_values = array( );

	for ( $i = 0; $i < count( $obj_key_column_usage->m_a_entries ); $i++ ) {

	  $obj = $obj_key_column_usage->m_a_entries[$i];

	  if (
	      ( $obj->m_TABLE_NAME == $this->m_table_name ) &&
	      ( $obj->m_CONSTRAINT_NAME == 'PRIMARY' ) )

	  {

		  $this->m_constraint_name = $obj->m_CONSTRAINT_NAME;
		  // echo "\n", $obj->m_CONSTRAINT_NAME, " " . $obj->m_TABLE_NAME . " -> " . $obj->m_REFERENCED_TABLE_NAME;

		  $this->AddField(
		      $obj->m_COLUMN_NAME,
		      null
		 );



	  }

	}

	// return $ret;

      }	// function GenerateFrom( )

    /**
      *
      * The constructor of cPrimaryKey
      *
      * If no $obj_key_column_usage is given, then field names and values are set to empty
      *
      * Example:
      *
      * @param string $tablename is the name of the table to explore
      * @param cKEY_COLUMN_USAGE an object of class cKEY_COLUMN_USAGE to take into consideration or null. Defaults to null
      *
      */

      function __construct( $tablename, $obj_key_column_usage = null ) {	// cPrimaryKey

	  // assert( is_a($obj_key_column_usage, 'cKEY_COLUMN_USAGE' ) );

	  $this->m_a_fields = array( );
	  $this->m_a_values = array( );

	  $this->m_table_name = $tablename;

	  if ( ( $obj_key_column_usage != null ) && ( get_class( $obj_key_column_usage ) == 'rstoetter\libsqlphp\cKEY_COLUMN_USAGE' ) ) {

	      $this->GenerateFrom( $obj_key_column_usage );

	  }

      }	// function __construct( )


    /**
      *
      * The method AddField( ) adds a field with the name $fieldname and an optional value to the primary key
      *
      * Example:
      *
      * @param string $fieldname is the name of the field to add
      * @param mixed|null $data is the value of the field to add. Defaults to null.
      *
      */


      public function AddField( $fieldname, $data = null) {

	  $this->m_a_fields[] = $fieldname;
	  $this->m_a_values[] = $data;

      }

    /**
      *
      * The destructor of cPrimaryKey
      *
      * Example:
      *
      */


      function __destruct( ) {
      }	// function __destruct( )

    /**
      *
      * The method GetFieldIndex( ) returns the index of a certain field name
      *
      * Example:
      *
      * @param string $fieldname is the name of the field to search
      * @return int the index of the field or -1
      *
      */


      public function GetFieldIndex( $fieldname ) {

	  for ( $i = 0; $i < count( $this->m_a_fields ) ; $i++ ) {

	      if ($this->m_a_fields[$i] == $fieldname ) return $i;

	  }

	  return -1;

      }		// function GetFieldIndex( )

    /**
      *
      * The method SetValues( ) sets the values according to the contents of the array $a_values
      *
      * Example:
      *
      * @param array $a_values is an array, which holds the new values for the primaray key
      *
      */


      public function SetValues( $a_values ) {

	  for ( $i = 0; $i < count( $this->m_a_values ); $i++ ) {

	      $this->m_a_values[$i] = $a_values[$i];

	  }

      }		// function SetValues( )

    /**
      *
      * The method GetLevel( ) returns the level of the primary key - the level is the number of fields the primary key consists of
      *
      * Example:
      *
      * @return int the level of the primary key
      *
      */


      public function GetLevel( ) {

	  return count ( $this->m_a_values );

      }		// function SetValues( )

    /**
      *
      * The method Dump( ) dumpds the contents of the primary key
      *
      * Example:
      *
      */


      public function Dump( ) {

	  echo "\nObjekt von cPrimaryKey für Tabelle $this->m_table_name";

	  echo "\n Feld		Wert";

	  for ( $i = 0; $i < count( $this->m_a_fields ); $i++ ) {

	      echo "\n " . $this->m_a_fields[$i] . "	" . $this->m_a_values[$i];

	  }


      }	// function Dump( )

}	// class cPrimaryKey

?>