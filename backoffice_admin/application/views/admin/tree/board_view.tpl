{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div class="panel panel-default m-t">
    <div class="panel-body">
        <div class="col-md-3">
            <div class="">
                <button class="btn m-b-xs btn-primary zoom-in"><i class="glyphicon glyphicon-zoom-in"></i></button>
                <button class="btn m-b-xs btn-info zoom-out"><i class="glyphicon glyphicon-zoom-out"></i></button>
                <button class="btn m-b-xs btn-primary zoom-reset"><i class="icon-power"></i></button>
            </div>
        </div>
        <a href="{BASE_URL}/admin/view_board_details/{$board_id}" class="pull-right btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</a>
    </div>
</div>

{assign var="table_status" value=(isset($MODULE_STATUS['table_status']) && $MODULE_STATUS['table_status'] == "yes")}

{if $table_status}
    {include file="admin/tree/table_view.tpl"}
{else}
    {include file="admin/tree/tree_view_board.tpl"}
{/if}

{/block}

{block name=style}
    {$smarty.block.parent}
    {assign var="table_status" value=(isset($MODULE_STATUS['table_status']) && $MODULE_STATUS['table_status'] == "yes")}
    {if $table_status}
        <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/tree_table.css" type="text/css" />
    {else}
        <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/tree_board.css" type="text/css" />
    {/if}
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/tree_tooltip.css" type="text/css"/>
{/block}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}theme/libs/jquery/panzoom/jquery.panzoom.min.js"></script>
    {assign var="table_status" value=(isset($MODULE_STATUS['table_status']) && $MODULE_STATUS['table_status'] == "yes")}
    {if $table_status}
        <script src="{$PUBLIC_URL}javascript/tree/table.js"></script>
    {else}
        <script src="{$PUBLIC_URL}javascript/tree/jquery.tree.js"></script>
        <script src="{$PUBLIC_URL}javascript/tree/board.js"></script>
    {/if}
{/block}