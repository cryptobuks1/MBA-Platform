{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<legend><span class="fieldset-legend">[{$user_name}]</span></legend>
<div class="row">
    <div class="col-sm-12">
        <div id="left" class="tabular_tree">
        </div>
    </div>
</div>

<input id="root_user_name" value="{$user_name}" type="hidden">
<input id="tree_url" value="{$BASE_URL}user/tree/select_tree_view/" type="hidden">
{/block}

{block name=style}
    {$smarty.block.parent}
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/tabular.css" type="text/css" />
{/block}
{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}theme/libs/jquery/fancytree/jquery.fancytree-all-deps.min.js"></script>
    <script src="{$PUBLIC_URL}javascript/tree/tabular.js"></script>
{/block}