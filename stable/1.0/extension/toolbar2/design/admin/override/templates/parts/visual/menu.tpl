{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h4>{'Design'|i18n( 'design/admin/parts/visual/menu' )}</h4>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

{section show=eq( $ui_context, 'edit' )}

<ul>
    <li><div><span class="disabled">{'Look and feel'|i18n( 'design/admin/parts/visual/menu' )}</span></div></li>
    <li><div><span class="disabled">{'Menu management'|i18n( 'design/admin/parts/visual/menu' )}</span></div></li>
    <li><div><span class="disabled">{'Toolbar management'|i18n( 'design/admin/parts/visual/menu' )}</span></div></li>
    <li><div><span class="disabled">{'Templates'|i18n( 'design/admin/parts/visual/menu' )}</span></div></li>
</ul>

{section-else}

<ul>
    <li><div><a href={'/content/edit/54/'|ezurl}>{'Look and feel'|i18n( 'design/admin/parts/visual/menu' )}</a></div></li>
    <li><div><a href={'/visual/menuconfig/'|ezurl}>{'Menu management'|i18n( 'design/admin/parts/visual/menu' )}</a></div></li>
    <li><div><a href={'/toolbar2/toolbarlist/'|ezurl}>{'Toolbar2 management'|i18n( 'design/admin/parts/visual/menu' )}</a></div></li>
    <li><div><a href={'/visual/toolbarlist/'|ezurl}>{'Toolbar management'|i18n( 'design/admin/parts/visual/menu' )}</a></div></li>
    <li><div><a href={'/visual/templatelist/'|ezurl}>{'Templates'|i18n( 'design/admin/parts/visual/menu' )}</a></div></li>
</ul>

{/section}

{* DESIGN: Content END *}</div></div></div></div></div></div>

