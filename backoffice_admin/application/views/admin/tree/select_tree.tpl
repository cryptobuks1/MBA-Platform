{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
<input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />

<div class="panel panel-default">
        <div class="panel-body">
        {form_open('admin/select_tree','role="form" class="" name="search_member" id="search_member"
        method="post"')}
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="required" for="user_name">{lang('user_name')}</label>
                    <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off" size="100">
                </div>
            </div>
            <div class="col-sm-2 padding_both_small">
                <div class="form-group mark_paid">
                    <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit"
                        name="search_member_submit">
                        {lang('search')}
                    </button>
                </div>
            </div>
        {form_close()}
    </div>
</div>
<br>
<br>

<legend><span class="fieldset-legend">[{$user_name}]</span></legend>
<div class="row">
    <div class="col-sm-12">
        <div id="left" class="tabular_tree">
        </div>
    </div>
</div>

<input id="root_user_name" value="{$user_name}" type="hidden">
<input id="tree_url" value="{$BASE_URL}admin/tree/select_tree_view/" type="hidden">
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