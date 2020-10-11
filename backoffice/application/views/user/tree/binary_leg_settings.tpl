{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;">
        <span id="error_msg2">{lang('you_must_select_an_amount')}</span>
        <span id="error_msg1">{lang('you_must_enter_count')}</span>    
        <span id="error_msg3">{lang('enter_digits_only')}</span>         
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span>
        <span id="error_msg4">{lang('Digit limit is five')}</span>
    </div>   
    <div class="button_back">
        <a href="{$BASE_URL}user/genology_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('user/binary_leg_settings','role="form"  method="post" name="upload" id="upload" ')} 
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="required" for="count">{lang('binary_leg')}</label>
                    <select class="form-control" id="binary_leg" name="binary_leg">
                        {if $get_leg_settings =='any'}
                            <option value="any" {if $get_leg_type == 'any'} selected="" {/if} >{lang('any')}</option>
                        {/if}
                        {if $get_leg_settings =='any' || $get_leg_settings =='left'}
                            <option value="left" {if $get_leg_type == 'left'} selected="" {/if}>{lang('left')}</option>
                        {/if}
                        {if $get_leg_settings =='any' || $get_leg_settings =='right'}
                            <option value="right" {if $get_leg_type == 'right'} selected="" {/if}>{lang('right')}</option>
                        {/if}
                        {if $get_leg_settings =='any'}
                            <option value="weak_leg" {if $get_leg_type == 'weak_leg'} selected="" {/if}>{lang('weak_leg')}</option>
                        {/if}
                    </select>
                    <span id="errmsg"></span>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button_1">
                    <button type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" title="{lang('submit')}">{lang('submit')}</button>
                </div>
            </div>
            {form_close()}  
        </div>
    </div>
{/block} 