<?php
/**
 * File toolbar.php
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


include_once( "kernel/common/template.php" );
include_once( 'lib/ezutils/classes/ezhttptool.php' );
include_once( 'kernel/classes/ezcontentbrowse.php' );
include_once( "kernel/classes/ezsiteaccess.php" );
include_once( "lib/ezdb/classes/ezdb.php" );
include_once( "extension/toolbar2/classes/eztoolbar2.php" );
include_once( "extension/toolbar2/classes/eztoolbar2_rule.php" );

$db =& ezDB::instance();
$siteini =& eZINI::instance();
if ( !in_array( $currentSiteAccess, $siteini->variable( 'SiteAccessSettings', 'AvailableSiteAccessList' ) ) )
    return $module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );

$currentAction = $module->currentAction();


if ( $currentAction == 'BackToToolbars' )
{
    return $Module->redirectToView( 'toolbarlist', array() );
}
elseif ( $currentAction == 'NewTool' )
{
    if ( $currentAction == 'NewTool' &&
         $http->hasPostVariable( 'toolName' ) )
    {
        $toolname = $http->postVariable( 'toolName' );
        $toolname = $db->escapeString( $toolname );
        $row = array( 'id' => null, 'toolname' => $toolname, 'siteaccess' => $currentSiteAccess , 'toolbarname' => $toolbarPosition, 'priority' => 0 );
        $toolbar = new eZToolbar2( $row );
        $toolbar->store();
    }
}
elseif ( $currentAction == 'Remove' )
{
    if ( $currentAction == 'Remove' &&
         $http->hasPostVariable( 'deleteToolArray' ) )
         
    {
        $deleteToolArray = $http->postVariable( 'deleteToolArray' );
        foreach ($deleteToolArray as $deleteTool )
        {
            $tool = eZToolbar2::fetch( $deleteTool );
            $tool->remove();
        }
    }
}
elseif ( $currentAction == 'UpdatePlacement' )
{
    if ( $currentAction == 'UpdatePlacement' &&
         $http->hasPostVariable( 'ToolArray' ) )
    $ToolArray = array();
    $ToolArray = $http->postVariable( 'ToolArray' );
    $toolsCount = count ( $ToolArray );
    foreach ( $ToolArray as $item )
    {
        $newtoolsarray[$item] = $http->postVariable( 'placement_' . $item );
    }

    asort($newtoolsarray);
    $i=1;
    foreach ( $newtoolsarray as $key => $item )
    {
        $updateitem = eZToolbar2::fetch ( $key );
        $updateitem->setAttribute ('priority', $i );
        $updateitem->store();
        $i++;
    }
}
elseif ( $currentAction == 'Configure' )
{
    if ( $currentAction == 'Configure' && $http->hasPostVariable( 'ConfigureButton' ) )
    {
        $configureArray = $http->postVariable( 'ConfigureButton' );
        
        $toolID = key($configureArray);
        $Module->redirectTo( '/toolbar2/toolbaritem/'.$currentSiteAccess.'/'.$toolbarPosition.'/'.$toolID );
    }
    $checkCurrAction = true;
}
$toolbarIni =& eZINI::instance( "toolbar2.ini", 'settings', null, false, true, false );
$toolbarIni->prependOverrideDir( "siteaccess/$currentSiteAccess", false, 'siteaccess' );
$toolbarIni->parse();

$toolbars = existendtools($toolbarPosition, $currentSiteAccess);
$availabletools = eZToolbar2::fetchAllNames( $toolbarPosition, $currentSiteAccess );

if ( $toolbarIni->hasVariable( "Tool", "AvailableToolArray" ) )
{
    $availableToolArray = $toolbarIni->variable( "Tool", "AvailableToolArray" );
}
$mergedTools=array();
foreach ( $availableToolArray as $item )
{
    if ( !in_array( $item, $availabletools ) )
        $mergedTools[] = $item;
}
$availableToolArray = $mergedTools;
asort($availableToolArray);

$tpl =& templateInit();
$tpl->setVariable( 'toolbar_position', $toolbarPosition );
$tpl->setVariable( 'tool_list', $availableToolArray );
$tpl->setVariable( 'current_siteaccess', $currentSiteAccess );
$tpl->setVariable( 'toolbars', $toolbars );

$Result = array();
$Result['content'] =& $tpl->fetch( "design:toolbar2/toolbar.tpl" );
$Result['path'] = array( array( 'url' => 'toolbar2/toolbarlist',
                                'text' => ezi18n( 'kernel/design', 'Toolbar2 list' ) ) );

function existendtools($toolbarPosition, $currentSiteAccess)
{
	$toolbars = eZToolbar2::fetchAll( $toolbarPosition, $currentSiteAccess );
	$return = array();
	foreach ($toolbars as $toolbar )
	{
	    $items = eZToolbar2Rule::fetchAllByID( $toolbar->id );
	    $return[] = array('toolbar' => $toolbar, 'rules' => $items);
	}
	return $return;
	
}                                
?>