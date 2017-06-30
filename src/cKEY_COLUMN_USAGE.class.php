<?php

// Klasse zur Verwaltung von Constraints aus der gleichnamigen Tabelle einer Datenbank vom information_schema

/*

The KEY_COLUMN_USAGE table describes which key columns have constraints.
 Notes:

    If the constraint is a foreign key, then this is the column of the foreign key, not the column that the foreign key references.

    The value of ORDINAL_POSITION is the column's position within the constraint, not the column's position within the table. Column positions are numbered beginning with 1.

    The value of POSITION_IN_UNIQUE_CONSTRAINT is NULL for unique and primary-key constraints. For foreign-key constraints, it is the ordinal position in key of the table that is being referenced.

    PRI=> primary key
    UNI=> unique key
    If Key is MUL, the column is the first column of a nonunique index in which multiple occurrences of a given value are
    permitted within the column.
    If more than one of the Key values applies to a given column of a table, Key displays the one with the highest priority,
    in the order PRI, UNI, MUL.

*/

/*
cKEY_COLUMN_USAGE_Entry:: (6 methods):
  Dump()
  IsReferenceFrom()
  RefersToAnyTable()
  RefersToTable()
  __construct()
  __destruct()

cKEY_COLUMN_USAGE:: (24 methods):
  Count()
  Dump()
  ExistsField()
  ExistsForeignKeyFor()
  ExistsPrimaryKeyFor()
  ReadKeyColumns()
  GetCount()
  GetFieldNames()
  GetFirstTableIndex()
  GetForeignKeyFields()
  GetItem()
  GetPrimaryAndForeignKeys()
  GetPrimaryKeyFields()
  GetPrimaryKeyFieldsWithoutForeignKeys()
  GetPrimaryKeyFields_2()
  GetSourceFieldname()
  GetVorgabewerte()
  HasForeignKey()
  HasPrimaryKey()
  IsPrimaryKey()
  TableRefersToAnyTable()
  TableRefersToTable()
  __construct()
  __destruct()
*/

/*

mysql> describe KEY_COLUMN_USAGE;
+-------------------------------+--------------+------+-----+---------+-------+
| Field                         | Type         | Null | Key | Default | Extra |
+-------------------------------+--------------+------+-----+---------+-------+
| CONSTRAINT_CATALOG            | varchar(512) | NO   |     |         |       |
| CONSTRAINT_SCHEMA             | varchar(64)  | NO   |     |         |       |
| CONSTRAINT_NAME               | varchar(64)  | NO   |     |         |       |
| TABLE_CATALOG                 | varchar(512) | NO   |     |         |       |
| TABLE_SCHEMA                  | varchar(64)  | NO   |     |         |       |
| TABLE_NAME                    | varchar(64)  | NO   |     |         |       |
| COLUMN_NAME                   | varchar(64)  | NO   |     |         |       |
| ORDINAL_POSITION              | bigint(10)   | NO   |     | 0       |       |
| POSITION_IN_UNIQUE_CONSTRAINT | bigint(10)   | YES  |     | NULL    |       |
| REFERENCED_TABLE_SCHEMA       | varchar(64)  | YES  |     | NULL    |       |
| REFERENCED_TABLE_NAME         | varchar(64)  | YES  |     | NULL    |       |
| REFERENCED_COLUMN_NAME        | varchar(64)  | YES  |     | NULL    |       |
+-------------------------------+--------------+------+-----+---------+-------+
12 rows in set (0.24 sec)


*/

/*

CONSTRAINT_NAME ist "PRIMARY" wenn PK ansonsten "t2_ibfk_1" (Tabellenname und FK und Nummer des Indizes)
TABLE_CATALOG ist "def"
TABLE_SCHEMA entspricht CONSTRAINT_SCHEMA
TABLE_NAME entspricht Name der Tabelle
COLUMN_NAME ist der Feldname
ORDINAL_POSITION ist die Position von links des Feldes im Schlüssel
POSITION_IN_UNIQUE_CONSTRAINT ist NULL oder die Position im Foreign Key
REFERENCED_TABLE_SCHEMA entspricht TABLE_SCHEMA oder NULL bei PK
REFERENCED_TABLE_NAME ist der Name der Zieltabelle im FK oder NULL bei PK
REFERENCED_COLUMN_NAME ist der Name des Zielfeldes im FK oder NULL bei PK
*/

namespace rstoetter\libsqlphp;

/**
  *
  * The class cKEY_COLUMN_USAGE_Entry implements an entry of cKEY_COLUMN_USAGE, which manages objects of type cKEY_COLUMN_USAGE_Entry The namespace is rstoetter\libsqlphp.
  *
  *
  * mysql> describe KEY_COLUMN_USAGE;
  * +-------------------------------+--------------+------+-----+---------+-------+
  * | Field                         | Type         | Null | Key | Default | Extra |
  * +-------------------------------+--------------+------+-----+---------+-------+
  * | CONSTRAINT_CATALOG            | varchar(512) | NO   |     |         |       |
  * | CONSTRAINT_SCHEMA             | varchar(64)  | NO   |     |         |       |
  * | CONSTRAINT_NAME               | varchar(64)  | NO   |     |         |       |
  * | TABLE_CATALOG                 | varchar(512) | NO   |     |         |       |
  * | TABLE_SCHEMA                  | varchar(64)  | NO   |     |         |       |
  * | TABLE_NAME                    | varchar(64)  | NO   |     |         |       |
  * | COLUMN_NAME                   | varchar(64)  | NO   |     |         |       |
  * | ORDINAL_POSITION              | bigint(10)   | NO   |     | 0       |       |
  * | POSITION_IN_UNIQUE_CONSTRAINT | bigint(10)   | YES  |     | NULL    |       |
  * | REFERENCED_TABLE_SCHEMA       | varchar(64)  | YES  |     | NULL    |       |
  * | REFERENCED_TABLE_NAME         | varchar(64)  | YES  |     | NULL    |       |
  * | REFERENCED_COLUMN_NAME        | varchar(64)  | YES  |     | NULL    |       |
  * +-------------------------------+--------------+------+-----+---------+-------+
  * 12 rows in set (0.24 sec)
  *
  * mysql> select TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME from information_schema.KEY_COLUMN_USAGE
  * where TABLE_NAME = 'TEST_FK';
  *
  * +------------+------------------+-----------------+-----------------------+
  * | TABLE_NAME | COLUMN_NAME      | CONSTRAINT_NAME | REFERENCED_TABLE_NAME |
  * +------------+------------------+-----------------+-----------------------+
  * | TEST_FK    | ID_MANDANT       | PRIMARY         | NULL                  |
  * | TEST_FK    | ID_BUCHUNGSKREIS | PRIMARY         | NULL                  |
  * | TEST_FK    | f1               | PRIMARY         | NULL                  |
  * | TEST_FK    | ID_MANDANT       | TEST_FK_ibfk_1  | MANDANT               |
  * | TEST_FK    | ID_MANDANT       | TEST_FK_ibfk_2  | BUCHUNGSKREIS         |
  * | TEST_FK    | ID_BUCHUNGSKREIS | TEST_FK_ibfk_2  | BUCHUNGSKREIS         |
  * | TEST_FK    | fk_1             | TEST_FK_ibfk_3  | t11                   |
  * | TEST_FK    | ID_MANDANT       | TEST_FK_ibfk_4  | t11                   |
  * | TEST_FK    | ID_BUCHUNGSKREIS | TEST_FK_ibfk_4  | t11                   |
  * | TEST_FK    | fk_2             | TEST_FK_ibfk_4  | t11                   |
  * +------------+------------------+-----------------+-----------------------+
  *  10 rows in set (0.00 sec)
  *
  * The KEY_COLUMN_USAGE table describes which key columns have constraints.
  *  Notes:
  *
  *     If the constraint is a foreign key, then this is the column of the foreign key, not the column that the foreign key references.
  *
  *     The value of ORDINAL_POSITION is the column's position within the constraint, not the column's position within the table. Column positions are numbered beginning with 1.
  *
  *     The value of POSITION_IN_UNIQUE_CONSTRAINT is NULL for unique and primary-key constraints. For foreign-key constraints, it is the ordinal position in key of the table that is being referenced.
  *
  *     PRI=> primary key
  *     UNI=> unique key
  *     If Key is MUL, the column is the first column of a nonunique index in which multiple occurrences of a given value are
  *     permitted within the column.
  *     If more than one of the Key values applies to a given column of a table, Key displays the one with the highest priority,
  *     in the order PRI, UNI, MUL.
  *
  *
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */


class cKEY_COLUMN_USAGE_Entry {

/**
  *
  * @var string the name of the constraint ( NULL oder 'PRINMARY KEY' )
  *
  */


  public $m_CONSTRAINT_NAME = NULL; // NULL oder "PRINMARY KEY"

/**
  *
  * @var string the name of the table catalog ( i.e. 'def' )
  *
  */

  public $m_TABLE_CATALOG = "def";

/**
  *
  * @var string the name of the table
  *
  */

  public $m_TABLE_NAME = "";

/**
  *
  * @var string the name of the key column
  *
  */

  public $m_COLUMN_NAME = "";

/**
  *
  * @var int the column's position within the constraint, not the column's position within the table. Column positions are numbered beginning with 1.
  *
  */


  public $m_ORDINAL_POSITION = -1;

/**
  *
  * @var int|null NULL for unique and primary-key constraints. For foreign-key constraints, it is the ordinal position in key of the table that is being referenced.
  *
  */




  public $m_POSITION_IN_UNIQUE_CONSTRAINT = -1;


/**
  *
  * @var string if it is a foreign key, then this is the referenced schema
  *
  */


  public $m_REFERENCED_TABLE_SCHEMA = '';


/**
  *
  * @var string if it is a foreign key, then this is the referenced table name
  *
  */


  public $m_REFERENCED_TABLE_NAME = '';

/**
  *
  * @var string if it is a foreign key, then this is the referenced column name
  *
  */

  public $m_REFERENCED_COLUMN_NAME = '';

  // public $m_aReferencedBy = NULL;


  /*public function AddReference( $reference ) {
      assert( is_a( $reference, 'cKEY_COLUMN_USAGE_Entry') );
      assert( $reference-> );
      $this->m_aReferencedBy[] = &$reference;

  }

   public function IsReferenceFrom( $tablename ) {

      for ( $i=0; $i<count($this->m_aReferencedBy); $i++) {

	if ( $this->m_aReferencedBy[ $i ]->m_REFERENCED_TABLE_NAME == $tablename) {
	  return true;
	}

      }

      return false;

  } */


    /**
      *
      * The constructor of cKEY_COLUMN_USAGE_Entry
      *
      * Example:
      *
      * @param string $CONSTRAINT_NAME the name of the constraint
      * @param string $TABLE_CATALOG the name of the table catalog
      * @param string $TABLE_NAME the name of the table
      * @param string $COLUMN_NAME the name of the column
      * @param int $ORDINAL_POSITION the ordinal position of the field
      * @param int $POSITION_IN_UNIQUE_CONSTRAINT the position of the field in a unique constraint
      * @param string $REFERENCED_TABLE_SCHEMA the referenced table schema if it is a foreign key
      * @param string $REFERENCED_TABLE_NAME the referenced table name if it is a foreign key
      * @param string $REFERENCED_COLUMN_NAME the referenced column name if it is a foreign key
      *
      */

  // cKEY_COLUMN_USAGE_Entry
  function __construct(
		  $CONSTRAINT_NAME,
		  $TABLE_CATALOG,
		  $TABLE_NAME,
		  $COLUMN_NAME,
		  $ORDINAL_POSITION,
		  $POSITION_IN_UNIQUE_CONSTRAINT,
		  $REFERENCED_TABLE_SCHEMA,
		  $REFERENCED_TABLE_NAME,
		  $REFERENCED_COLUMN_NAME
		  ) {

    $this->m_CONSTRAINT_NAME = $CONSTRAINT_NAME;
    $this->m_TABLE_CATALOG = $TABLE_CATALOG;
    $this->m_TABLE_NAME = $TABLE_NAME;
    $this->m_COLUMN_NAME = $COLUMN_NAME;
    $this->m_ORDINAL_POSITION = $ORDINAL_POSITION;
    $this->m_POSITION_IN_UNIQUE_CONSTRAINT = $POSITION_IN_UNIQUE_CONSTRAINT;
    $this->m_REFERENCED_TABLE_SCHEMA = $REFERENCED_TABLE_SCHEMA;
    $this->m_REFERENCED_TABLE_NAME = $REFERENCED_TABLE_NAME;
    $this->m_REFERENCED_COLUMN_NAME = $REFERENCED_COLUMN_NAME;

//    $this->m_aReferencedBy = Array( );	// Referenzen von anderen Tabellen werden im Graphen abgebildet

  }  // function __construct( )

    /**
      *
      * The destructor of cKEY_COLUMN_USAGE_Entry
      *
      * Example:
      *
      *
      */


  function __destruct( ) {

  }  // function __destruct( )


    /**
      *
      * The method Dump( )dumps the contents of an  object of class cKEY_COLUMN_USAGE_Entry
      *
      * Example:
      *
      *
      */

  public function Dump( ) {

    echo "\n Objekt vom Typ cKEY_COLUMN_USAGE_Entry";

    echo "\n$this->m_CONSTRAINT_NAME $this->m_TABLE_NAME $this->m_COLUMN_NAME $this->m_ORDINAL_POSITION $this->m_POSITION_IN_UNIQUE_CONSTRAINT $this->m_REFERENCED_TABLE_NAME $this->m_REFERENCED_COLUMN_NAME";
  }	// function Dump( )

    /**
      *
      * The method RefersToTable( ) returns true, if the referenced table name is $target_tablename and the table name is $tablename in a foreign key
      *
      * Example:
      *
      *
      * @param string $tablename is the name of the table
      * @param string $target_tablename is the name of the referenced table
      * @return bool true, if there is a foreign key
      *
      */

  public function RefersToTable( $tablename, $target_tablename ){

      if ($this->m_CONSTRAINT_NAME != 'PRIMARY' ) {

	  if ( ( $this->m_REFERENCED_TABLE_NAME == $target_tablename ) && ( $this->m_TABLE_NAME == $tablename ) ) {
	      return true;
	  }
      }

      return false;


  }	// function RefersToTable( )

    /**
      *
      * The method nTableRefersToAnyTable( ) returns true, if there is any referenced table for the table with the  table name $tablename in a foreign key
      *
      * Example:
      *
      *
      * @param string $tablename is the name of the table to examine
      * @return bool true, if there is any foreign key
      *
      */


  public function RefersToAnyTable( $tablename ){

      if ($this->m_CONSTRAINT_NAME != 'PRIMARY' ) {

	  if ( ( $this->m_REFERENCED_TABLE_NAME != NULL ) && ( $this->m_TABLE_NAME == $tablename ) ) {
	      return true;
	  }
      }

      return false;

  }	// function RefersToAnyTable( )


}	// class cKEY_COLUMN_USAGE_Entry


/**
  *
  * The class cKEY_COLUMN_USAGE implements an representation of the table information_schema.KEY_COLUMN_USAGE
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

class cKEY_COLUMN_USAGE {

    /**
      *
      * @var mysqli the database connection
      *
      *
      */


  public $m_mysqli = null;

    /**
      *
      * @var array thearray with entries of type cKEY_COLUMN_USAGE_Entry
      *
      *
      */


  public $m_a_entries = null;

    /**
      *
      * @var string the name of the schema / database
      *
      *
      */


  public $m_schema_name = '';

    /**
      *
      * @var string if the object only contains the key columns of one table and not of all tables, then this variable holds the table name
      *
      *
      */


  public $m_table_name_restriction = '';	// falls auf eine einzige Tabelle reduziert werden soll, dann ist dieser Wert gesetzt


/*

mysql> select TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME from information_schema.KEY_COLUMN_USAGE
where TABLE_NAME = 'TEST_FK';

+------------+------------------+-----------------+-----------------------+
| TABLE_NAME | COLUMN_NAME      | CONSTRAINT_NAME | REFERENCED_TABLE_NAME |
+------------+------------------+-----------------+-----------------------+
| TEST_FK    | ID_MANDANT       | PRIMARY         | NULL                  |
| TEST_FK    | ID_BUCHUNGSKREIS | PRIMARY         | NULL                  |
| TEST_FK    | f1               | PRIMARY         | NULL                  |
| TEST_FK    | ID_MANDANT       | TEST_FK_ibfk_1  | MANDANT               |
| TEST_FK    | ID_MANDANT       | TEST_FK_ibfk_2  | BUCHUNGSKREIS         |
| TEST_FK    | ID_BUCHUNGSKREIS | TEST_FK_ibfk_2  | BUCHUNGSKREIS         |
| TEST_FK    | fk_1             | TEST_FK_ibfk_3  | t11                   |
| TEST_FK    | ID_MANDANT       | TEST_FK_ibfk_4  | t11                   |
| TEST_FK    | ID_BUCHUNGSKREIS | TEST_FK_ibfk_4  | t11                   |
| TEST_FK    | fk_2             | TEST_FK_ibfk_4  | t11                   |
+------------+------------------+-----------------+-----------------------+
10 rows in set (0.00 sec)

*/


    /**
      *
      * The method ExistsForeignKeyFor returns true, if there exists a foreign key for table $table_name and column $column_name
      *
      * Example:
      *
      *
      * @param string $table_name is the name of the table to examine
      * @param string $column_name is the name of the column to examine
      * @return bool true, if there exists a foreign key for table $table_name and column $column_name
      *
      */

    public function ExistsForeignKeyFor( $table_name, $column_name ) {

	$done = '';

	for ( $i=0; $i<count($this->m_a_entries); $i++){

	    if ( $this->m_a_entries[ $i ]->m_COLUMN_NAME != $done ) {

		if (
			  ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $table_name )  &&
			  ( $this->m_a_entries[ $i ]->m_COLUMN_NAME == $column_name )  &&
			  ( strlen( $this->m_a_entries[ $i ]->m_REFERENCED_TABLE_NAME ) )
			)
		{
			return true;
		}

		$done = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

	    }
	}

	return false;

    }	// function ExistsForeignKeyFor( )

    /**
      *
      * The method ExistsField returns true, if there exists a table $table_name with column $column_name ( whether there is a key column with these components)
      *
      * Example:
      *
      *
      * @param string $table_name is the name of the table to examine
      * @param string $column_name is the name of the column to examine
      * @return bool true, if there exists a table $table_name with column $column_name
      *
      */


    public function ExistsField( $table_name, $column_name ) {

	for ( $i = 0; $i < count( $this->m_a_entries ); $i++){

	    if ( ( $this->m_a_entries[ $i ]->m_COLUMN_NAME == $column_name ) &&
		 ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $table_name )

		) {
		    return true;
	    }
	}

	return false;

    }	// function ExistsField( )

    /**
      *
      * The method ExistsPrimaryKeyFor returns true, if there exists a primary key for table $table_name and column $column_name
      *
      * Example:
      *
      *
      * @param string $table_name is the name of the table to examine
      * @param string $column_name is the name of the column to examine
      * @return bool true, if there exists a primary key for table $table_name and column $column_name
      *
      */


    public function ExistsPrimaryKeyFor( $table_name, $column_name ) {

	$done = '';

	for ( $i=0; $i<count($this->m_a_entries); $i++){

	    // if ( $this->m_a_entries[ $i ]->m_COLUMN_NAME != $done ) {
	    if ( true ) {

		if (
			  ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $table_name )  &&
			  ( $this->m_a_entries[ $i ]->m_COLUMN_NAME == $column_name )  &&
			  ( ( $this->m_a_entries[ $i ]->m_CONSTRAINT_NAME == 'PRIMARY' ) )
			)
		{
			return true;
		}

		// $done = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

	    }
	}

	return false;

    }	// function ExistsPrimaryKeyFor( )

    /**
      *
      * The method GetPrimaryKeyFieldsWithoutForeignKeys returns an array of column names as strings for all fields in the table $table_name, which are primary keys and not mentioned as foreign keys
      *
      * Example:
      *
      *
      * @param string $table_name is the name of the table to examine
      * @param array $ary an array of column names as strings
      *
      */

    public function GetPrimaryKeyFieldsWithoutForeignKeys( $table_name, & $ary ) {

      $ary = array( );

      $done = '';
      for ( $i=0; $i < count( $this->m_a_entries ); $i++){

	  // $this->m_a_entries[ $i ]->Dump( );

	  if ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $table_name ) {

	      if ( $done !== $this->m_a_entries[ $i ]->m_COLUMN_NAME ) {

		  if (  (   $this->ExistsPrimaryKeyFor( $table_name, $this->m_a_entries[ $i ]->m_COLUMN_NAME ) ) &&
			( ! $this->ExistsForeignKeyFor( $table_name, $this->m_a_entries[ $i ]->m_COLUMN_NAME ) )

		      )	{

			$ary[] = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

			// echo "\n füge hinzu " . $this->m_a_entries[ $i ]->m_TABLE_NAME . '.' . $this->m_a_entries[ $i ]->m_COLUMN_NAME;



		  }

		  $done = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

	      } else {
		  // echo "\n verwerfe Feld " . $this->m_a_entries[ $i ]->m_COLUMN_NAME;
	      }

	  }

      }

      // echo "\n GetPrimaryKeyFieldsWithoutForeignKeys( $table_name, ary ) liefert "; var_dump( $ary );

  }	// function GetPrimaryKeyFieldsWithoutForeignKeys( )


    /**
      *
      * The method GetForeignKeyFields returns an array of column names as strings for all fields in the table $table_name, which mentioned as foreign keys
      *
      * Example:
      *
      *
      * @param string $table_name is the name of the table to examine
      * @param array $ary an array of column names as strings
      * @param bool $verwende_nur_pk if true, then only fields are collected, which are primary keys, too. Defaults to false.
      *
      */


    public function GetForeignKeyFields( $table_name, & $ary, $verwende_nur_pk = false ) {

      $ary = array( );

      $done = '';
      for ( $i = 0; $i < count( $this->m_a_entries ); $i++) {


	if ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $table_name ) {

	    if ( $done != $this->m_a_entries[ $i ]->m_COLUMN_NAME ) {

		$done = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

		$pk_check = true;

		if ( $verwende_nur_pk ) {

		    $pk_check = $this->ExistsPrimaryKeyFor( $table_name, $this->m_a_entries[ $i ]->m_COLUMN_NAME );

		}

		$fk_check = $this->ExistsForeignKeyFor( $table_name, $this->m_a_entries[ $i ]->m_COLUMN_NAME );

		if ( $pk_check && $fk_check ) {

		    $ary[] = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

		} else {

		}

	    }

	}
	  // $this->m_a_entries[ $i ]->Dump( );

      }

      // echo "\n GetForeignKeyFields( $table_name, ary ) liefert "; var_dump( $ary );
      // $this->Dump( );

  }	// function GetForeignKeyFields( )

    /**
      *
      * The method GetPrimaryAndForeignKeys( ) returns an array of column names as strings for all fields in the table $table_name, which are primary keys or foreign keys
      *
      * Example:
      *
      *
      * @param string $table_name is the name of the table to examine
      * @param array $ary an array of column names as strings
      *
      */


    public function GetPrimaryAndForeignKeys( $table_name, &$ary ) {

	//
	// get Primary Keys and Foreign Keys of a certain table
	//

	$ary = array( );

	$this->GetPrimaryKeyFields_2( $table_name, $a_pk );
	$this->GetForeignKeyFields( $table_name, $a_fk );

	for ( $i = 0; $i < count( $a_pk ); $i++ ) {

	    $ary[] = $a_pk[ $i ];

	}

	for ( $i = 0; $i < count( $a_fk ); $i++ ) {

	    if ( ! in_array( $a_fk[ $i ], $ary ) ) $ary[] = $a_fk[ $i ];

	}


    }	// function GetPrimaryAndForeignKeys( )


    /**
      *
      * The method HasPrimaryKey( ) returns true, if the table with the name $tablename has any primary key field
      *
      * Example:
      *
      *
      * @param string $tablename is the name of the table to examine
      * @return bool true, if the table with the name $tablename has any primary key field
      *
      */


    public function HasPrimaryKey( $tablename ) {

      for ( $i=0; $i<count($this->m_a_entries); $i++){

	  // $this->m_a_entries[ $i ]->Dump( );

	if 	(  ( $this->m_a_entries[ $i ]->m_CONSTRAINT_NAME == 'PRIMARY' ) &&
		   ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename )
		)
	{
		return true;
	}


      }

      return false;

  }	// function HasPrimaryKey( )

    /**
      *
      * The method HasForeignKey( ) returns true, if the table with the name $tablename has any foreign key
      *
      * Example:
      *
      *
      * @param string $tablename is the name of the table to examine
      * @return bool true, if the table with the name $tablename has any foreign key
      *
      */


    public function HasForeignKey( $tablename ) {

      for ( $i=0; $i<count($this->m_a_entries); $i++){

	  // $this->m_a_entries[ $i ]->Dump( );

	if 	(
		   ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename ) &&
		   ( strlen( $this->m_a_entries[ $i ]->m_REFERENCED_TABLE_NAME ) )
		)
	{
		return true;
	}


      }

      return false;

  }	// function HasPrimaryKey( )


    /**
      *
      * The method GetSourceFieldname( ) returns the field name which is referenced by the foreign table $target_tablename and the foreign field $target_fieldname
      *
      * Example:
      *
      *
      * @param string $source_tablename is the name of the table
      * @param string $target_tablename is the name of the referenced table
      * @param string $target_fieldname is the name of the referenced field
      * @return string the field name or an empty string
      *
      */


  public function  GetSourceFieldname( $source_tablename, $target_tablename, $target_fieldname ){

      $source_fieldname = '';

      for ( $i = 0; $i < count( $this->m_a_entries ); $i++ ){

	  // $this->m_a_entries[ $i ]->Dump( );

	  if 	(  ( $this->m_a_entries[ $i ]->m_CONSTRAINT_NAME != 'PRIMARY' ) &&
		   ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $source_tablename ) &&
		   ( $this->m_a_entries[ $i ]->m_REFERENCED_TABLE_NAME == $target_tablename ) &&
		   ( $this->m_a_entries[ $i ]->m_REFERENCED_COLUMN_NAME == $target_fieldname )
		)
	{
		$source_fieldname = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

		return $source_fieldname;
	}


      }

      assert( false );

      return '';

  }

    /**
      *
      * The method GetVorgabewerte( ) returns an array with the specified values for a source table and its target table
      *
      * array structure:
      * Array( $tablename, $target_tablename, ArraySourceColumns, ArrayTargetColumns, ArrayNullValues );
      * ( tablename, targettablename, (f6,f7) (f1,f2), (NULL, NULL) )
      *  also Tabellenname, Zieltabellenname, Felder der Tabelle, Felder der Zieltabelle, genulltes Feld für die Daten

      * Example:
      *
      *
      * @param string $tablename is the name of the table
      * @param string $target_tablename is the name of the referenced table
      * @return array the resulting array
      *
      */

  public function GetVorgabewerte( $tablename, $target_tablename ) {

      $aVorgabeWerte = Array( );

      // ( tablename, targettablename, (f6,f7) (f1,f2), (NULL, NULL) )
      // also Tabellenname, Zieltabellenname, Felder der Tabelle, Felder der Zieltabelle, genulltes Feld für die Daten

      $aVorgabeWerte[] = Array( $tablename, $target_tablename, Array(), Array(), Array( ) );

      $counter = 0;

      for (  $i = 0; $i < count( $this->m_a_entries ); $i++ ) {

	  if ( 	( $this->m_a_entries[ $i ]->m_TABLE_NAME == $target_tablename  ) &&
		( $this->m_a_entries[ $i ]->RefersToThisTable( $tablename ))  &&
		( $this->m_a_entries[ $i ]->m_CONSTRAINT_NAME != 'PRIMARY' ) ) {

	  }

	  $aVorgabeWerte[2][] = $this->m_a_entries[ $i ]->m_COLUMN_NAME;
	  $aVorgabeWerte[3][] = $this->m_a_entries[ $i ]->m_REFERENCED_COLUMN_NAME;
	  $aVorgabeWerte[4][] = NULL;

      }

      return $aVorgabeWerte;


  }	// function GetVorgabewerte( )

    /**
      *
      * The method TableRefersToTable( ) returns true, if the table with the table name $tablename refers to the table $target_tablename
      *
      * Example:
      *
      *
      * @param string $tablename is the name of the table
      * @param string $target_tablename is the name of the referenced table
      * @return bool true, if the table with the table name $tablename refers to the table $target_tablename
      *
      */


  public function TableRefersToTable( $tablename, $target_tablename ){

      for ( $i=0; $i<count($this->m_a_entries); $i++) {

	  if ( 	( $this->m_a_entries[ $i ]->m_TABLE_NAME == $target_tablename  ) &&
		( $this->m_a_entries[ $i ]->RefersToThisTable( $tablename )) ) return true;

      }

      return false;

  }

    /**
      *
      * The method nTableRefersToAnyTable( ) returns true, if the table with the table name $tablename refers to any table
      *
      * Example:
      *
      *
      * @param string $tablename is the name of the table
      * @return bool true, if the table with the table name $tablename refers to any table
      *
      */


  public function TableRefersToAnyTable( $tablename ) {

      // echo "\nTableRefersToAnyTable( $tablename )";

      for ( $i=0; $i<count($this->m_a_entries); $i++) {

	  if ($this->m_a_entries[ $i ]->RefersToAnyTable( $tablename )) return true;

      }

      // echo "\nTableRefersToAnyTable( $tablename )->false";

      return false;


  } // function TableRefersToAnyTable( )

    /**
      *
      * The method Dump( ) dumps the contents of the cKEY_COLUMN_USAGE object
      *
      * Example:
      *
      */


  public function Dump( ) {

    echo "Liste von cKEY_COLUMN_USAGE:";

    echo "\nCONSTRAINT_NAME TABLE_NAME COLUMN_NAME ORDINAL_POSITION POSITION_IN_UNIQUE_CONSTRAINT REFERENCED_TABLE_NAME REFERENCED_COLUMN_NAME";

    for ( $i=0; $i<count($this->m_a_entries); $i++) {
	$this->m_a_entries[ $i ]->Dump( );
    }
    echo "\n";

  }	// function Dump( )


    /**
      *
      * The method GetItem( ) returns the cKEY_COLUMN_USAGE_Entry with the index $index
      *
      * Example:
      *
      *
      * @param int $index is the index of the object
      * @return cKEY_COLUMN_USAGE_Entry|null the object with the index $index
      *
      */


  public function GetItem( $index ) {

    return $this->m_a_entries[ $index ];

  }	// function GetItem( )


    /**
      *
      * The method __construct( ) is the constructor of objects with the type cKEY_COLUMN_USAGE
      *
      * Example:
      *
      *
      * @param string schema_name the name of the schema
      * @param mysqli the database connection
      * @param string|null the name of the table in the schema. Defaults to ''. If it is an empty string, then the all tables of the schema will be examined
      * @return cKEY_COLUMN_USAGE the object
      *
      */


  function __construct( $schema_name, $mysqli, $table_name = '' ) {	// cKEY_COLUMN_USAGE

      assert( is_a( $mysqli, 'mysqli' ) );
      assert( is_string( $schema_name ) && ( strlen( $schema_name ) ) );
      assert( is_string( $table_name ) );

      if ( ! ( is_a( $mysqli, 'mysqli' ) ) ) die( 'cKEY_COLUMN_USAGE ohne mysqli von ' . debug_backtrace()[1]['function'] . ' /' . debug_backtrace()[0]['line'] );

      $this->m_schema_name = $schema_name;
      $this->m_mysqli = $mysqli;
      $this->m_table_name_restriction = $table_name;

      $this->m_a_entries = array( );
      $this->ReadKeyColumns( );



  }  // function __construct( )

    /**
      *
      * The method Count( ) returns the number of entries of type cKEY_COLUMN_USAGE_Entry
      *
      * Example:
      *
      *
      * @return int the number of elements managed
      *
      */


  public function Count( ) {

      return count( $this->m_a_entries );

  }	// function Count( )

    /**
      *
      * The method GetCount( ) returns the number of entries of type cKEY_COLUMN_USAGE_Entry
      *
      * Example:
      *
      *
      * @return int the number of elements managed
      *
      */


  public function GetCount( ) {

      return $this->Count( );

  }	// function GetCount( )


   /**
      *
      * The method GetPrimaryKeyFields( ) returns the primary key of $table_name as an arry
      *
      *
      * Returns an array of the database table fields of the primary key of the table $tablename
      * the NULL-fields are not used and can later be filled with values
      * => $a_ret = ( (f1, NULL), (f2, NULL), (f3, NULL)   )
      *
      *
      * Example:
      *
      *
      * @param string $tablename the name of the table
      * @param array the primary key as array
      *
      */

  public function GetPrimaryKeyFields( $tablename, &$a_ret ) {

    // liefert ein Feld bestehend aus den Datenbankfelder des Primary Keys der Tabelle $tablename
    // die NULL-Felder werden nicht verwendet und können später mit Werten aufgefüllt werden
    // => $a_ret = ( (f1, NULL), (f2, NULL), (f3, NULL)   )

    $a_ret = array( );

    for ( $i = 0; $i < count( $this->m_a_entries ); $i++ ) {

      if ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename ) {

	  while ( ( $i < $this->Count( ) ) && ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename ) ) {

	      if ( $this->m_a_entries[ $i ]->m_CONSTRAINT_NAME == 'PRIMARY' ) {

		  $a_ret[] = Array( $this->m_a_entries[ $i ]->m_COLUMN_NAME, NULL );

	      }

	      $i++;

	  }

      }

    }

//     return $a_ret;

  }	// function GetPrimaryKeyFields( )

   /**
      *
      * The method GetPrimaryKeyFields_2( ) returns the primary key of $table_name as an arry
      *
      *
      * Returns an array of the database table fields of the primary key of the table $tablename
      * the NULL-fields are not used and can later be filled with values
      * => $a_ret = ( (f1, NULL), (f2, NULL), (f3, NULL)   )
      *
      *
      * Example:
      *
      *
      * @param string $tablename the name of the table
      * @param array $a_ret the primary key as array
      *
      */

    public function GetPrimaryKeyFields_2( $tablename, & $a_ret ) {

    // TODO : die GetPrimaryKeyFields in GetPrimaryKeyFields_3 umbenennen und GetPrimaryKeyFields_2 in GetPrimaryKeyFields

    // liefert ein Feld bestehend aus den Datenbankfelder des Primary Keys der Tabelle $tablename
    // die NULL-Felder werden nicht verwendet und können später mit Werten aufgefüllt werden
    // => $a_ret = ( (f1, NULL), (f2, NULL), (f3, NULL)   )

    $a_ret = Array( );

    for ( $i = 0; $i < count( $this->m_a_entries ); $i++ ) {

      if ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename ) {

	  while ( ( $i < $this->Count( ) ) && ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename ) ) {

	      if ( $this->m_a_entries[ $i ]->m_CONSTRAINT_NAME == 'PRIMARY' ) {

		  $a_ret[] = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

	      }

	      $i++;

	  }

      }

    }

//     return $a_ret;

  }	// function GetPrimaryKeyFields_2( )

   /**
      *
      * The method IsPrimaryKey( ) returns true, if $field_name is part of the primary key of $table_name
      *
      *
      * Example:
      *
      *
      * @param string $table_name the name of the table
      * @param string $field_name the field name to check. The field name can be fully qualified
      *
      */

  public function IsPrimaryKey( $table_name, $field_name ) {

	$this->GetPrimaryKeyFields( $table_name, $a_pk);

	for ( $i = 0; $i < count( $a_pk ); $i++ ) {

	    if ( $a_pk[ $i ][ 0 ] == $this->FieldNameIn( $field_name ) ) {

		return true;

	    }

	}

	return false;

  }	// function IsPrimaryKey( )

   /**
      *
      * The method GetFieldNames( ) returns an array with the key columns of table $table_name
      *
      *
      * Example:
      *
      *
      * @param string $tablename the name of the table
      * @param array $a_ret an array consisting of strings with names of the key columns
      *
      */


  public function GetFieldNames( $tablename, & $a_ret ) {

    // liefert ein Feld bestehend aus den Datenbankfelder der Tabelle $tablename

    $a_ret = Array( );

    for ( $i = 0; $i < count( $this->m_a_entries ); $i++ ) {

      if ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename ) {

	  while ( ( $i < $this->Count( ) ) && ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename ) ) {

		  $a_ret[] = $this->m_a_entries[ $i ]->m_COLUMN_NAME;

	      $i++;

	  }

      }

    }

  }	// function GetFieldNames( )

   /**
      *
      * The method FieldNameIn( ) returns the field name found in the full qualified field name $field_name_qualified
      *
      *
      * Example:
      *
      *
      * @param string $field_name_qualified the full qualified field name
      * @return string the standalone field name or an empty string if a join was given as field_name_qualified
      *
      */

	protected static function FieldNameIn( $field_name_qualified ) {

	// NOTE same as cSqlStatement::FieldNameIn( )

	    if ( substr( trim( $field_name_qualified ), 0, 1 ) == '(' ) return '';



	    $pos = strrpos( $field_name_qualified, '.' );

	    if ( $pos == false ) return trim( $field_name_qualified );


	    return trim( substr( $field_name_qualified, $pos + 1 ) );



	}	// function FieldNameIn( )


   /**
      *
      * The method GetFirstTableIndex( ) returns the first index in the sorted item list which belongs to the table $tablename
      *
      *
      * Example:
      *
      *
      * @param string $tablename the name of the table to search
      * @return int the fiirst index of the table or -1
      *
      */


  public function GetFirstTableIndex( $tablename ) {

      $ret = -1;

      for ( $i = 0; $i < count( $this->m_a_entries ); $i++ ) {

	if ( $this->m_a_entries[ $i ]->m_TABLE_NAME == $tablename ) {

	  return $i;

	}

      }

      return $ret;

  }	// function GetFirstTableIndex( )


   /**
      *
      * The method ReadKeyColumns( ) reads the table information_schema.KEY_COLUMN_USAGE and fills the internal values
      *
      * Used by the constructor.
      *
      * Example:
      *
      */

  protected function ReadKeyColumns( ) {

	$restriction = '';
	if (  ( $this->m_table_name_restriction != '' ) ) {

	    $restriction = ' AND TABLE_NAME = ' . "'" . $this->m_table_name_restriction . "'";

	}

        $query = "
	    SELECT
	      CONSTRAINT_NAME,
	      TABLE_CATALOG ,
	      TABLE_NAME,
	      COLUMN_NAME,
	      ORDINAL_POSITION,
	      POSITION_IN_UNIQUE_CONSTRAINT,
	      REFERENCED_TABLE_SCHEMA,
	      REFERENCED_TABLE_NAME,
	      REFERENCED_COLUMN_NAME
	  FROM
	      information_schema.KEY_COLUMN_USAGE

	  WHERE
	      TABLE_SCHEMA = '$this->m_schema_name' AND
	      CONSTRAINT_CATALOG = 'def'
	      $restriction
	  ORDER BY TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME ; ";

        // echo "\n cKEY_COLUMN_USAGE : lese " . $this->m_schema_name . '- KEY_COLUMN_USAGE';
        // echo "\n query = $query";

        $result = $this->m_mysqli->query( $query );

        if ( $result === false ) {
	    var_dump(debug_backtrace());
	    die("\n cKEY_COLUMN_USAGE: Abbruch wegen Fehlers bei $query");
        }



        while( $row = $result->fetch_object( ) ) {

	    // echo "\n cKEY_COLUMN_USAGE: table = $row->TABLE_NAME, column = $row->COLUMN_NAME";

	    $ref = new cKEY_COLUMN_USAGE_Entry(
			      $row->CONSTRAINT_NAME,
			      $row->TABLE_CATALOG,
			      trim( $row->TABLE_NAME ),
			      trim( $row->COLUMN_NAME) ,
			      $row->ORDINAL_POSITION,
			      $row->POSITION_IN_UNIQUE_CONSTRAINT,
			      $row->REFERENCED_TABLE_SCHEMA,
			      $row->REFERENCED_TABLE_NAME,
			      $row->REFERENCED_COLUMN_NAME
			      );

	    $this->m_a_entries[] = $ref;

	}
  }  // function ReadKeyColumns( )

   /**
      *
      * The destructor of cKEY_COLUMN_USAGE objects
      *
      * Example:
      *
      */



  function __destruct( ) {

  }  // function __destruct( )

}	// class cKEY_COLUMN_USAGE




?>