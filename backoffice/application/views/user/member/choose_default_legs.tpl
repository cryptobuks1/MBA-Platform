{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;">
        <span id="label_field_is_required">{lang('field_is_required')}</span>
        <span id="label_enter_valid_field">{lang('enter_valid_field')}</span>
        <span id="label_field_greater_than_zero">{lang('field_greater_than_zero')}</span>
        <span id="label_amount">{lang('amount')|strtolower}</span>
    </div>

   <div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
               
                {lang('change_placement')}
            </div>
            <div class="panel-body">
                <div class="col-md-12">
               
             
               {form_open('','role="form" class="smart-wizard form-horizontal form-inline" id="change_pass_admin" name="change_pass_admin"  method="post" ')}
                    <div class="row">  
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                <div class="row">  
                     <div class="col-sm-4 ">
                        <label class="control-label" for="new_pwd_admin">{lang('default_leg')}<font color="#ff0000">*</font></label>
                        <div class="">
                             <select tabindex="5" name="left_leg" id="left_leg" class="form-control" >   
                          
                                                <option value="L" {if $leg_details[0]['default_leg']==L}selected=""{/if}>{lang('left_leg')}</option>
                                                <option value="R" {if $leg_details[0]['default_leg']==R}selected=""{/if} >{lang('right_leg')}</option>
                                                </select>
                        </div>

                    </div>
                    
                     <div class="col-sm-3">
                        <div class="" style="padding-top: 27px;">
                            <button class="btn btn-primary" type="submit" name="change_position" id="change_position" value="{lang('change_position')}" tabindex="4">{lang('update')}</button>
                        </div>
                    </div>
                </div>
                
                
                
                        {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>
    

{/block}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/purchase_wallet.js"></script>
{/block}