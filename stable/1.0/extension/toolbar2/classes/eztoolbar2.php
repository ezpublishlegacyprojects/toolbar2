<?php
/**
 * File containing the eZToolbar2 class.
 *
 * @package toolbar2
 * @version //autogentag//
 * @copyright Copyright (C) 2007 xrow. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.txt GPL License
 */
include_once( 'kernel/classes/ezpersistentobject.php' );
include_once( 'lib/ezutils/classes/ezini.php' );
include_once( "lib/ezdb/classes/ezdb.php" );
include_once( "extension/toolbar2/classes/eztoolbar2_rule.php" );

class eZToolbar2 extends eZPersistentObject
{
    /*!
     Constructor
    */
    function eZToolbar2( $row = array() )
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
                                         "toolname" => array( 'name' => "toolname",
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         "toolbarname" => array( 'name' => "toolbarname",
                                                            'datatype' => 'string',
                                                            'default' => '0',
                                                            'required' => false ),
                                         "siteaccess" => array( 'name' => "siteaccess",
                                                            'datatype' => 'string',
                                                            'default' => '0',
                                                            'required' => false ) ),
                      "function_attributes" => array( ),
                      "keys" => array( "id" ),
                      "increment_key" => "id",
                      "sort" => array( "id" => "asc" ),
                      "class_name" => "eZToolbar2",
                      "name" => "eztoolbar2" );
    }
    function fetch( $ID )
    {
        return eZPersistentObject::fetchObject( eZToolbar2::definition(),
                                                null, array('id' => $ID ), true );
    }
    
    function fetchAll( $toolbarname, $siteaccess )
    {
        return eZPersistentObject::fetchObjectList( eZToolbar2::definition(), null, array('toolbarname' => $toolbarname, 'siteaccess' => $siteaccess ), array( 'priority' => 'asc' ), null, true );
    }
    
    
    function fetchAllNames( $toolbarname, $siteaccess )
    {
        $array = eZPersistentObject::fetchObjectList( eZToolbar2::definition(), null, array('toolbarname' => $toolbarname, 'siteaccess' => $siteaccess ), array( 'priority' => 'asc' ), null, true );
        $return = array();
        foreach ($array as $item )
        {
            $return[] = $item->toolname;
        }
        return $return;
    }
    
    function fetchAllWithRules($toolbar_name, $siteaccess)
    {
    	$tools = eZToolbar2::fetchAll($toolbar_name, $siteaccess);
        $return = array();
        foreach ( $tools as $tool )
        {
            $return[$tool->toolname] = array("tool" => $tool, "rules" => eZToolbar2Rule::fetchByToolbarID( $tool->id ) );
        }
        return $return;
    }
}
?>