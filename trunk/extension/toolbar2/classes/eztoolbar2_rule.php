<?php
/**
 * File containing the eZToolbar2Rule class.
 *
 * @package toolbar2
 * @version //autogentag//
 * @copyright Copyright (C) 2007 xrow. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.txt GPL License
 */
include_once( 'kernel/classes/ezpersistentobject.php' );
include_once( 'lib/ezutils/classes/ezini.php' );
include_once( "lib/ezdb/classes/ezdb.php" );
define( 'EZTOOLBAR2_TYPE_NODE', 0 );
define( 'EZTOOLBAR2_TYPE_TREE', 1 );
define( 'EZTOOLBAR2_INCLUDE', 1 );
define( 'EZTOOLBAR2_EXCLUDE', 0 );

class eZToolbar2Rule extends eZPersistentObject
{
    /*!
     Constructor
    */
    function eZToolbar2Rule( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'id',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "priority" => array( 'name' => "priority",
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         "type" => array( 'name' => "type",
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         "node_id" => array( 'name' => "node_id",
                                                            'datatype' => 'integer',
                                                            'default' => '0',
                                                            'required' => false ),
                                         "include" => array( 'name' => "include",
                                                            'datatype' => 'integer',
                                                            'default' => '0',
                                                            'required' => false ),
                                         "toolbar_id" => array( 'name' => "toolbar_id",
                                                            'datatype' => 'integer',
                                                            'default' => '0',
                                                            'required' => false ) ),
                      "function_attributes" => array( ),
                      "keys" => array( "id" ),
                      "increment_key" => "id",
                      "sort" => array( "id" => "asc" ),
                      "class_name" => "eZToolbar2Rule",
                      "name" => "eztoolbar2_rule" );
    }
    function fetch( $ID )
    {
        return eZPersistentObject::fetchObject( eZToolbar2Rule::definition(),
                                                null, array('id' => $ID ), true );
    }
    function fetchAllByID( $id )
    {
        return eZPersistentObject::fetchObjectList( eZToolbar2Rule::definition(), null, array('toolbar_id' => $id ), array( 'priority' => 'asc' ), null, true );
    }
    function fetchByToolbarID( $ID )
    {
        return eZPersistentObject::fetchObjectList( eZToolbar2Rule::definition(),
                                                null, array('toolbar_id' => $ID ), array( 'priority' => 'asc' ), null, true );
    }
    
}
?>