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
{/if} {/if}

<div class="panel panel-default">
    <div class="panel-body">
        {form_open_multipart('','role="form" name="searchform" id="searchform" action="" method="post"')}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('select_user_name')}</label>
                <input name="user_name" class="form-control autolist_except_admin" id="user_name" type="text" size="30" autocomplete="off">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required">{lang('select_new_placement')}</label>
                 <input class="form-control autolist_except_admin" name="new_placement" id="new_placement" type="text" size="30" autocomplete="off">
            </div>
        </div>
        {if $mlm_plan == 'Binary'}
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required">{lang('select_new_position')}</label>
                <select class="form-control" name="new_position" id="new_position">
                    <option value="">{lang('select_position')}</option>
                    <option value="L">{lang('left')}</option>
                    <option value="R">{lang('right')}</option>
                </select>
            </div>
        </div>
        {/if}
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <div class="form-group mark_paid">
                    <button class="btn btn-primary" type="submit" id="change_placement" value="change_placement" name="change_placement" {if $DEMO_STATUS=='yes' }{if $preset_demo}disabled="" {/if}{/if}>
                    {lang('change')}
                    </button>
                </div>
            </div>
        </div>
        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"> {form_close()}
    </div>
</div>
{/block}