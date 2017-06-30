<?php

// cTableDescription.class.php
// alle Spaltendefinitionen einer bestimmten Tabelle

/*

cTableDescriptionEntry:: (9 methods):
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

cTableDescription:: (8 methods):
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
  * The class cTableDescriptionEntry implements objects managed by cTableDescription. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */



class cTableDescriptionEntry {

    // an entry of cTableConstraints
    
    /**
      *
      * @var string The name of the column
      *
      *
      */      

    public $m_COLUMN_NAME ='';
    
    /**
      *
      * @var mixed default value of the column
      *
      *
      */      
    
    
    public $m_COLUMN_DEFAULT ='';
    
    /**
      *
      * @var string whether the value is nullable ('YES', if true)
      *
      *
      */      
    
    
    public $m_IS_NULLABLE ='';
    
    /**
      *
      * @var string The type of the column ( ie: 'int(10) unsigned' oder 'mediumtext' )
      *
      *
      */      
    
    
    public $m_COLUMN_TYPE='';	// 'int(10) unsigned' oder 'mediumtext'
    
    /**
      *
      * @var string The key type of the column ( ie: PRI, MUL, UNI )
      *
      *
      */      
    
    
    public $m_COLUMN_KEY ='';	// PRI, MUL, UNI
    
    /**
      *
      * @var string The extra part of the column ( ie: 'auto increment' )
      *
      *
      */       
    
    public $m_EXTRA ='';	// z.B: 'auto increment'
    
    /**
      *
      * The method GetDataType( ) returns the data type of the column ( ie: string, int .. )
      *
      * Example:
      *
      *
      * @return string the data type of the column ( ie: string, int .. )
      *
      */     

    public function GetDataType( ) {

        $pos = strpos( $this->m_COLUMN_TYPE, '(' );

        if ( $pos !== false ) {

            return substr( $this->m_COLUMN_TYPE, 0, $pos -1 );

        }

        return $this->m_COLUMN_TYPE;

    }	// function GetDataType( )

    
    /**
      *
      * The method Dump( ) dumps the object
      *
      * Example:
      *
      *
      */   
      
      
    public function Dump( ) {


	echo "<br>.. Column name = $this->m_COLUMN_NAME und Type = $this->m_COLUMN_TYPE";

    }	// function Dump( )
    
    
    /**
      *
      * The method IsString( ) returns true, if the data type of the column is a string type
      *
      * Example:
      *
      *
      * @return bool true, if the data type of the column is a string type
      *
      */     
    

    public function IsString( ) {

        $data_type = $this->GetDataType( );

        return ( 	   
                $data_type == 'char' ||
                $data_type == 'binary' ||
                $data_type == 'varchar' ||
                $data_type == 'varbinary' ||
                $data_type == 'tinyblob' ||
                $data_type == 'tinytext' ||
                $data_type == 'blob' ||
                $data_type == 'text' ||
                $data_type == 'mediumblob' ||
                $data_type == 'mediumtext' ||
                $data_type == 'longblob' ||
                $data_type == 'longtext' ||
                $data_type == 'enum' ||
                $data_type == 'set'
                );


    }	// function IsString( )
    
    /**
      *
      * The method IsDate( ) returns true, if the data type of the column is a date type ( date or datetime )
      *
      * Example:
      *
      *
      * @return bool true, if the data type of the column is a date type ( date or datetime )
      *
      */     
    

    public function IsDate( ) {

	// date oder datetiem werden wie Zeichenketten abgehandelt!

	$data_type = $this->GetDataType( );

	return ( 	   $data_type == 'date' ||
			   $data_type == 'datetime'
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
      * The method KeyIsPrimary( ) returns true, if the column belongs to the primary key
      *
      * Example:
      *
      *
      * @return bool true, if the column belongs to the primary key
      *
      */     
    

    public function KeyIsPrimary( ) {

        return $this->m_COLUMN_KEY == 'PRI';

    }	// function IsNullable( )
    
    /**
      *
      * The method KeyIsMultiple( ) returns true, if Key is MUL. Then the column is the first column of a nonunique index in which multiple occurrences of a given value are permitted within the column.
      *
      * Example:
      *
      *
      * @return bool true, if the column key is multiple
      *
      */     
    

    public function KeyIsMultiple( ) {

	// "If Key is MUL, the column is the first column of a nonunique index in which multiple occurrences
	// of a given value are permitted within the column."

	return $this->m_COLUMN_KEY == 'MUL';

    }	// function IsNullable( )
    
    
    
    /**
      *
      * The method IsNullable( ) returns true, if the column is nullable. value are permitted within the column.
      *
      * Example:
      *
      *
      * @return bool true, if the column is nullable
      *
      */     


    public function IsNullable( ) {

        return ( $this->m_IS_NULLABLE == 'YES' );

    }	// function IsNullable( )
    
    
    /**
      *
      * The method IsInt( ) returns true, if the column's data type is an integer
      *
      * Example:
      *
      *
      * @return bool true, if the column type is an in
      *
      */     
    

    public function IsInt( ) {

        return $this->GetDataType( ) == 'int';

    }	// function IsInt( )

    
    /**
      *
      * The method IsVarChar( ) returns true, if the column's data type is varchar
      *
      * Example:
      *
      *
      * @return bool true, if the column data type is varchar
      *
      */     
    
    
    public function IsVarChar( ) {

        return $this->GetDataType( ) == 'varchar';

    }	// function IsVarChar( )



    /**
      *
      * The constructor of cTableDescriptionEntry objects
      *
      * Example:
      *
      *
      * @param mysqli_result the row to analyze
      *
      */     



    function __construct( $row  ) {		// cTableDescriptionEntry

        assert( $row );

        $this->m_COLUMN_NAME = trim( $row->Field );
        $this->m_COLUMN_DEFAULT = $row->Default;
        $this->m_IS_NULLABLE = $row->Null;
        $this->m_COLUMN_TYPE = trim( $row->Type );
        $this->m_COLUMN_KEY = $row->Key;
        $this->m_EXTRA = $row->Extra;

    }	// function __construct( )
    
    /**
      *
      * The destructor of cTableDescriptionEntry objects
      *
      * Example:
      *
      *
      */     
    

    function __destruct( ) {
    }	// function __destruct( )

}	// class cTableDescriptionEntry

/**
  *
  * The class cTableDescription describes the fields of a table and manages objects of type cTableDescriptionEntry. The namespace is rstoetter\libsqlphp.
  * The class works 25 % faster than cTableColumns
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */


class cTableDescription {

//
// 25 % schneller als cTableColumns
//


    /**
      *
      * @var string The name of the schema
      *
      *
      */   
      
    public $m_schema_name = '';
    
    /**
      *
      * @var string The name of the table
      *
      *
      */   
    
    
    public $m_table_name = '';
    
    /**
      *
      * @var mysqli The database connection
      *
      *
      */   
    
    
    public $m_mysqli = null;
    
    /**
      *
      * @var array The objects of type cTableDescriptionEntry the instance is managing
      *
      *
      */   
    
    
    
    public $m_a_entries = null;	
    
    /**
      *
      * The method GetColumn( ) returns the managed object of type cTableDescriptionEntry with the index $index
      *
      * Example:
      *
      * @param int $index the index of the desired object
      * @return cTableDescriptionEntry the managed object of type cTableDescriptionEntry with the index $index
      *
      */     
    

    public function GetColumn( $index ) {

        return $this->m_a_entries[ $index ];

    }	// function GetColumn( )
    
    
    /**
      *
      * The method GetColumnNames( ) returns all column names of the managed objects as array 
      *
      * Example:
      *
      * @param array $a_columns an array of strings with the names of the columns
      * @param bool $add_table_name true, if the table name and a point (.) should be prefixed to the names. Defaults to false
      *
      */     
    

    public function GetColumnNames( & $a_columns, $add_table_name = false ) {

        $a_columns = array( );

        foreach( $this->m_a_entries as $obj_column ) {

            if ( ! $add_table_name ) {

                $a_columns[] = $obj_column->m_COLUMN_NAME;

            } else {

                $a_columns[] = $this->m_table_name . '.' . $obj_column->m_COLUMN_NAME;

            }

        }

    }	// function GetColumnNames( )
    
    
    /**
      *
      * The method GetPrimaryKey( ) returns all column names, which are part of the primary key
      *
      * Example:
      *
      * @param array $a_columns an array of strings with the names of the columns, which belong to the primary key
      * @param bool $add_table_name true, if the table name and a point (.) should be prefixed to the names. Defaults to false
      *
      */     
    

    public function GetPrimaryKey( & $a_columns, $add_table_name = false ) {

        $a_columns = array( );

        foreach( $this->m_a_entries as $obj_column ) {

            if ( $obj_column->KeyIsPrimary( ) ) {

            if ( ! $add_table_name ) {

                $a_columns[] = $obj_column->m_COLUMN_NAME;

            } else {

                $a_columns[] = $this->m_table_name . '.' . $obj_column->m_COLUMN_NAME;

            }
            }
        }

    }	// function GetPrimaryKey( )
    
    /**
      *
      * The method IsPrimaryKey( ) returns true, if the field with the name $field_name belongs to the primary key
      *
      * Example:
      *
      * @param string $field_name is the name of the field to check
      * @return bool true, if the field with the name $field_name belongs to the primary key
      *
      */     
    

    public function IsPrimaryKey( $field_name ) {

        foreach ( $this->m_a_entries as $field ) {

            if ( ( $field->KeyIsPrimary( ) ) && ( $field_name == $field->m_COLUMN_NAME ) ) {

            return true;

            }

        }

        return false;

      }	// function IsPrimaryKey( )
      
      
    /**
      *
      * The method Dump( ) dumps the managed objects
      *
      */     
      

    public function Dump( ) {

	echo '<br>Object cTableDescription with entries:';

        for ( $i = 0; $i < count( $this->m_a_entries ); $i++ ) {

            $this->m_a_entries[ $i ]->Dump( );

        }

    }	// function Dump( )
    
    /**
      *
      * The method GetColumnObject( ) returns the object of type cTableDescriptionEntry with the column name $field_name or null
      *
      * Example:
      *
      * @param string $field_name is the name of the field to check
      * @return cTableDescriptionEntry|null the object of type cTableDescriptionEntry with the column name $field_name or null
      *
      */     
    

    public function GetColumnObject( $field_name ) {

        for ( $i = 0; $i < count( $this->m_a_entries ); $i++ ) {

            if ( $this->m_a_entries[ $i ]->m_COLUMN_NAME == $field_name ) {

            return $this->m_a_entries[ $i ];

            }

        }

        return null;

    }	// function GetColumnObject( )

    
    /**
      *
      * The method GetCount( ) returns the number of managed objects
      *
      * Example:
      *
      * @return int the number of managed objects
      *
      */     
    
    
    public function GetCount( ) {

	return count( $this->m_a_entries );

    }	// function GetCount( )
    
    /**
      *
      * The method ExistsColumn( ) returns true, if there exists a column with the name $column_name
      *
      * Example:
      *
      * @return bool true, if there exists a column with the name $column_name
      *
      */         

    public function ExistsColumn( $column_name ) {

	// Der Spaltenname darf nicht qualifiziert sein!

	for ( $i = 0; $i < count( $this->m_a_entries ); $i++ ) {

	    if ( $this->m_a_entries[ $i ]->m_COLUMN_NAME == $column_name ) return true;

	}
/*
	if ( false ) {
	    echo "<br> ExistsColumn() findet '$column_name' nicht mit der  Aufstellung : ";
	    $this->Dump( );
	}
*/
	return false;


    }	// function ExistsColumn( )

    
    /**
      *
      * The method ScanForConstraints( ) reads all managed objects into the arry $m_a_entries
      *
      * Example:
      *
      */         
    
    
    protected function ScanForConstraints( ) {

    $schema = ( strlen( $this->m_schema_name ) ? " {$this->m_schema_name}." : '' );

    $query ="
describe {$schema}{$this->m_table_name};
";

    // echo( "\n ScanForConstraints: $query" );

	$result = $this->m_mysqli->query( $query );

	if ( $result === false ) {

	    printf("<br>cTableDescription:  ScanForConstraints( ) Errormessage: %s SQL: %s", $this->m_mysqli->error, $query );
	    echo "\n $query";
	    assert( false == true );

	} else {

	    while ( $row = $result->fetch_object( ) ) {

		$obj = new cTableDescriptionEntry( $row ) ;
		$this->m_a_entries[] = $obj;

	    }

	}


    }	// function ScanForConstraints( )
    
    /**
      *
      * the constructor for cTableDescription
      *
      * @param mysqli the database connection
      * @param string the name of the schema
      * @param string the name of the table
      *
      * Example:
      *
      */         
    

    function __construct( $mysqli, $schema_name, $table_name ) {	// cTableDescription

        assert( is_a( $mysqli, 'mysqli' ) );
        assert( is_string( $schema_name) );
        assert( is_string( $table_name) );

        if ( ! strlen( $table_name ) ) {

            throw new \Exception("\n cTableDescription mit leerem Tabellennamen ");

        }

        $this->m_mysqli = $mysqli;
        $this->m_table_name = $table_name;
        $this->m_schema_name = $schema_name;

        $this->m_a_entries = array( );

        $this->ScanForConstraints( );

    }	// function __construct( )

    /**
      *
      * the destructor for cTableDescription
      *
      * Example:
      *
      */         
    
    
    function __destruct( ) {
    }	// function __destruct( )

}	// class cTableDescription

?>
