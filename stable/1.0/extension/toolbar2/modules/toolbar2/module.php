<?php
/**
 * File module.php
 *
 * @package toolbar2
 * @version //autogentag//
 * @copyright Copyright (C) 2007 xrow. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.txt GPL License
 */
$Module = array( "name" => "Toolbar2",
                 "variable_params" => true,
                 'ui_component_match' => 'view' );
$ViewList = array();
$ViewList["toolbarlist"] = array(
    "script" => "toolbarlist.php",
    "default_navigation_part" => 'ezvisualnavigationpart',
    "params" => array( 'SiteAccess' ) );

$ViewList["toolbar"] = array(
    "script" => "toolbar.php",
    'ui_context' => 'edit',
    "default_navigation_part" => 'ezvisualnavigationpart',
    'post_actions' => array( 'BrowseActionName' ),
    'single_post_actions' => array( 'BackToToolbarsButton' => 'BackToToolbars',
                                    'NewToolButton' => 'NewTool',
                                    'UpdatePlacementButton' => 'UpdatePlacement',
                                    'BrowseButton' => 'Browse',
                                    'RemoveButton' => 'Remove',
                                    'ConfigureButton' => 'Configure',
                                    'StoreButton' => 'Store' ),    
    "params" => array( 'SiteAccess', 'Position' ) );
    
$ViewList["toolbaritem"] = array(
    "script" => "toolbaritem.php",
    'ui_context' => 'edit',
    "default_navigation_part" => 'ezvisualnavigationpart',
    'post_actions' => array( 'BrowseActionName' ),
    'single_post_actions' => array( 'BackToToolbarsButton' => 'BackToToolbars',
                                    'NewToolButton' => 'NewTool',
                                    'UpdatePlacementButton' => 'UpdatePlacement',
                                    'BrowseButton' => 'Browse',
                                    'RemoveButton' => 'Remove',
                                    'StoreButton' => 'Store' ),    
    "params" => array( 'SiteAccess', 'Position', 'Tool' ) );
?>