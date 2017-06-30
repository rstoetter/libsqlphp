<?php

// cTableConstraints.class.php
// Alle Constraints einer bestimmten Tabelle

/*

cTableConstraintsEntry:: (4 methods):
  IsForeignKey()
  IsPrimaryKey()
  __construct()
  __destruct()

cTableConstraints:: (10 methods):
  GetForeignKeyNames()
  GetFullForeignKey()
  GetFullPrimaryKey()
  IsForeignKey()
  IsPrimaryKey()
  GetConstraint()
  GetCount()
  ScanForConstraints()
  __construct()
  __destruct()

*/


namespace rstoetter\libsqlphp;


/**
  *
  * The class cTableConstraintsEntry implements objects managed by cTableConstraints. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

class cTableConstraintsEntry {

    // an entry of cTableConstraints
    
    /**
      * The name of the table
      *
      * @var string The name of the table
      *
      *
      */    

    public $m_TABLE_NAME = '';
    
    /**
      * The name of the column
      *
      * @var string The name of the column
      *
      *
      */
    
    
    public $m_COLUMN_NAME = '';
    
    /**
      *
      *
      * @var string The name of the constraint
      *
      *
      */
    
    
    public $m_CONSTRAINT_NAME = '';
    
    /**
      *
      *
      * @var string The name of the referenced table
      *
      *
      */
    
    
    public $m_REFERENCED_TABLE_NAME = '';
    
    /**
      *
      *
      * @var string The name of the referenced column
      *
      *
      */
    
    
    public $m_REFERENCED_COLUMN_NAME = '';
    
    
    /**
      *
      * The method IsForeignKey( ) returns true, if the object is a foreign key
      *
      * Example:
      *
      *
      * @return bool true, if the object is a foreign key
      *
      */    
    
    
    function IsForeignKey( ) {
    
	// ist die Spalte Bestandteil eines Foreign Keys?
    
	return ( strlen( $this->m_REFERENCED_TABLE_NAME ) > 0 );
    
    }	// function IsForeignKey( )    
    
    /**
      *
      * The method IsPrimaryKey( ) returns true, if the object is a primary key
      *
      * Example:
      *
      *
      * @return bool true, if the object is a primary key.
      *
      */    
    
    
    function IsPrimaryKey( ) {
    
	// ist die Spalte Bestandteil eines Primary Keys?
    
	return ( $this->m_CONSTRAINT_NAME == 'PRIMARY' );
    
    }	// function IsPrimaryKey( )
    
    
    /**
      *
      * The constructor reads the data out of $row
      *
      * Example:
      *
      *
      * @param mysqli_result the row to analyze
      *
      */    
    
    
    function __construct( $row  ) {
    
            assert( $row );
            
            $this->m_TABLE_NAME = $row->TABLE_NAME;
            $this->m_COLUMN_NAME = $row->COLUMN_NAME;
            $this->m_CONSTRAINT_NAME = $row->CONSTRAINT_NAME;
            $this->m_REFERENCED_TABLE_NAME = $row->REFERENCED_TABLE_NAME;
            $this->m_REFERENCED_COLUMN_NAME = $row->REFERENCED_COLUMN_NAME;
	
    }	// function __construct( )
    
    /**
      *
      * The destructor
      *
      * Example:
      *
      *
      */    
    

    function __destruct( ) {
    }	// function __destruct( )
    
}	// class cTableConstraintsEntry


/**
  *
  * The class cTableConstraints manages the constraints of a table. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */


class cTableConstraints {

    /**
      * 
      *
      * @var string The name of the schema
      *
      *
      */    


    public $m_schema_name = '';
    
    /**
      * 
      *
      * @var string The name of the table
      *
      *
      */    
    
    
    public $m_table_name = '';
    
    /**
      * 
      *
      * @var mysqli The database connection
      *
      *
      */    
    
    
    public $m_mysqli = null;
    
    /**
      * 
      *
      * @var array an array with elements of type cTableConstraintsEntry
      *
      *
      */    
    
    
    public $m_a_constraints = null;	// Feld aus Elementen vom Typ cTableConstraintsEntry
    
    /**
      *
      * The method GetPrimaryKeyFieldsWithoutForeignKeys( ) returns in the array $a_pk_ohne_fk all columns which are primary keys and not foreign keys
      *
      * Example:
      *
      *
      * @param array $a_pk_ohne_fk is a string array with the field names of the columns which are primary keys and not foreign keys
      *
      */        
    
    public function GetPrimaryKeyFieldsWithoutForeignKeys( &$a_pk_ohne_fk ) {

	assert( is_array( $a_pk_ohne_fk ) );

	$a_pk_ohne_fk = array( );

	for ( $i = 0; $i < count( $this->m_a_constraints ); $i++ ) {

	    if ( ( $this->m_a_constraints[ $i ]->IsPrimaryKey( ) ) &&
		 ( ! $this->m_a_constraints[ $i ]->IsForeignKey( ) ) ) {

            $a_pk_ohne_fk[] = $this->m_a_constraints[ $i ]->m_COLUMN_NAME;

	    }

	}


    }	// function GetPrimaryKeyFieldsWithoutForeignKeys( )
    
    
    /**
      *
      * The method ExistsField( ) returns true, if there is a field with the column name $column_name
      *
      * Example:
      *
      *
      * @param string the name of the column to search
      * @return bool true, if there is a field with the column name $column_name
      *
      */        
    

    public function ExistsField( $column_name ) {


	for ( $i = 0; $i < count( $this->m_a_constraints ); $i++ ) {

	    if ( $this->m_a_constraints[ $i ]->m_COLUMN_NAME == $column_name )  {

		 return true;

	    }

	}

	return false;


    }	// ExistsField( )

    
    /**
      *
      * The method GetForeignKeyNames( ) returns an array $a_key_names with the names of the foreign keys the column $field_name is participating
      *
      * Example:
      *
      *
      * @param string the name of the column to test for a foreign key
      * @param array a string array with the constraint_names the column $field_name is part of
      *      
      *
      */        
    
    

    public function GetForeignKeyNames( $field_name, &$a_key_names ) {
    
	// liefert in $a_key_names[] die Namen der Foreign Keys, an denen das Feld beteiligt ist
	
        $a_key_names = array( );
        $constraint_name = '';

        for ( $i = 0; $i < count( $this->m_a_constraints ); $i++ ) {
        
            if ( $this->m_a_constraints[ $i ]->m_COLUMN_NAME == $field_name ) {
            
                if ( $this->m_a_constraints[ $i ]->IsForeignKey( ) ) {
                
                    // was the constraint name mentioned before?
                    $found = false;
                    for ( $j = 0; $j < count( $a_key_names ); $j++ ) {
                        if ( $a_key_names[ $j ] == $this->m_a_constraints[ $i ]->m_CONSTRAINT_NAME ) {
                            $found = true;
                            break;
                        }
                    }
                
                
                    if ( ! $found ) {
                    
                        $a_key_names[] = $this->m_a_constraints[ $i ]->m_CONSTRAINT_NAME;
                    
                    }
                
                }
            
            }
            
        }
    }	// public function GetForeignKeyNames( )

    /**
      *
      * @var int index for the returned field of GetFullForeignKey: the name of the constraint 
      *      
      *
      */        
    
    
    const ID_FK_CONSTRAINT_NAME = 0;
    /**
      *
      * @var  int index for the returned field of GetFullForeignKey: the name of the table
      *      
      *
      */        
    
    const ID_FK_TABLE_NAME = 1;
    /**
      *
      * @var  int index for the returned field of GetFullForeignKey: the name of the column
      *      
      *
      */        
    
    const ID_FK_COLUMN_NAME = 2;
    
    /**
      *
      * @var  int index for the returned field of GetFullForeignKey: the name of the referenced table
      *      
      *
      */        
    
    const ID_FK_REFRENCED_TABLE_NAME = 3;
    
    /**
      *
      * @var  int index for the returned field of GetFullForeignKey: the name of the referenced column
      *      
      *
      */        
    
    const ID_FK_REFRENCED_COLUMN_NAME = 4;
    
    
    /**
      *
      * The method GetFullForeignKey( ) returns in an array $a_keys all foreign key columns which belong to a certain constraint $constraint_name
      *
      * Example:
      *
      *
      * @param string the name of the constraint 
      * @param array an array with all foreign key columns which belong to the constraint $constraint_name. The array holds items, which are array with the name of the constraint, the name of the table, the name of the column, the referenced table name and the referenced column name. See the constants ID_FK_CONSTRAINT_NAME, ID_FK_TABLE_NAME, ID_FK_REFRENCED_COLUMN_NAME, ID_FK_REFRENCED_TABLE_NAME, ID_FK_REFRENCED_COLUMN_NAME
      *      
      *
      */        
    
    
    public function GetFullForeignKey( $constraint_name, &$a_keys ) {

	// liefert in $a_keys[] alle Foreign Key-Felder für ein bestimmtes Constraint ( ermttelt mit GetForeignKeyNames( ) )
	// $a_keys besteht aus Feldern!
	
	$a_keys = array( );
	
	for ( $i = 0; $i < count( $this->m_a_constraints ); $i++ ) {
	
	    if ( $this->m_a_constraints[ $i ]->m_CONSTRAINT_NAME == $constraint_name ) {	    
		
		$a_keys[] = array (
		    $this->m_a_constraints[ $i ]->m_CONSTRAINT_NAME,
		    $this->m_a_constraints[ $i ]->m_TABLE_NAME,
		    $this->m_a_constraints[ $i ]->m_COLUMN_NAME,
		    $this->m_a_constraints[ $i ]->m_REFERENCED_TABLE_NAME,
		    $this->m_a_constraints[ $i ]->m_REFERENCED_COLUMN_NAME
		);
		
	    
	    }
	    
	}
	
	
    
    }	// function GetFullPrimaryKey( )    

    
    /**
      *
      * The method GetFullPrimaryKey( ) returns in an array $a_keys the column names of the primary key 
      *
      * Example:
      *
      *
      * @param array an array out of strings with the names of the columns, which are part of the primary key
      *      
      *
      */        
    
    
    public function GetFullPrimaryKey( &$a_keys ) {
    
	// liefert in $aKeys[] den gesamten Primary Key
	
	$a_keys = array( );

	for ( $i = 0; $i < count( $this->m_a_constraints ); $i++ ) {
	
	    if ( $this->m_a_constraints[ $i ]->IsPrimaryKey( ) ) {
	    
		$a_keys[] = $this->m_a_constraints[ $i ]->m_COLUMN_NAME;
	    
	    }
	
	}
    
    }	// function GetFullPrimaryKey( )
    
    
    /**
      *
      * The method IsForeignKey( ) returns true, if the column with the name $column_name belongs to a foreign key
      *
      * Example:
      *
      *
      * @param string column_name the name of the column to examine
      * @return bool true, if the column with the name $column_name belongs to a foreign key
      *      
      *
      */        

      
    public function IsForeignKey( $column_name ) {
    
	// ist $column_name Bestandteil eines Foreign Keys?
    
	for ( $i = 0; $i < count( $this->m_a_constraints ); $i++ ) {
	
	    if ( ( $this->m_a_constraints[ $i ]->m_COLUMN_NAME == $column_name ) && ( $this->m_a_constraints[ $i ]->IsForeignKey( ) ) ) return true;
	
	}    
	
	return false;
    
    
    }	// function IsForeignKey( )
    

    
    /**
      *
      * The method IsPrimaryKey( ) returns true, if the column with the name $column_name belongs to the primary key
      *
      * Example:
      *
      *
      * @param string column_name the name of the column to examine
      * @return bool true, if the column with the name $column_name belongs to the primary key
      *      
      *
      */        
    
    
    public function IsPrimaryKey( $column_name ) {
    
	// ist $column_name Bestandteil eines Primary Keys?
    
        for ( $i = 0; $i < count( $this->m_a_constraints ); $i++ ) {
        
            if ( ( $this->m_a_constraints[ $i ]->m_COLUMN_NAME == $column_name ) && ( $this->m_a_constraints[ $i ]->IsPrimaryKey( ) ) ) return true;
        
        }    
        
        return false;
    
    
    }	// function IsPrimaryKey( )
    
    
    
    
    
    /**
      *
      * The method GetConstraint( ) returns the constraint object with the index $index
      *
      * Example:
      *
      *
      * @param int the index of the mentioned constraint object
      * @return cTableConstraintsEntry the constraint object with the index $index
      *      
      *
      */        
    
    
    
    
    public function GetConstraint( $index ) {
    
        return $this->m_a_constraints[ $index ]; 
    
    }	// function GetColumn( )    
    
    
    /**
      *
      * The method GetCount( ) returns the number of constraint objects managed by the instance
      *
      * Example:
      *
      *
      * @return int the number of constraint objects
      *      
      *
      */        
    
    
    
    public function GetCount( ) {
    
        return count( $this->m_a_constraints );
    
    }	// function GetCount( )    
    
    /**
      *
      * The method ScanForConstraints( ) scans the database for fitting constraint objects
      *
      * Example:
      *
      *
      * 
      *      
      *
      */        
    
    
    protected function ScanForConstraints( ) {

    $table_spec = '';
    if ( ! is_null( $this->m_table_name ) && ( strlen( trim( $this->m_table_name ) ) ) ) {

        $table_spec = " and TABLE_NAME = '{$this->m_table_name}' ";

    }
    
    $query ="
SELECT
TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME 
FROM 
INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE
TABLE_SCHEMA = '{$this->m_schema_name}' {$table_spec};
";    

    // echo "<br>query = $query";

    $result = $this->m_mysqli->query( $query );
    while ( $row = $result->fetch_object( ) ) {
    
        $obj = new cTableConstraintsEntry( $row ) ;
        $this->m_a_constraints[] = $obj;
	
    }
    
    
    }	// function ScanForConstraints( )
    
    
    /**
      *
      * The constructor of an object of type cTableConstraints
      *
      * Example:
      *
      * @param mysqli  the database connection
      * @param string the name of the schema
      * @param string the name of the table      
      *
      */        
    

    function __construct( $mysqli, $schema_name, $table_name ) {	// cTableConstraints
	
        assert( is_a( $mysqli, 'mysqli' ) );
        
        $this->m_mysqli = $mysqli;
        $this->m_table_name = trim( $table_name );
        $this->m_schema_name = trim( $schema_name );
        $this->m_a_constraints = array( );
        
        $this->ScanForConstraints( );
    
    }	// function __construct( )
    
    /**
      *
      * The destructor of an object of type cTableConstraints
      *
      * Example:
      *
      *
      */   
      

    function __destruct( ) {
    }	// function __destruct( )
    
}	// class cTableConstraints
?>
