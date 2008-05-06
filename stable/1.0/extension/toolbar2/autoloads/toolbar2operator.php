<?php
/**
 * File containing the toolbar2Operator class.
 *
 * @package toolbar2
 * @version //autogentag//
 * @copyright Copyright (C) 2007 xrow. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.txt GPL License
 */
/*! \file toolbar2operator.php
*/

/*!
  \class toolbar2Operator toolbar2operator.php
  \brief The class displays toolbar2 tools on the toolbar, configured with toolbar2 management.
  \author xrow GbR
*/
class toolbar2Operator
{
    var $Operators;

    function toolbar2Operator( $name = "toolbar2" )
    {
	   $this->Operators = array( $name );
    }

    function &operatorList()
    {
	   return $this->Operators;
    }
     
    function namedParameterPerOperator()    {
	        return true;    
	}

    function namedParameterList()    { 
            return array( 'toolbar2' => array( 'toolbar_name' => array( 'type' => 'string','required' => true ),
                                               'toolbar_view' => array( 'type' => 'string','required' => true ) 
            ), -1 => array() );    
	}
	
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        include_once( "extension/toolbar2/classes/eztoolbar2.php" );
        #include_once( "kernel/user/ezuserfunctioncollection.php" );
        #$currentuser  = eZUserFunctionCollection::fetchCurrentUser();
        $operatorValue = false;
        $actualNodeID  = $GLOBALS['moduleResult']['node_id'];
        $siteaccess    = $GLOBALS["access"]["name"];
        $toolbar_name  = $namedParameters['toolbar_name'];
        $toolbar_view  = $namedParameters['toolbar_view'];
        $tools         = eZToolbar2::fetchAllWithRules($toolbar_name, $siteaccess);
        $includeTool   = array();
        $PathArray     = array();
        
        foreach ( $GLOBALS['moduleResult']['path'] as $item )
        {
            $PathArray[] = $item['node_id'];
        }
        
        foreach ( $tools as $tool )
        {
            $match   = false;
            $include = false;
            foreach ( $tool["rules"] as $rule )
            {
                if ($rule->type == EZTOOLBAR2_TYPE_TREE && in_array( $rule->node_id, $PathArray ) ) 
                {
                	    $match = true;
                	    if ( $rule->include == EZTOOLBAR2_INCLUDE )
                	       $include = true;
                	    break;
                }
                if ($rule->type == EZTOOLBAR2_TYPE_NODE && $rule->node_id == $actualNodeID )
                {
                	    $match = true;
                	    if ( $rule->include == EZTOOLBAR2_INCLUDE )
                	       $include = true;
                	    break;
                }
            }
            if ( $match && $include)
                $includeTool[] = $tool;
                
        }
        
        unset( $tools );
        $templateResult = "";
        $tpl =& templateInit();
        
        foreach ($includeTool as $item)
        {
            $templateResult .= $tpl->fetch( "design:".$toolbar_view."/".$item["tool"]->toolname.".tpl" );
        }
        $operatorValue = $templateResult;
        unset( $templateResult );
        unset( $includeTool );
    }
}
?>