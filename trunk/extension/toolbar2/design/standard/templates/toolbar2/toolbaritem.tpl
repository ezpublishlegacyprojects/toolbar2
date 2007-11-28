<form method="post" action={concat( 'toolbar2/toolbaritem/', $current_siteaccess, '/', $toolbar_position, '/', $current_tool )|ezurl}>

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">Tool {$rules.toolbar.toolname|wash()} in {$current_siteaccess} for Toolbar {$toolbar_position} </h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">
<div class="context-attributes">
<h2>Tool: {$rules.toolbar.toolname|wash()}</h2>
{if $status|eq('stored')}
    <p>Rules have been stored.</p>
{elseif $status|eq('placement')}
    <p>Priorities have been updated.</p>
{elseif $status|eq('removed')}
    <p>Items have been removed.</p>
{/if}
{if $rules}
<table class="list" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
    <td></td>
    <td>
    <br />
    <img src={concat( "toolbar/", $rules.toolbar.toolname|wash, ".jpg" )|ezimage} alt="{$rules.toolbar.toolname|wash}" />
    <br />
    <br />
     <!-- Break before list of parameters -->
     {if $rules.rules|count|gt(0)}
        <table>
        <tr>
        <th><b>Remove</b></th>
        <th><b>Priority</b></th>
        <th><b>Show type</b></th>
        <th><b>Include type</b></th>
        <th><b>Node</b></th>
        <th></th>
        </tr>
        {foreach $rules.rules as $item}
        <tr>
            <td>
                <input type="hidden" name="ToolItemArray[]" value="{$item.id}" />
                <input type="checkbox" name="deleteRuleArray[]" value="{$item.id}" />
                </td>
                <td>
                <input style="text-align: right;" type="text" size="1" name="Tool_Item_Priority_{$item.id}" value="{$item.priority}" />
            </td>
            <td>
                <select name="Tool_Item_Type_{$item.id}">
                    <option {if $item.type|eq('1')}selected{/if} value="1">Subtree</option>
                    <option {if $item.type|eq('0')}selected{/if} value="0">Node</option>
                </select>
                
            </td>
            <td>
                <select name="Tool_Item_Include_{$item.id}" size="1">
                    <option {if $item.include|eq('1')}selected{/if} value="1">include</option>
                    <option {if $item.include|eq('0')}selected{/if} value="0">exclude</option>
                </select>
            </td>
            <td>
                {def $tool_node=fetch( content, node, hash( node_id, $item.node_id ) )}
                <input type="hidden" name="Tool_Item_Node_id_{$item.id}" value ="{$item.node_id}" />
                <b>{$tool_node.name|wash()}</b> ({$item.node_id})
            </td>
            <td>
                <input type="submit" name="BrowseButton[{$item.id}_parameter_subtree]" value="{'Browse'|i18n( 'design/standard/visual/toolbar' )}" />
                <input type="hidden" name="{$item.id}_parameter_subtree" size="20" value="{$Parameter.value|wash}" />
            </td>
            
        </tr>
        {/foreach}
        </table>
        {else}
        <p>No rules attached since now.</p>
        {/if}

</table>
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
<div class="left">
<input type="hidden" name="toolName" value="{$current_tool}">
<input class="button" type="submit" name="NewToolButton" value="Add a new Rule" />
</div>
</div>

<div class="block">

</div>

{* DESIGN: Content END *}</div></div></div>


<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
    <div class="block">
       <input class="button" type="submit" name="StoreButton" value="{'Apply changes'|i18n('design/standard/visual/toolbar')}" title="{'Click this button to store changes if you have modified the parameters above.'|i18n( 'design/standard/visual/toolbar' )}" />
       <input class="button" type="submit" name="BackToToolbarsButton" value="Back to Tool List" title="Back to Tool List" />
    </div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>

</form>