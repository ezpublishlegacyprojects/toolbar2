<form method="post" action={concat( 'toolbar2/toolbar/', $current_siteaccess, '/', $toolbar_position )|ezurl}>

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{'Tool2 List for <Toolbar_%toolbar_position>'|i18n( 'design/standard/visual/toolbar',, hash( '%toolbar_position', $toolbar_position ) )|wash}
</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
<div class="context-attributes">

{if $toolbars}
<table class="list" width="100%" cellspacing="0" cellpadding="0" border="0">
{foreach $toolbars as $tool}
<tr>
    <th class="tight">
        <input type="checkbox" name="deleteToolArray[]" value="{$tool.toolbar.id}" />
        <input type="hidden" name="ToolArray[]" value="{$tool.toolbar.id}" />
    </th>
    <th class="wide">
        <input class="button" type="submit" name="ConfigureButton[{$tool.toolbar.id}]" value="Configure" title="Configure" />    
        {$tool.toolbar.toolname|wash}
    </th>
    <th class="tight"><input type="text" name="placement_{$tool.toolbar.id}" size="2" value="{$tool.toolbar.priority}" /></th>
</tr>
<tr>
    <td></td>
    <td>

    <br />
        <img src={concat( "toolbar/", $tool.toolbar.toolname|wash, ".jpg" )|ezimage} alt="{$tool.toolbar.toolname|wash}" />
    <br />
    <br />
    <!-- Break before list of parameters -->
    {if $tool.rules|count|gt(0)}
        <table>
        <tr>
        <th>Priority</th>
        <th>Show type</th>
        <th>Include type</th>
        <th>Node</th>
        </tr>
        {foreach $tool.rules as $rule}
        <tr>
            <td>
                {$rule.priority|wash()}
            </td>
            <td>
                {if $rule.type|eq('1')}Subtree{else}Node{/if}
            </td>
            <td>
                {if $rule.include|eq('1')}include{else}exclude{/if}
                </select>
            </td>
            <td>
                {def $tool_node=fetch( content, node, hash( node_id, $rule.node_id ) )}
                <b>{$tool_node.name|wash()}</b> ({$rule.node_id})
            </td>
        </tr>
        {/foreach}
        </table>
        {else}
        <p>No rules attached.</p>
        {/if}
{/foreach}
</table>
{else}
{'There are currently no tools in this toolbar'|i18n( 'design/standard/visual/toolbar' )}
{/if}

<div class="block">
<div class="left">
<input class="button" type="submit" name="RemoveButton" value="{'Remove selected'|i18n('design/standard/visual/toolbar')}" />
</div>
<div class="right">
<input class="button" type="submit" name="UpdatePlacementButton" value="{'Update priorities'|i18n('design/standard/visual/toolbar')}" />
</div>
</div>

<div class="block">
<select name="toolName">
{section var=Tool loop=$tool_list}
    <option value="{$Tool|wash()}">{$Tool|wash()}</option>
{/section}
</select>
<input class="button" type="submit" name="NewToolButton" value="{'Add Tool'|i18n('design/standard/visual/toolbar')}" />
</div>

{* DESIGN: Content END *}</div></div></div>


<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
    <div class="block">
       <input class="button" type="submit" name="StoreButton" value="{'Apply changes'|i18n('design/standard/visual/toolbar')}" title="{'Click this button to store changes if you have modified the parameters above.'|i18n( 'design/standard/visual/toolbar' )}" />
       <input class="button" type="submit" name="BackToToolbarsButton" value="{'Back to toolbars'|i18n('design/standard/visual/toolbar')}" title="{'Go back to the toolbar list.'|i18n( 'design/standard/visual/toolbar' )}" />
    </div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>

</form>
