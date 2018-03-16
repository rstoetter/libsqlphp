<?php

// Klasse zur Verwaltung von Bezügen zwischen Tabellen innerhalb einer Datenbank

/*

Dump für cReferenceGraph
 0  t1 (  t2 t3 t4 t5 t6 t7)

 1  t2 (  t3 t4 t5 t6 t7)

 2  t3 (  t4 t5)



Dump für cReferenceGraph
 0  MANDANT (  BUCHUNGSKREIS fk_address t11 TEST_FK)

 1  BUCHUNGSKREIS (  fk_address t11 TEST_FK)

 2  fk_city (  fk_address)

 3  countries (  fk_address fk_city)

 4   (  geodb_type_names)

 5  t1 (  t2 t3 t4 t5 t6 t7)

 6  t2 (  t3 t4 t5 t6 t7)

 7  t3 (  t4 t5)

 8  t11 (  TEST_FK)

 9  _USER (  _USER2BUCHUNGSKREIS _USER2MANDANT _USER2USER_GROUP)

 10  _USER_GROUP (  _USER_GROUP_PRIVILEGE_FIELDS _USER_GROUP_PRIVILEGE_TABLES)

 11  _PRIVILEGE_FIELDS (  _USER_GROUP_PRIVILEGE_FIELDS)

 12  _PRIVILEGE_TABLES (  _USER_GROUP_PRIVILEGE_TABLES)

*/

/*

cReferenceGraphItem:: (7 methods):
  AddReference()
  Dump()
  GetReferencesArray()
  IsReferencedBy()
  ReferenceCount()
  ReferencesWith()
  __construct()

cReferenceGraph:: (10 methods):
  AddReference()
  AddSourceTable()
  Dump()
  GetDependentTablesAsString( )
  GetReferencesArray( )
  GetReferencingTables()
  GetSourceTableIndex()
  IsReferencedByAnyTable()
  TabelleFreistehend()
  TableRefersToAnyTable()
  __construct()
  __destruct()

*/

namespace rstoetter\libsqlphp;

/**
  *
  * The class cTableReference represents a Table reference. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */


class cTableReference {

    /**
      *
      * @var int m_level the level of the table reference. The level is null for primary references which refer to the primary table. The level is 2 for references refering to the primary references and so on.
      * 
      *
      *
      */


    public $m_level = 0;    
    
    /**
      *
      * @var string m_table_name is the name of the table refering to m_refering_to_table_name
      * 
      *
      *
      */
      
    
    public $m_table_name = '';
    
    /**
      *
      * @var string m_referred_table_name is the name of the table refered by m_table_name
      * 
      *
      *
      */
    
    
    public $m_referred_table_name = '';
    
    
    function __construct( int $level, string $refered_table_name ,string $table_name ) {
    
        $this->m_level = $level;
        $this->m_table_name = $table_name;
        $this->m_referred_table_name = $refered_table_name;
    
    
    }   // function __construct( )


}   // class cTableReference



/**
  *
  * The class cReferenceGraphItem implements objects managed by cReferenceGraph. The namespace is rstoetter\libsqlphp.
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

class cReferenceGraphItem {

// ein Eintrag in der Klasse cReferenceGraph

    /**
      * an entry with a pointer to an object of type cKEY_COLUMN_USAGE_Entry
      *
      * @var cKEY_COLUMN_USAGE_Entry an entry
      *
      *
      */

  public $m_entry = NULL;

    /**
      *
      *
      * @var string $m_table_name is name of the table
      *
      *
      */


  public $m_table_name = '';

    /**
      * Elements in this array are table objects which refer to the table $m_table_name
      *
      * @var array $m_a_references is an array of the managed items of type cKEY_COLUMN_USAGE_Entry.
      *
      *
      */


  public $m_a_references = NULL; // Feld aus cKEY_COLUMN_USAGE_Entry

    /**
      *
      * The constructor for objects of type cReferenceGraphItem
      *
      * Example:
      *
      * @param cKEY_COLUMN_USAGE_Entry $obj is an object of type cKEY_COLUMN_USAGE_Entry
      * @param string $table_name the name of the table
      *
      */

  public function __construct( & $obj, $table_name ) {

      // echo "\nnew cReferenceGraphItem für Tabelle $table_name";

      assert( is_a( $obj, 'rstoetter\libsqlphp\cKEY_COLUMN_USAGE_Entry') );
      $this->m_entry = & $obj;
      $this->m_table_name = $table_name;
      $this->m_a_references = array( ); // Feld aus cKEY_COLUMN_USAGE_Entry

  }	// function __construct( )

    /**
      *
      * The method GetReferencesArray returns a new array with objects of type cReferenceGraphItem
      *
      * Example:
      *
      * @return array a new array with objects of type cReferenceGraphItem
      *
      */


  public function GetReferencesArray( ) {

	// liefert Feld mit Referenzen vom Typ cKEY_COLUMN_USAGE_Entry

        $result = array();

	for ( $i = 0; $i < count( $this->m_a_references ); $i++ ) {

	    $result[] = $this->m_a_references[$i];

	}

        return $result;

  }

    /**
      *
      * The method ReferenceCount returns the number of references
      *
      * Example:
      *
      * @return int the number of references
      *
      */


    public function ReferenceCount( ) {

    return count( $this->m_a_references );

  }	// function ReferenceCount( )

    /**
      *
      * The method AddReference adds a new reference to the managed array of reference pointers
      * If this reference is still known it will not be added twice
      *
      * Example:
      *
      * @param cKEY_COLUMN_USAGE_Entry the reference to add
      *
      */

  public function AddReference( & $obj ) {

      // fals noch keine Referenz zur Tabelle in obj besteht, dann wird das Feld m_a_references[] befüllt

      assert( is_a( $obj, 'rstoetter\libsqlphp\cKEY_COLUMN_USAGE_Entry') );

      if ( ! $this->IsReferencedBy( $obj ) ) {

	  $this->m_a_references[] =  & $obj ;

      } else {

	// echo "\nEs besteht schon eine Referenz auf $obj->m_TABLE_NAME";

      }

  }	// function AddReference( )


    /**
      *
      * The method IsReferencedBy( ) returns true, if the objects' table name is still member of the managed objects
      *
      * Example:
      *
      * @param cKEY_COLUMN_USAGE_Entry $obj is the object to examine
      * @return bool true, if the object is still member of the managed objects
      *
      */


  public function IsReferencedBy( $obj ) {

      // liefert true, wenn eine Referenz zur Tabelle in obj besteht im Feld m_a_references[]


      assert( is_a( $obj, 'rstoetter\libsqlphp\cKEY_COLUMN_USAGE_Entry') );

      for ( $i = 0; $i < count( $this->m_a_references ); $i++ ) {

	  if ( $obj->m_TABLE_NAME == $this->m_a_references[$i]->m_TABLE_NAME ) return true;

      }
      // echo "\nnoch keine Referenz eingetragen";
      return false;


  }	// function IsReferencedBy( )

    /**
      *
      * The method Dump( ) dumps the object
      *
      * Example:
      *
      */


  public function Dump( ) {



      echo "\nDump für cReferenceGraphItem";



	echo ( "\n" . ' ( ' );

	    for ($j = 0; $j <count($this->m_a_references); $j++) {

		echo " " . $this->m_a_references[$j]->m_TABLE_NAME;

	    }

	echo ")\n";

  }	// function Dump( )


    /**
      *
      * The method ReferencesWith( ) returns true, if the table name $table_name is still member of the managed objects
      *
      * Example:
      *
      * @param string $table_name the name of the table
      * @return bool true, if the table name $table_name is still member of the managed objects
      *
      */


  public function ReferencesWith( $table_name ) {

	for ($j = 0; $j <count($this->m_a_references); $j++) {

	    if( $this->m_a_references[$j]->m_TABLE_NAME == $table_name )  return true;

	}

      return false;

  }

}	// class cReferenceGraphItem


/**
  *
  * The class cReferenceGraph creates a reference graph for sql constraints. It displays which tables refer to which tables in the database. The namespace is rstoetter\libsqlphp.
  *
  * Dump für cReferenceGraph
  *  0  t1 (  t2 t3 t4 t5 t6 t7)
  *  1  t2 (  t3 t4 t5 t6 t7)
  *  2  t3 (  t4 t5)
  *
  * i.e: the table t1 is referenced by the tables t2, t3, t4, t5, t6, t7
  *
  * Dump für cReferenceGraph
  *   0  MANDANT (  BUCHUNGSKREIS fk_address t11 TEST_FK)
  *   1  BUCHUNGSKREIS (  fk_address t11 TEST_FK)
  *   2  fk_city (  fk_address)
  *   3  countries (  fk_address fk_city)
  *   4   (  geodb_type_names)
  *   5  t1 (  t2 t3 t4 t5 t6 t7)
  *   6  t2 (  t3 t4 t5 t6 t7)
  *   7  t3 (  t4 t5)
  *   8  t11 (  TEST_FK)
  *   9  _USER (  _USER2BUCHUNGSKREIS _USER2MANDANT _USER2USER_GROUP)
  *  10  _USER_GROUP (  _USER_GROUP_PRIVILEGE_FIELDS _USER_GROUP_PRIVILEGE_TABLES)
  *  11  _PRIVILEGE_FIELDS (  _USER_GROUP_PRIVILEGE_FIELDS)
  *  12  _PRIVILEGE_TABLES (  _USER_GROUP_PRIVILEGE_TABLES)
  *
  * @author Rainer Stötter
  * @copyright 2010-2017 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */


class cReferenceGraph {


    /**
      *
      *
      * @var array a list of objects of type cReferenceGraphItem - the list of table objects
      *
      *
      */

  protected $m_a_references = NULL;	// Feld aus Elementen vom Typ cReferenceGraphItem
  // protected $m_itemcount = 0;

  
    /**
      *
      * The method GetReferenceTableObjects returns all tables in $a_obj_references, which refer to the table $table_name
      * The array $a_obj_references consists of elements of type cTableReference
      *
      * Example:
      *      
      * @param array $a_obj_table_references is an array of cTableReference objects with all tables, which refer to the table $table_name      . It will be filled by the method
      * @param string $table_name the name of the table to examine
      * @param bool $include_self_referencing_tables is false by default - if true, then self-referencing tables are included 
      *
      */
      
    public function GetReferenceTableObjects( array & $a_obj_table_references ,string $table_name, bool $include_self_referencing_tables = false ) {
    
        $level = 0;
        $fertig = false;
        
        $first_index = 0;
        
        $a_obj_table_references = array( );         
        
        // first fill with primary table references
        
        $a_referencing_tables = array( );
        $this->GetReferencingTables( $a_referencing_tables, $table_name );                 
        
        for ( $i = 0; $i < count( $a_referencing_tables ); $i++ ) {
            if ( ! $include_self_referencing_tables && ( $table_name == $a_referencing_tables[ $i ] ) ) {
            } else {
                $a_obj_table_references[] = new cTableReference( $level, $table_name, $a_referencing_tables[ $i ] );
            }
        }        
        
        // next fills with secondary table references
        
        // echo "\n GetReferenceTableObjects( ) starting with " . $table_name;
        
        $level = 1;
        
        while( ! $fertig ) {
        
            $added = 0;
        
            // echo "\n count = " . count( $a_obj_table_references ) . " first_index = $first_index added = $added" ;        
        
            for ( $j = $first_index; $j < count( $a_obj_table_references ); $j++ ) {
            
                $table_name_secondary = $a_obj_table_references[ $j ]->m_table_name;
            
                $a_referencing_tables = array( );
                $this->GetReferencingTables( $a_referencing_tables, $table_name_secondary ); 
                
                foreach ( $a_referencing_tables as $reference ) {
                    if ( ! $include_self_referencing_tables && ( $table_name_secondary == $reference ) ) {
                        // 
                    } else {                
                        if ( ! $this->ReferenceRegistered( $reference, $a_obj_table_references ) ) {
                            $added++;
                            $a_obj_table_references[] = new cTableReference( $level, $table_name_secondary, $reference, $table_name );
                        }
                    }
                }
                
            }
            
            $fertig = ( $added == 0 );
            
            $first_index = count( $a_obj_table_references ) - $added;
            
            $level++;
            
        }            
        
            
    
    }   // function GetAllReferencingTableObjects( )
    
    protected function ReferenceRegistered( string $entry, array $a_obj_table_references ) : bool {
    
        // eliminate double entries
    
        foreach( $a_obj_table_references as $reference ){
        
            if ( $reference->m_table_name == $entry ) {
                    
                return true;
            }
        
        }
        
        return false;
    
    }   // function ReferenceRegistered( )    
  

    /**
      *
      * The method GetReferencingTables returns all table names in $a_referencing_tables, which refer to the table $table_name
      *
      * Example:
      *
      * @param array $a_referencing_tables array an array with all table names of type string, which refer to the table $table_name. It will be filled by the method
      * @param string $table_name the name of the table to examine
      *
      */
      

  public function GetReferencingTables( array & $a_referencing_tables, string $table_name ) {
  

  // TODO array via param, nicht return

      // liefert Feld aus Zeichenketten mit den Tabellennamen, die auf $table_name verweisen

      $a_referencing_tables = array( );
      
      $ret = array( );

      for ( $i = 0; $i < count( $this->m_a_references ); $i++ ) {

        if ( $this->m_a_references[ $i ]->m_table_name == $table_name ) {

            $obj = $this->m_a_references[ $i ];
            for ( $j = 0; $j < count( $obj->m_a_references ); $j++ ) {

                $a_referencing_tables[] = $obj->m_a_references[ $j ]->m_TABLE_NAME;

            }

        }

      }      
      



  }	// function GetReferencingTables( )
  
  


  public function Dump( ) {

    /**
      *
      * The method Dump( ) displays the reference graph in textual form
      *
      * Example:
      *
      */


      echo "\nDump für cReferenceGraph";

      for ( $i = 0; $i < count( $this->m_a_references ); $i++ ) {

	echo ( "\n $i  " . $this->m_a_references[$i]->m_table_name . ' ( ' );

	    for ($j = 0; $j <count($this->m_a_references[$i]->m_a_references); $j++) {

		echo " " . $this->m_a_references[$i]->m_a_references[$j]->m_TABLE_NAME;

	    }

	echo ")\n";


      }


  }	// function Dump( )


    /**
      *
      * The method GetDependentTablesAsString returns all table names, which refer to the table $table_name as string
      * Dependant tables are tables, which refer to the table $table_name)
      *
      * Example:
      *
      * @param string $table_name the name of the table to examine
      * @return string the dependant tables as string
      *
      */


  public function GetDependentTablesAsString( $table_name ) {

      $ret = '';
      $was_here = false;

      for ( $i = 0; $i < count( $this->m_a_references ); $i++ ) {

	if ( $this->m_a_references[ $i ]->m_table_name == $table_name ) {

	    for ( $j = 0; $j < count( $this->m_a_references[ $i ]->m_a_references ); $j++) {

		if ( $was_here ) $ret .= ' ';
		$was_here = true;
		$ret .= $this->m_a_references[$i]->m_a_references[$j]->m_TABLE_NAME;

	    }

	}


      }

      return $ret;

  }	// function GetDependentTablesAsString( )


    /**
      *
      * The method HasDependentTables( ) returns true, if the table with the name $table_name has dependant tables ( tables which refer to the table $table_name)
      *
      * Example:
      *
      * @param string $table_name the name of the table to examine
      * @return string the dependant tables as string
      *
      */


  public function HasDependentTables( $table_name ) {

      return strlen( $this->GetDependentTablesAsString( $table_name ) ) > 0;

  }	// function HasDependentTables( )


    /**
      *
      * The method GetSourceTableIndex( ) returns -1 or the index of the reference with the table name $table_name
      *
      * Example:
      *
      * @param string $table_name the name of the table to examine
      * @return int -1 or the index of the reference with the table name $table_name
      *
      */


  public function GetSourceTableIndex( $table_name ) {

    // Quelltabelle

      for ( $i = 0; $i < count( $this->m_a_references ); $i++ ) {

	if ( $this->m_a_references[ $i ]->m_table_name == $table_name ) {

	    return $i;

	}

      }

      //echo "\n $table_name nicht gefunden";
      return -1;

  }	// function GetSourceTableIndex( )


    /**
      *
      * The method AddReference( ) adds a reference of object $obj to the managed references
      * If there is such a refernce still in the container, then the new reference will not be added
      *
      * Example:
      *
      * @param cKEY_COLUMN_USAGE_Entry $obj the object to be added to the references
      * @return int -1 or the index of the reference with the table name $table_name
      *
      */



  protected function AddReference( $obj) {

      assert( is_a( $obj, 'rstoetter\libsqlphp\cKEY_COLUMN_USAGE_Entry') );
      assert( $obj != NULL );

      if ($obj->m_CONSTRAINT_NAME != 'PRIMARY') {
	    // echo "\nkein PRIMARY";
	    $index = $this->GetSourceTableIndex( $obj->m_REFERENCED_TABLE_NAME );
	    if ( $index != -1 ) {

		if ( ! $this->m_a_references[$index]->IsReferencedBy( $obj )  ) {

		    $this->m_a_references[$index]->AddReference( $obj );


		} else {
		  // $this->m_a_references[$index]->Dump( );
		  // echo "\nReferenz schon bekannt";
		}

	  } else {
	      // echo "\nNeuer Eintrag bei Referenzgraph für $obj->m_REFERENCED_TABLE_NAME";
	      $newitem = new cReferenceGraphItem( $obj, $obj->m_REFERENCED_TABLE_NAME  );
	      $this->m_a_references[] = $newitem;

	  }



      } else {

	   // echo "\nPRIMARY gefunden";

      }


  }	// function AddReference( )

    /**
      *
      * The method AddSourceTable( ) adds an object $obj of type cKEY_COLUMN_USAGE_Entry to the list of managed table object entries
      *
      * Example:
      *
      * @param cKEY_COLUMN_USAGE_Entry $obj the object to be added to the list of managed table object entries
      *
      */


  protected function AddSourceTable( $obj ) {

      // echo "\nAddSourceTable( $obj->m_TABLE_NAME )";
      $objNew = new cReferenceGraphItem( $obj, $obj->m_TABLE_NAME );
      $this->m_a_references[] = $objNew;



  }	// function AddSourceTable()


    /**
      *
      * The constructor for objects of type cReferenceGraph
      *
      * Example:
      *
      * @param cKEY_COLUMN_USAGE an object of type $objKEY_COLUMN_USAGE from which the reference grapgh should be builded
      *
      */



  function __construct( $objKEY_COLUMN_USAGE ) {

    $table_name = '%%%%%%%';
    $fieldname = '%%%%%%%';
    $constraint ='"%%%%%%%';

    assert( is_a( $objKEY_COLUMN_USAGE, 'rstoetter\libsqlphp\cKEY_COLUMN_USAGE') );

    $this->m_a_references = Array( );

    for ( $i = 0; $i < $objKEY_COLUMN_USAGE->Count( ); $i++ ) {

	$obj = $objKEY_COLUMN_USAGE->GetItem( $i );
	// $obj->Dump();

	$ind = $this->GetSourceTableIndex( $obj->m_TABLE_NAME );

	if ( ($ind == -1) && ( $obj->m_CONSTRAINT_NAME != 'PRIMARY' ) ) {

	    $this->AddReference( $obj);

	}

//	echo "\nTablename=$obj->m_TABLE_NAME Column=$obj->m_COLUMN_NAME Constraint=$obj->m_CONSTRAINT_NAME ";
//	if ( ( $table_name !== $obj->m_TABLE_NAME )) echo "\nName der Tabelle != $table_name";
//	if ( ( $fieldname !== $obj->m_COLUMN_NAME )) echo "\nName des Feldes != $fieldname";
//	if ( ( $constraint !== $obj->m_CONSTRAINT_NAME )) echo "\nName des Constraints != $constraint";



	if ( ( $table_name !== $obj->m_TABLE_NAME ) || ( $constraint !== $obj->m_CONSTRAINT_NAME ) ) {
	    // falls nicht schon bearbeitet


	  if ($obj->m_CONSTRAINT_NAME != 'PRIMARY') {

	      $this->AddReference( $obj );

	      // $this->m_a_references[] = &$obj;
	      // $this->m_itemcount++;

	      // if ( $this->GetTable() )



	  }



	} else {


//	    echo "\nschon bearbeitet:";
//	     echo "\nName der Tabelle:  $obj->m_TABLE_NAME";
//	     echo "\nName des Feldes: $obj->m_COLUMN_NAME";
//	     echo "\nName des Constraints: $obj->m_CONSTRAINT_NAME";

	    // echo "\nschon bearbeitet";

	}


	// if ( $objKEY_COLUMN_USAGE->GetItem( $i )->m_CONSTRAINT_NAME == 't2_ibfk_1') die("\nEnde: t2_ibfk_1 entdeckt\n");

    }



  }  // function __construct( )

    /**
      *
      * The destructor for objects of type cReferenceGraph
      *
      * Example:
      *
      */



  function __destruct( ) {

  }  // function __destruct( )



    /**
      *
      * The method TableRefersToAnyTable( ) returns true if the table $table_name is referenced by any minor table
      *
      * Example:
      *
      * @param string $table_name is the name of the table to search
      * @return bool true if the table $table_name is referenced by any minor table
      *
      */



  public function TableRefersToAnyTable( $table_name ) {

      // wird die Tabelle $table_name von irgendwelchen untergeordneten Tabellen referenziert?

      for ( $i = 0; $i < count( $this->m_a_references ); $i++ ) {

	    if ( $this->m_a_references[ $i ]->ReferencesWith( $table_name ) ) {

		return true;

	    }

      }

      return false;

  }	// function TableRefersToAnyTable( )

    /**
      *
      * The method TableRefersToAnyTable( ) returns true if the table $table_name is referenced by any major table
      *
      * Example:
      *
      * @param string $table_name is the name of the table to search
      * @return bool true if the table $table_name is referenced by any major table
      *
      */



  public function IsReferencedByAnyTable( $table_name ) {

      // wird die Tabelle $table_name von irgendwelchen übergeordneten Tabellen referenziert?

      return ( $this->GetSourceTableIndex( $table_name ) == -1 );



  }	// function IsReferencedByAnyTable( )

    /**
      *
      * The method TabelleFreistehend( ) returns true if the table $table_name is not referenced by any minor table and not refererenced by any major table
      *
      * Example:
      *
      * @param string $table_name is the name of the table to search
      *
      */


  public function TabelleFreistehend( $table_name ) {


      return ( (!$this->TableRefersToAnyTable( $table_name ) ) && ( $this->GetSourceTableIndex( $table_name ) == -1 ) );



  }	// function TabelleFreistehend( )

}	// class cReferenceGraph


?>