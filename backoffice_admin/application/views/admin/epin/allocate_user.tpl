{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="button_back">
        <a href="{BASE_URL}/admin/epin_management"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('','role="form" class="" method="post"  name="allocate_user_form" id="allocate_user_form"')}
            <div class="col-md-12">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i>{lang('errors_check')}
                </div>
            </div>
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label>{lang('epin')}</label>
                    <input type="text" name="count" id="count" value="{$epin}" title="" class="form-control" disabled=""/>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="required">{lang('user_name')}</label>
                    <input type="text" name="user_name" id="user_name" value="" class="form-control user_autolist"  title=""/>
                    <span class="help-block">{if form_error('user_name')}{lang('invalid_user_name')} {/if}</span>
                    
                </div>
            </div>

            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button">
                    <button type="submit" class="btn btn-primary" name="allocate" id="allocate" value="{lang('allocate')}"> {lang('allocate')}</button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
{/block}