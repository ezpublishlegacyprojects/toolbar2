<?php
/**
 * File toolbaritem.php
 *
 * @package toolbar2
 * @version //autogentag//
 * @copyright Copyright (C) 2007 xrow. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.txt GPL License
 */
$http =& eZHTTPTool::instance();
$module =& $Params["Module"];

if ( $Params['SiteAccess'] )
    $currentSiteAccess = $Params['SiteAccess'];
if ( $Params['Position'] )
    $toolbarPosition =& $Params['Position'];
if ( $Params['Tool'] )
    $currentTool =& $Params['Tool'];
include_once( "kernel/common/template.php" );
include_once( 'lib/ezutils/classes/ezhttptool.php' );
include_once( 'kernel/classes/ezcontentbrowse.php' );
include_once( "kernel/classes/ezsiteaccess.php" );
include_once( "extension/toolbar2/classes/eztoolbar2.php" );
include_once( "extension/toolbar2/classes/eztoolbar2_rule.php" );
include_once( "lib/ezdb/classes/ezdb.php" );
$db =& ezDB::instance();
$tpl =& templateInit();
$siteini =& eZINI::instance();
if ( !in_array( $currentSiteAccess, $siteini->variable( 'SiteAccessSettings', 'AvailableSiteAccessList' ) ) )
    return $module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );

$currentAction = $module->currentAction();

if ( $currentAction == 'BackToToolbars' )
{
    return $Module->redirectTo( '/toolbar2/toolbar/'.$currentSiteAccess.'/'.$toolbarPosition );
}
elseif ( $currentAction == 'SelectToolbarNodePath' )
{
    $selectedNodeIDArray = eZContentBrowse::result( 'SelectToolbarNode' );

    $nodeID = $selectedNodeIDArray[0];
    if  ( !$http->hasPostVariable( 'BrowseCancelButton' ) )
    {
        if ( !is_numeric( $nodeID ) )
           $nodeID = 2;
        if ( !is_numeric( $toolIndex ) )
        {
            $toolIndex = $http->variable( 'tool_index' );
            $parameterName = $http->variable( 'parameter_name' );
            $updateitem = eZToolbar2Rule::fetch ( $toolIndex );
            $updateitem->setAttribute( 'node_id', $nodeID );
            $updateitem->store();
        }
    
    }
}


elseif ( $currentAction == 'NewTool' )
{
    
    if ( $currentAction == 'NewTool' &&
         $http->hasPostVariable( 'toolName' ) &&
         is_numeric( $http->PostVariable( 'toolName' ) ) )
    {
        
        $row = array( 'id' => null, 'priority' => '0', 'type' => EZTOOLBAR2_TYPE_TREE , 'node_id' => 2, 'include' => EZTOOLBAR2_INCLUDE, 'toolbar_id' => $currentTool );
        $newrule = new eZToolbar2Rule( $row );
        $newrule->store();
    }
    
}

elseif ( $currentAction == 'Remove' )
{
    if ( $currentAction == 'Remove' &&
         $http->hasPostVariable( 'deleteRuleArray' ) )
         
    {
        $deleteToolArray = $http->postVariable( 'deleteRuleArray' );
        foreach ($deleteToolArray as $deleteTool)
        {
            $deleterule = eZToolbar2Rule::fetch( $deleteTool );
            $deleterule->remove();
        }
        
    }
}

elseif ( $currentAction == 'UpdatePlacement' )
{
    
    if ( $currentAction == 'UpdatePlacement' && $http->hasPostVariable( 'ToolItemArray' ) )
    {
        $ToolItemArray = $http->postVariable( 'ToolItemArray' );
        foreach ( $ToolItemArray as $item )
        {
            $updated[$item] = $http->postVariable( 'Tool_Item_Priority_' . $item );
        }
        asort($updated);
        $updatedcount = count ( $updated );
        $i=1;
        foreach ( $updated as $key => $item )
        {
            $updateitem = eZToolbar2Rule::fetch ( $key );
            $updateitem->setAttribute ('priority', $i );
            $updateitem->store();
            $i++;
        }
        $tpl->setVariable( 'status', "placement" );
        
    }
}

elseif ( $currentAction == 'Browse' )
{
    if ( $currentAction == 'Browse' )
    {
        $browseArray = $http->postVariable( 'BrowseButton' );
        if ( preg_match( "/_subtree$/", key( $browseArray ) ) )
        {
            if ( preg_match( "/(.+)_parameter_(.+)/", key( $browseArray ), $res ) )
            {
                eZContentBrowse::browse( array( 'action_name' => 'SelectToolbarNodePath',
                                                'description_template' => false,
                                                'persistent_data' => array( 'tool_index' => $res[1], 'parameter_name' => $res[2] ),
                                                'from_page' => "/toolbar2/toolbaritem/$currentSiteAccess/$toolbarPosition/$currentTool" ),
                                         $module );
                return;
            }
        }
    }
}
elseif ( $currentAction == 'Store' )
{
    if ( $currentAction == 'Store' && $http->hasPostVariable( 'ToolItemArray' ) )
    {
        $ToolItemArray = $http->postVariable( 'ToolItemArray' );
        foreach ( $ToolItemArray as $item )
        {
            $storeitem = eZToolbar2Rule::fetch( $item );
            $storeitem->setAttribute( 'priority', $http->postVariable( 'Tool_Item_Priority_' . $item ) );
            $storeitem->setAttribute( 'node_id', $http->postVariable( 'Tool_Item_Node_id_' . $item ) );
            $storeitem->setAttribute( 'include', $http->postVariable( 'Tool_Item_Include_' . $item ) );
            $storeitem->setAttribute( 'type', $http->postVariable( 'Tool_Item_Type_' . $item ) );
            $storeitem->store();
        }
        $tpl->setVariable( 'status', "stored" );
    }
}

$toolbar = eZToolbar2::fetch( $currentTool );
$items = eZToolbar2Rule::fetchAllByID( $toolbar->id );
$rules = array('toolbar' => $toolbar, 'rules' => $items);

$tpl->setVariable( 'toolbar_position', $toolbarPosition );
$tpl->setVariable( 'current_tool', $currentTool );
$tpl->setVariable( 'rules', $rules );
$tpl->setVariable( 'current_siteaccess', $currentSiteAccess );

$Result = array();
$Result['content'] =& $tpl->fetch( "design:toolbar2/toolbaritem.tpl" );
$Result['path'] = array( array( 'url' => 'toolbar2/toolbaritem',
                                'text' => ezi18n( 'kernel/design', 'Toolbar2 Rules' ) ) );
?>