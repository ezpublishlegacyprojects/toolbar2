<?php
/**
 * File toolbarlist.php
 *
 * @package toolbar2
 * @version //autogentag//
 * @copyright Copyright (C) 2007 xrow. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.txt GPL License
 */
//
// Definition of Toolbarlist class
//
// Created on: <05-Mar-2004 13:05:16 wy>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ publish
// SOFTWARE RELEASE: 3.8.x
// COPYRIGHT NOTICE: Copyright (C) 1999-2006 eZ systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

/*! \file toolbarlist.php
*/

include_once( "kernel/common/template.php" );
include_once( 'lib/ezutils/classes/ezhttptool.php' );

$http =& eZHTTPTool::instance();

$currentSiteAccess = false;
if ( $http->hasSessionVariable( 'eZTemplateAdminCurrentSiteAccess' ) )
    $currentSiteAccess = $http->sessionVariable( 'eZTemplateAdminCurrentSiteAccess' );

$module =& $Params["Module"];
if ( $Params['SiteAccess'] )
    $currentSiteAccess = $Params['SiteAccess'];

$ini =& eZINI::instance();
$siteAccessList = $ini->variable( 'SiteAccessSettings', 'AvailableSiteAccessList' );

if ( $http->hasPostVariable( 'CurrentSiteAccess' ) )
    $currentSiteAccess = $http->postVariable( 'CurrentSiteAccess' );

if ( !in_array( $currentSiteAccess, $siteAccessList ) )
    $currentSiteAccess = $siteAccessList[0];

if ( $http->hasPostVariable( 'SelectCurrentSiteAccessButton' ) )
{
    $http->setSessionVariable( 'eZTemplateAdminCurrentSiteAccess', $currentSiteAccess );
}

$toolbarIni =& eZINI::instance( "toolbar2.ini", null, null, null, true );
$toolbarIni->prependOverrideDir( "siteaccess/$currentSiteAccess", false, 'siteaccess' );
$toolbarIni->loadCache();

if ( $toolbarIni->hasVariable( "Toolbar", "AvailableToolBarArray" ) )
{
    $toolbarArray =  $toolbarIni->variable( "Toolbar", "AvailableToolBarArray" );
}
$tpl =& templateInit();

$tpl->setVariable( 'toolbar_list', $toolbarArray );
$tpl->setVariable( 'siteaccess_list', $siteAccessList );
$tpl->setVariable( 'current_siteaccess', $currentSiteAccess );

$Result = array();
$Result['content'] =& $tpl->fetch( "design:toolbar2/toolbarlist.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'design/standard/toolbar', 'Toolbar2 management' ) ) );


?>
