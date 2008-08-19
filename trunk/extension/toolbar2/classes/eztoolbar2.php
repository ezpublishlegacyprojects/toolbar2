<?php
/**
 * File containing the eZToolbar2 class.
 *
 * @package toolbar2
 * @version //autogentag//
 * @copyright Copyright (C) 2007 xrow. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.txt GPL License
 */


class eZToolbar2 extends eZPersistentObject
{
    /*!
     Constructor
    */
    function eZToolbar2( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }
    static function definition()
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
    static function fetch( $ID )
    {
        return eZPersistentObject::fetchObject( eZToolbar2::definition(),
                                                null, array('id' => $ID ), true );
    }
    
    static function fetchAll( $toolbarname, $siteaccess )
    {
        return eZPersistentObject::fetchObjectList( eZToolbar2::definition(), null, array('toolbarname' => $toolbarname, 'siteaccess' => $siteaccess ), array( 'priority' => 'asc' ), null, true );
    }
    
    
    static function fetchAllNames( $toolbarname, $siteaccess )
    {
        $array = eZPersistentObject::fetchObjectList( eZToolbar2::definition(), null, array('toolbarname' => $toolbarname, 'siteaccess' => $siteaccess ), array( 'priority' => 'asc' ), null, true );
        $return = array();
        foreach ($array as $item )
        {
            $return[] = $item->toolname;
        }
        return $return;
    }
    
    static function fetchAllWithRules($toolbar_name, $siteaccess)
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