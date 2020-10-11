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
<div class="panel panel-default m-t">
        <div class="panel-body">
            {form_open_multipart('','role="form" class="" name="delete_user" id="delete_user" action="" method="post"')}
                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label class="required" for="user_name">{lang('select_user_name')}</label>
                        <input class="form-control autolist_except_admin" type="text" id="user_name" name="user_name" autocomplete="Off" size="100">
                    </div>
                </div>
                <div class="col-sm-2 padding_both_small">
                    <div class="form-group credit_debit_button">
                        <button class="btn btn-sm btn-primary" type="submit" id="delete_user" value="delete_user" name="delete_user" {if $DEMO_STATUS == 'yes'}{if $preset_demo}disabled=""{/if}{/if}>
                                {lang('delete')}
                        </button>
                    </div>
                </div>
            {form_close()}
        </div>
    </div>
{/block}