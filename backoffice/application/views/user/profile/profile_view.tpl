{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;"> 
        <span id="validate_msg30">{lang('You_must_select_a_date')}</span>
        <span id="validate_msg31">{lang('You_must_select_a_month')}</span>
        <span id="validate_msg32">{lang('You_must_select_a_year')}</span>
        <span id="validate_msg33">{lang('You_must_select_gender')}</span>
        <span id="validate_msg34">{lang('You_must_select_country')}</span>
        <span id="validate_msg35">{lang('mail_id_format')}</span>
        <span id="validate_msg37">{lang('digits_only')}</span>
        <span id="validate_msg40">{lang('you_must_enter_email_id')}</span>
        <span id="validate_msg41">{lang('You_must_enter_your_address')}</span>
        <span id="validate_msg67">{lang('enter_city')}</span>
        <span id="validate_msg69">{lang('enter_atleast_3_chars')}</span>
        <span id="validate_msg70">{lang('mobile_number_must_10digits_long')}</span>
        <span id="validate_msg73">{lang('must_enter_first_name')}</span>
        <span id="validate_msg75">{lang('only_alphanumerals')}</span>
        <span id="validate_msg78">{lang('city_field_characters')}</span>
        <span id="validate_msg81">{lang('digits_only')}</span>
        <span id="validate_msg90">{lang('You_should_be_atleast_n_years_old')}</span>
        <span id="validate_msg91">{lang('only_alpha_space')}</span>
        <span id="validate_msg92">{lang('enter_min_digits')}</span>
        <span id="validate_msg93">{lang('enter_max_digits')}</span>
        <span id="validate_msg94">{lang('enter_mobile_no')}</span>
        <span id="validate_msg95">{lang('no_more_than_32_characters')}</span>
    </div>
    {form_open_multipart('','role="form" class="" name= "edit_user_profile"  id="edit_user_profile"')}
    <legend><span class="fieldset-legend">{$u_name}{lang('s_profile')}</span></legend>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="fb-profile"> <a href="" class="wall-img-edit-btn"></a> <img align="left" class="fb-image-lg" src="{$SITE_URL}/uploads/images/banners/{$profile_details["banner_name"]}"/>
                <div class="edit_button"> <img align="left" class="fb-image-profile thumbnail" src="{$SITE_URL}/uploads/images/profile_picture/{$profile_details["profile_photo"]}" /> </div>
                <div class="col-sm-9">
                    <div class="fb-profile-text">
                        <h4>{$u_name}</h4>
                        <p>{$profile_details['email']}</p>
                    </div>
                    <div class="new_line"></div>
                </div>
                <div class="col-sm-12">
                    <div class="fb-profile-text_1">
                        <div class="pull-right">
                            <a href="{BASE_URL}/user/edit_profile" type="submit" class="btn btn-sm btn-primary">{lang('edit_profile')}</a>
                        </div>
                        <h3>{$profile_details['rank_name']}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="views-table cols-7 table">
                <tbody>
                    <tr>
                        <td>{lang('user_name')}</td>
                        <td>{$u_name}</td>
                    </tr>
                     <tr>
                        <td>{lang('join_type')}</td>
                        <td>{$profile_details['join_type']}</td>
                    </tr>
                    <tr>
                        <td>{lang('placement_user_name')}</td>
                        <td>{$profile_details['father_name']}</td>
                    </tr>
                    <tr>
                        <td>{lang('sponsor_name')}</td>
                        <td>{$profile_details['sponsor_name']}</td>
                    </tr>
                    {if $MLM_PLAN== "Binary"}
                    <tr>
                        <td>{lang('position')}</td>
                        <td>
                            {if $profile_details["position"]=='L'} 
                                {lang('left')} 
                            {elseif $profile_details["position"]=='R'} 
                                {lang('right')} 
                            {else}
                                NA
                            {/if}
                        </td>
                    </tr>
                    {/if}
                    {if $product_status == "yes"}
                        <tr>
                            <td>{lang('package')}</td>
                            <td>{$product_name}</td>
                        </tr>
                        {if $MODULE_STATUS['product_validity'] == 'yes'}
                            <tr>
                                <td>{lang('package_validity')}</td>
                                <td>{$product_validity}</td>
                            </tr>
                        {/if}
                    {/if}
                     <tr>
                        <td>{lang('referalcount')}</td>
                         <td>{$referal_count}</td>
                     </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tabsy">
        <input type="radio" id="tab1" name="tab" checked>
        <label class="tabButton" for="tab1">{lang('personal_info')}</label>
        <div class="tab" id="personal_info">
            <div class="content" id="personal_info_div">
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label>{lang('first_name')}</label>
                        <p class="form-control-static">{$profile_details["name"]}</p>
                        <input type="text" name="first_name" id="first_name" value="{$profile_details["name"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('last_name')}</label>
                        <p class="form-control-static">{$profile_details["user_detail_second_name"]}</p>
                        <input type="text" name="last_name" id="last_name" value="{$profile_details["user_detail_second_name"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('gender')}</label>
                        <p class="form-control-static">
                            {if $profile_details["gender"]=="F"}
                                {lang('female')}
                            {else if $profile_details["gender"]=="M"}
                                {lang('male')}
                            {/if}
                        </p>
                        <select class="form-control" name="gender" id="gender">
                            <option value='M' {if $profile_details["gender"] == 'M'} selected {/if}>{lang('male')}</option>
                            <option value='F' {if $profile_details["gender"] == 'F'} selected {/if}>{lang('female')}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{lang('date_of_birth')}</label>
                        <p class="form-control-static">{$profile_details["dob"]}</p>
                        <input type="text" name="dob" id="dob" data-value="{$profile_details["dob"]}" value="{$profile_details["dob"]}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <input type="radio" id="tab2" name="tab">
        <label class="tabButton" for="tab2">{lang('contact_info')}</label>
        <div class="tab" id="contact_info">
            <div class="content" id="contact_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_contact_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label class="required">{lang('adress_line1')}</label>
                        <p class="form-control-static">{$profile_details["address"]}</p>
                        <input type="text" class="form-control" value="{$profile_details["address"]}" name="address" id="address">
                    </div>
                    <div class="form-group">
                        <label>{lang('adress_line2')}</label>
                        <p class="form-control-static">{$profile_details["user_detail_address2"]}</p>
                        <input type="text" name="address2" id="address2" value="{$profile_details["user_detail_address2"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('country')}</label>
                        <p class="form-control-static">{$profile_details["country"]}</p>
                        <select name="country" id="country" onChange="getAllStates(this.value, 'user');" class="form-control">{$countries}</select>
                    </div>
                    <div class="form-group">
                        <label>{lang('state')}</label>
                        <p class="form-control-static">{$profile_details["state"]}</p>
                        <span id="prof_state_div">
                            <select name="state" id="state" class="form-control">{$states}</select>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('city')}</label>
                        <p class="form-control-static">{$profile_details["user_detail_city"]}</p>
                        <input type="text" name="city" id="city" value="{$profile_details["user_detail_city"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('zip_code')}</label>
                        <p class="form-control-static">{$profile_details["pincode"]}</p>
                        <input type="text" name="pincode" id="pincode" value="{$profile_details["pincode"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('email')}</label>
                        <p class="form-control-static">{$profile_details['email']}</p>
                        <input type="text" name="email" id="email" value="{$profile_details["email"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="required">{lang('mob_no_10_digit')}</label>
                        <p class="form-control-static">{$mobile_code}{$profile_details["mobile"]}</p>
                        <input type="hidden" name="mobile_code" id="mobile_code" value="{$mobile_code}" readonly>
                        <div class="input-group" style="display:none">
                            <span class="input-group-addon"><span id="mcode"></span></span>
                            <input type="text" class="form-control" name="mobile" id="mobile" value="{$profile_details["mobile"]}" >
                        </div>
                    </div> 
                    <div class="form-group">
                        <label>{lang('land_line_no')}</label>
                        <p class="form-control-static">{$profile_details["land"]}</p>
                        <input type="text" name="land_line" id="land_line" value="{$profile_details["land"]}" class="form-control">
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="update_contact_info">{lang('update')}</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_contact_info">{lang('cancel')}</button>
                </div>
            </div>
        </div>
        <input type="radio" id="tab3" name="tab">
        <label class="tabButton" for="tab3">{lang('social_profiles')}</label>
        <div class="tab" id="social_profiles">
            <div class="content" id="social_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_social_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label>{lang('facebook')}</label>
                        <p class="form-control-static">{$profile_details["facebook"]}</p>
                        <input type="text" name="facebook" id="facebook" value="{$profile_details["facebook"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('twitter')}</label>
                        <p class="form-control-static">{$profile_details["twitter"]}</p>
                        <input type="text" name="twitter" id="twitter" value="{$profile_details["twitter"]}" class="form-control">
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="update_social_info">{lang('update')}</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_social_info">{lang('cancel')}</button>
                </div>
            </div>
        </div>
        {if $bank_info_status == 'yes'}
        <input type="radio" id="tab4" name="tab">
        <label class="tabButton" for="tab4">{lang('bank_info')}</label>
        <div class="tab" id="bank_info">
            <div class="content" id="bank_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_bank_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label>{lang('bank_name')}</label>
                        <p class="form-control-static">{$profile_details["nbank"]}</p>
                        <input type="text" name="bank_name" id="bank_name" value="{$profile_details["nbank"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('branch_name')}</label>
                        <p class="form-control-static">{$profile_details["nbranch"]}</p>
                        <input type="text" name="branch_name" id="branch_name" value="{$profile_details["nbranch"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('account_holder')}</label>
                        <p class="form-control-static">{$profile_details["user_detail_nacct_holder"]}</p>
                        <input type="text" name="account_holder" id="account_holder" value="{$profile_details["user_detail_nacct_holder"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('account_no')}</label>
                        <p class="form-control-static">{$profile_details["acnumber"]}</p>
                        <input type="text" name="account_no" id="account_no" value="{$profile_details["acnumber"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('ifsc')}</label>
                        <p class="form-control-static">{$profile_details["ifsc"]}</p>
                        <input type="text" name="ifsc" id="ifsc" value="{$profile_details["ifsc"]}" class="form-control">
                    </div>
                      <!-- <div class="form-group">
                        <label>{lang('pan')}</label>
                        <p class="form-control-static">{$profile_details["pan"]}</p>
                        <input type="text" name="pan" id="pan" value="{$profile_details["pan"]}" class="form-control">
                    </div>-->
                    
                    
                            IF YOU HAVE AN AUSTRALIAN BANK ACCOUNT ONLY
                            <div class="form-group">
                                <label>{lang('account_holder')}</label>
                                <p class="form-control-static">{$profile_details["nacct_australian_holder"]}</p>
                                <input type="text" name="australian_account_holder" id="nacct_australian_holder" value="{$profile_details["nacct_australian_holder"]}" class="form-control">
                            </div>
                            
                               <div class="form-group">
                                <label>{lang('account_no')}</label>
                                <p class="form-control-static">{$profile_details["acnumber_australian"]}</p>
                                <input type="text" name="acnumber_australian" id="acnumber_australian" value="{$profile_details["acnumber_australian"]}" class="form-control">
                            </div>
                                <div class="form-group">
                                <label>{lang('bsb_number')}</label>
                                <p class="form-control-static">{$profile_details["bsb"]}</p>
                                <input type="text" name="bsb" id="bsb" value="{$profile_details["bsb"]}" class="form-control">
                            </div>
                            
                    <button type="button" class="btn btn-sm btn-primary" id="update_bank_info">{lang('update')}</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_bank_info">{lang('cancel')}</button>
                </div>
            </div>
        </div>
        {/if}
        {if count($payment_gateway) > 0}
        <input type="radio" id="tab5" name="tab">
        <label class="tabButton" for="tab5">{lang('payment_details')}</label>
        <div class="tab" id="payment_details">
            <div class="content" id="payment_details_div">
                <div class="wrapper-md" >
                    <i class="fa fa-edit"id="edit_payment_details" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    {assign var="gateway_addr" value=""}
                    {assign var="gateway_id" value=""}
                    {foreach from=$payment_gateway item=v}
                    <div class="form-group">
                        <label>
                            {if $v.gateway_name == "Paypal"}
                                {lang('paypal_account')}
                                {$gateway_addr = $profile_details["paypal_account"]}
                                {$gateway_id = "paypal_account"}
                            {/if}
                            {if $v.gateway_name == "Bitcoin"}
                                {lang('blocktrail')}
                                {$gateway_addr = $profile_details["blocktrail_account"]}
                                {$gateway_id = "blocktrail_account"}
                            {/if}
                            {if $v.gateway_name == "Blockchain"}
                                {lang('blockchain_wallet_address')}
                                {$gateway_addr = $profile_details["blockchain_account"]}
                                {$gateway_id = "blockchain_account"}
                            {/if}
                            {if $v.gateway_name == "Bitgo"}
                                {lang('bitgo')}
                                {$gateway_addr = $profile_details["bitgo_account"]}
                                {$gateway_id = "bitgo_account"}
                            {/if}
                        </label>
                        <p id="span-paypal_account" class="form-control-static">{$gateway_addr}</p>
                        <input type="text" value="{$gateway_addr}" class="form-control" name="{$gateway_id}" id="{$gateway_id}">
                    </div>
                    {/foreach}
                    <div class="new_line"></div>
                    <legend><span class="fieldset-legend">{lang('payment_method')}</span></legend>
                    <div class="form-group">
                        <p class="form-control-static">{$profile_details['payout_type']}</p>
                        <select class="form-control" name="payment_method" id="payment_method">
                            <option value="bank">{lang('bank')}</option>
                            {if count($gateway_list) >0}
                                {foreach from=$gateway_list item="v"}
                                    <option value="{$v.gateway_name}" {if $profile_details['payout_type'] == $v.gateway_name}selected="selected"{/if}>{if $v.gateway_name=="Bitcoin"}{lang('blocktrail')}{else}{$v.gateway_name}{/if}</option>
                                {/foreach}
                            {/if}
                        </select>
                    </div>
                    <button type="button" id="update_payment_details" class="btn btn-sm btn-primary">{lang('update')}</button>
                    <button type="button" id="cancel_payment_details" class="btn btn-sm btn-info">{lang('cancel')}</button>
                </div>
            </div>
        </div>
        {/if}
        {if $MODULE_STATUS['lang_status'] == 'yes'}
        <input type="radio" id="tab6" name="tab">
        <label class="tabButton" for="tab6">{lang('language')}</label>
        <div class="tab" id="language_info">
            <div class="content" id="language_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_language_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label>{lang('language')}</label>
                        <p class="form-control-static">{$profile_details['lang_name']|ucfirst}</p>
                        <select class="form-control" name="language" id="language">
                            {foreach from=$LANG_ARR item=v}
                                <option value="{$v.lang_id}" {if $v.lang_id == $profile_details['lang_id']} selected {/if}>{$v.lang_name_in_english|ucfirst}</option>
                            {/foreach}
                        </select>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="update_language_info">{lang('update')}</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_language_info">{lang('cancel')}</button>
                </div>
            </div>
        </div>
        {/if}
        
        {* {if $wallet_status == 'yes'}*}
        <input type="radio" id="tab7" name="tab">
        <label class="tabButton" for="tab7">{lang('wallet_address')}</label>
        <div class="tab" id="wallet_info">
            <div class="content" id="wallet_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_wallet_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label>{lang('bitcoin_address')}</label>
                        <p class="form-control-static">{$profile_details["bitcoin_address"]}</p>
                        <input type="text" name="bitcoin_address" id="bitcoin_address" value="{$profile_details["bitcoin_address"]}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{lang('payeer_address')}</label>
                        <p class="form-control-static">{$profile_details["payeer_address"]}</p>
                        <input type="text" name="payeer_address" id="payeer_address" value="{$profile_details["payeer_address"]}" class="form-control">
                    </div>
                    
                    <button type="button" class="btn btn-sm btn-primary" id="update_wallet_info">{lang('update')}</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_wallet_info">{lang('cancel')}</button>
                </div>
            </div>
        </div>
       {* {/if}*}
    </div>
    <div id="alert_div">
        <div id="alert_box_err" class="alert alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
    </div>
    {form_close()}
{/block}