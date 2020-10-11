{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
{if $DEMO_STATUS == 'yes'}
    {if $preset_demo}
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <strong>Info!</strong> {$demo_note}
                </div>
            </div>
        </div>
    {/if}
{/if}

<div class="panel panel-default">
    <div class="panel-body">
        {form_open_multipart('','role="form" class="" name="searchform" id="searchform" action="" method="post"')}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('select_user_name')}</label>
                <input name="user_name" class="form-control autolist_except_admin" id="user_name" type="text" size="30" autocomplete="off">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required">{lang('select_new_sponsor')}</label>
                 <input class="form-control autolist_except_admin" name="new_sponsor" id="new_sponsor" type="text" size="30" autocomplete="off">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <div class="form-group mark_paid">
                    <button class="btn btn-primary" type="submit" id="change_sponsor" value="change_sponsor" name="change_sponsor" {if $DEMO_STATUS=='yes' }{if $preset_demo}disabled="" {/if}{/if}>
                    {lang('change')}
                    </button>
                </div>
            </div>
        </div>
        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"> {form_close()}
    </div>
</div>
{/block}