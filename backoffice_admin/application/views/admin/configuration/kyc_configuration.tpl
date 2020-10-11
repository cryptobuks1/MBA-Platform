{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="msg1">{lang('the_%s_field_may_only_contain_alpha-numeric_characters')}</span>
        <span id="msg2">{lang('You must enter category')}</span>
        <span id="lang_kyc">{lang('kyc')}</span>
        <span id="msg3">{lang('Sure_you_want_to_Delete_this_category_There_is_NO_undo')}</span>
    </div>
    <div class="button_back">
        <a href="{$BASE_URL}admin/payout_setting"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('admin/kyc_configuration', 'class="col-md-12" id="kyc_config" name="kyc_config"')}
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class='required'>{lang('category')}</label>
                    <input class="form-control" type="text" name="new_catg" id="new_catg" value="{$catg}" autocomplete="off"/>
                    <span id="errmsg1"></span>
                    <span name ='form_err'>{form_error('new_catg')}</span>
                </div>
            </div>


            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button">
                    {if $catg_id !=''}
                        <input type="hidden" value="{$catg_id}" name='catg_id'>
                        <button type="submit" class="btn btn-primary" name="update_category" id="update_category" type="submit" value="update category">{lang('update_category')}</button>
                    {else}
                        <button type="submit" class="btn btn-primary" name="add_category" id="add_category" type="submit" value="add category">{lang('add_new_category')}</button>
                    {/if}

                </div>
            </div>
             {form_close()}        
        </div>
    </div>
{/block}