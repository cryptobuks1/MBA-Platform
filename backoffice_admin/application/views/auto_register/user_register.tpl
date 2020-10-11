{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{/if}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('checking_placement_data')}</span>
    <span id="validate_msg2">{lang('validate_placement_data')}</span>
    <span id="validate_msg3">{lang('checking_your_position')}</span>
    <span id="validate_msg4">{lang('position_validated')}</span>
    <span id="validate_msg5">{lang('position_not_useable')}</span>
    <span id="validate_msg6">{lang('sponser_name_validated')}</span>
    <span id="validate_msg7">{lang('checking_sponser_user_name')}</span>
    <span id="validate_msg8">{lang('invalid_sponser_user_name')}</span>
    <span id="validate_msg9">{lang('invalid_e_pin')}</span>
    <span id="validate_msg10">{lang('e_pin_validated')}</span>
    <span id="validate_msg11">{lang('checking_e_pin_availability')}</span>
    <span id="validate_msg12">{lang('you_must_select_product')}</span>
    <span id="validate_msg13">{lang('you_must_enter_e_pin')}</span>
    <span id="validate_msg14">{lang('you_must_enter_full_name')}</span>
    <span id="validate_msg15">{lang('you_must_enter_password')}</span>
    <span id="validate_msg16">{lang('minimum_six_characters_required')}</span>
    <span id="validate_msg17">{lang('you_must_enter_your_password_again')}</span>
    <span id="validate_msg18">{lang('password_miss_match')}</span>
    <span id="validate_msg19">{lang('you_must_select_date_of_birth')}</span>
    <span id="validate_msg20">{lang('age_should_be_greater_than_18')}</span>
    <span id="validate_msg21">{lang('you_must_enter_sponser_user_name')}</span>
    <span id="validate_msg22">{lang('you_must_enter_sponser_id')}</span>
    <span id="validate_msg23">{lang('you_must_select_your_position')}</span>
    <span id="validate_msg24">{lang('referral_name')}</span>
    <span id="validate_msg25">{lang('You_must_enter_your_mobile_no')}</span>
    <span id="validate_msg26">{lang('terms_condition')}</span>
    <span id="validate_msg27">{lang('user_name_not_availablity')}</span>
    <span id="validate_msg28">{lang('user_name_not_available')}</span>
    <span id="validate_msg29">{lang('user_name_available')}</span>
    <span id="validate_msg30">{lang('You_must_select_a_date')}</span>
    <span id="validate_msg31">{lang('You_must_select_a_month')}</span>
    <span id="validate_msg32">{lang('You_must_select_a_year')}</span>
    <span id="validate_msg33">{lang('You_must_select_gender')}</span>
    <span id="validate_msg34">{lang('You_must_select_country')}</span>
    <span id="validate_msg35">{lang('mail_id_format')}</span>
    <span id="validate_msg36">{lang('mob_no_10_digit')}</span>
    <span id="validate_msg37">{lang('digits_only')}</span>
    <span id="validate_msg38">{lang('you_must_enter_username')}</span>
    <span id="validate_msg39">{lang('special_chars_not_allowed')}</span>
    <span id="validate_msg40">{lang('you_must_enter_email_id')}</span>
    <span id="validate_msg41">{lang('You_must_enter_your_address')}</span>
    <span id="validate_msg42">{lang('enter_card_no')}</span>
    <span id="validate_msg43">{lang('ent_amnt')}</span>
    <span id="validate_msg44">{lang('ent_valid_no')}</span>
    <span id="validate_msg45">{lang('ent_expiry_date')}</span>
    <span id="validate_msg46">{lang('ent_fore_name')}</span>
    <span id="validate_msg47">{lang('ent_sure_name')}</span>
    <span id="validate_msg48">{lang('special_chars_not_allowed')}</span> 
    <span id="validate_msg49">{lang('checking_balance')}</span>
    <span id="validate_msg50">{lang('insuff_bal')}</span> 
    <span id="validate_msg51">{lang('bal_ok')}</span>
    <span id="validate_msg52">{lang('invalid_transaction_password')}</span>
    <span id="validate_msg53">{lang('transaction_ok')}</span>
    <span id="validate_msg54">{lang('checking_transaction')}</span>
    <span id="validate_msg55">{lang('bal_ok')}</span>
    <span id="validate_msg56">{lang('you_must_select_pay_type')}</span>
    <span id="validate_msg57">{lang('you_must_enter_pin_value')}</span>
    <span id="validate_msg58">{lang('characters_only')}</span>
    <span id="validate_msg59">{lang('pan_format')}</span>
    <span id="validate_msg60">{lang('checking_trans_details')}</span>
    <span id="validate_msg61">{lang('invalid_trans_details')}</span>
    <span id="validate_msg62">{lang('valid_trans_details')}</span>
    <span id="validate_msg63">{lang('username_more_than_6_charactors')}</span>
    <span id="validate_msg65">{lang('enter_second_name')}</span>
    <span id="validate_msg66">{lang('enter_address_line2')}</span>
    <span id="validate_msg67">{lang('enter_city')}</span>
    <span id="validate_msg68">{lang('sponsor_full_name')}</span>
    <span id="validate_msg69">{lang('enter_atleast_5_chars')}</span>
    <span id="validate_msg70">{lang('mobile_number_must_10digits_long')}</span>
    <span id="select_state">{lang('select_state')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<style>
    .val-error {
        color:rgba(249, 6, 6, 1);
        opacity:1;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>                        
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
                {lang('new_user_signup')}
            </div>
            <div class="panel-body">
                {if $LOG_USER_TYPE !='user'}﻿
                    {if $MODULE_STATUS['product_status'] == "yes"}
                        {if $is_product_added != "yes"}
                            <div class="alert alert-warning">
                                <button data-dismiss="alert" class="close">
                                    ×
                                </button>
                                <i class="fa fa-warning-circle"></i>
                                <strong>{lang('no_product_added_yet')}!   </strong><a href="{$PATH_TO_ROOT_DOMAIN}admin/product/product_management">{lang('please_click_here_to_add_')}</a>
                            </div>
                            </tr>
                        {/if}
                    {/if}
                    {if $MODULE_STATUS['pin_status'] == "yes"}
                        {if $is_pin_added != "yes"}
                            <div class="alert alert-warning">
                                <button data-dismiss="alert" class="close">
                                    ×
                                </button>
                                <i class="fa fa-warning-circle"></i>
                                <strong>{lang('no_e_pin_added_yet')}!   </strong><a href="{$PATH_TO_ROOT_DOMAIN}admin/epin/epin_management">{lang('please_click_here_to_add_e_pin')}</a>
                            </div>
                            </tr>
                        {/if}
                    {/if}
                {/if}

                {form_open('auto_register/register_submit', 'role="form" class="" method="post"  name="form" id="form"')}

                    <input type="hidden" name="mlm_plan" id="mlm_plan" value="{$MLM_PLAN}"/>
                    <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}"/>
                    <input type="hidden" name="lang_id" id="lang_id" value="{$LANG_ID}"/>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"/>
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}"/>
                    <input type="hidden" id="reg_from_tree" name="reg_from_tree" value="{$reg_from_tree}"/>
                    <input type="hidden" id="username_type" name="username_type" value="{$user_name_type}"/>
                    <input type="hidden" id="pin_count" name="pin_count" value="{$pin_count}" /> 
                    <input type="hidden" id="ewallet_bal" name="ewallet_bal" value="0"/>
                    <input type="hidden" id ="registration_fee" name= "registration_fee"  value = "{$registration_fee}" />
                    <input type="hidden" id ="product_amount" name= "product_amount"  value = "{$registration_fee}" />
                    <input type="hidden" id ="total_reg_amount" name= "total_reg_amount"  value = "{$registration_fee}" />
                    <input type="hidden" id ="product_status" name= "product_status"  value = "{$MODULE_STATUS['product_status']}" />              
                    <input name="date_of_birth" id="date_of_birth" type="hidden" size="16" maxlength="10"  {if $reg_count>0} value="{$reg_post_array['date_of_birth']}" {/if} />

                    <div id="wizard" class="swMain sw-container tab-content row">
                        {*<ul>
                            <li>
                                <a href="#step-1">
                                    <div class="stepNumber">
                                        1
                                    </div>
                                    <span class="stepDesc"> {lang('step1')} 
                                        <br />
                                        <small>{lang('sponsor_and_package_information')} </small> 
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-2">
                                    <div class="stepNumber">
                                        2
                                    </div>
                                    <span class="stepDesc"> {lang('step2')}
                                        <br />
                                        <small> {lang('contact_info')} & {lang('bank_info')}  </small> 
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-3">
                                    <div class="stepNumber">
                                        3
                                    </div>
                                    <span class="stepDesc"> {lang('step3')}
                                        <br />
                                        <small> {lang('reg_type')} </small> 
                                    </span>
                                </a>
                            </li>
                        </ul>*}

                        {*<div class="progress progress-striped active progress-sm">
                            <div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-success step-bar">
                                <span class="sr-only">{lang('complete_sucess')}</span>
                            </div>
                        </div>*}

                        {*START STEP-1*}
                        <div id="step-1">
                            <div class="col-md-12">
                                <div class="errorHandler alert alert-danger no-display">
                                    <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                </div>
                                 <h2 class="StepTitle">{lang('sponsor_and_package_information')}</h2>
                            </div>
                           
                            <div class="col-sm-8">

                               
                            <div class="form-group">
                                <label class="control-label" for="sponsor_user_name">{lang('sponsor_user_name')}:<font color="#ff0000">*</font></label>
                                <div class="usnam">
                                     
                                    <input name="sponsor_user_name" tabindex="1" id="sponsor_user_name" type="text" size="22" maxlength="20" autocomplete="Off" value="{$sponsor_user_name}"  title="" class="form-control"/>
                                    <span id="referral_box" style="display:none;"></span> 
                                    <span id="errormsg4"></span>
                                    {if isset($error['sponsor_user_name'])}<span class='val-error' >{$error['sponsor_user_name']} </span>{/if}
                                </div> 
                            </div>
                        </div>

                            <div class="form-group">
                                <div class="col-sm-11 spon" id="referal_div"  height="30" class="text" style="display:none;margin-left: -15px; ">
                                </div>
                            </div>


                            {if $reg_from_tree} 
                            <div class="col-sm-8">
                                 
                                <div class="form-group">
                                   <label class="control-label" for="placement_user_name">{lang('placement_user_name')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-7">
                                        <input tabindex="3" type="text" name="placement_user_name" id="placement_user_name" size="20" value="{$placement_user_name}" readonly="" autocomplete="Off" title="" class="form-control"/> 
                                        <span id="username_box" style="display:none;"></span>
                                    </div>
                                </div>
                            </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="placement_full_name">{lang('placement_full_name')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-7">
                                        <input tabindex="4" type="text" name="placement_full_name" id="placement_full_name" size="22" maxlength="50"  value="{$placement_full_name}" readonly="" autocomplete="Off"  class="form-control">
                                    </div>
                                </div>
                            {else}
                                <input tabindex="3" type="hidden" name="placement_user_name" id="placement_user_name" size="20" value="{$placement_user_name}" readonly="" autocomplete="Off" title="" class="form-control"/> 
                                <input tabindex="4" type="hidden" name="placement_full_name" id="placement_full_name" size="22" maxlength="50"  value="{$placement_full_name}" readonly="" autocomplete="Off"  class="form-control">
                            {/if}

                            {if $MLM_PLAN == "Binary"}
                                <div class="form-group">
                                   
                                    <div class="col-sm-7">
                                         <label class="control-label" for="position">{lang('position')}:<font color="#ff0000">*</font></label>
                                        <select tabindex="5" name="position" id="position" class="form-control" >   

                                            {if $reg_from_tree} 
                                                {if $position =='L'}
                                                    <option value="L" selected="selected" readonly="true">{lang('left_leg')}</option>
                                                {elseif $position =='R'}
                                                    <option value="R" selected="selected" readonly="true">{lang('right_leg')}</option>
                                                {/if}
                                            {else}
                                                <option value="" selected="selected">{lang('select_leg')}</option>
                                                <option value="L" {if isset($reg_post_array['position']) && $reg_post_array['position'] == 'L'}selected=""{/if}>{lang('left_leg')}</option>
                                                <option value="R" {if isset($reg_post_array['position']) && $reg_post_array['position'] == 'R'}selected=""{/if}>{lang('right_leg')}</option>
                                            {/if}                                            
                                        </select>
                                        <span id="errormsg2"></span>
                                        {if isset($error['position'])}<span class='val-error' >{$error['position']} </span>{/if}
                                    </div>
                                </div> 
                            {else}
                                <input tabindex="5" type='hidden' value='{$position}' name='position' id='position' class="form-control">
                            {/if}

                            {if $MODULE_STATUS['product_status'] == "yes"}
                                <div class="form-group">
                                    
                                    <div class="col-sm-7">
                                        <label class=" control-label" for="product_id">{lang('product')}:<font color="#ff0000">*</font></label> 
                                        <select tabindex="6" name="product_id" id="product_id" class="form-control">                                           
                                            {$products}
                                        </select> 
                                        <span id="error_product"></span>
                                        {if isset($error['product_id'])}<span class='val-error' >{$error['product_id']} </span>{/if}
                                    </div>    
                                </div>
                            {else}
                                <input tabindex="6" type='hidden' value='0' name='product_id' id='product_id' class="form-control">
                            {/if}
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-3">
                                    <button tabindex="7" class="btn btn-blue next-step btn-block" id="next_1" disabled style="display: none;">
                                        {lang('next')} <i class="fa fa-arrow-circle-right"></i>
                                    </button> 
                                </div>
                            </div>
                        </div> 
                        {*END STEP-1*}
                        {*START STEP-2*}
                        <div id="step-2">
                        <div class="col-sm-12">
                            <h2>{lang('login_information')}</h2>
                         </div>
                            <hr>                            
                            <div class="form-group">
                               
                                <div class="col-sm-7">
                                     <label class="control-label" for="user_count">User Count:<font color="#ff0000">*</font></label>
                                    <input  tabindex="8" type="text"  name="user_count" id="user_count"  maxlength="2" autocomplete="Off"  class="form-control" value="1" >
                                </div>
                            </div>
                            {if {$user_name_type}!="dynamic"}
                                <div class="form-group">
                                   
                                    <div class="col-sm-7">
                                         <label class=" control-label" for="user_name_entry">{lang('User_Name')}:<font color="#ff0000">*</font></label>
                                        <input tabindex="8"  type="text" name="user_name_entry" id="user_name_entry" maxlength="32" autocomplete="Off"  {if $reg_count>0} value="{$reg_post_array['user_name_entry']}" {/if} class="form-control">
                                        <span id="errormsg3"></span>
                                        <span id="errmsg33"></span>
                                        {if isset($error['user_name_entry'])}<span class='val-error'>{$error['user_name_entry']} </span>{/if}
                                    </div>  
                                </div>
                            {else}
                                <input tabindex="8" type='hidden' value='{$user_name_type}' name='user_name_entry' id='user_name_entry' class="form-control">
                            {/if}
                            <div class="form-group">
                                
                                <div class="col-sm-7">
                                    <label class=" control-label" for="password">{lang('password')}:<font color="#ff0000">*</font></label>
                                    <input  tabindex="9" type="password"  name="pswd" id="pswd"  maxlength="32" autocomplete="Off"  class="form-control" >
                                    {if isset($error['pswd'])}<span class='val-error' >{$error['pswd']} </span>{/if}
                                </div>
                            </div>
                            <div class="form-group">
                               
                                <div class="col-sm-7">
                                     <label class=" control-label" for="cpswd">{lang('confirm_password')}:<font color="#ff0000">*</font></label>
                                    <input tabindex="10" name="cpswd" id="cpswd" type="password" autocomplete="Off"  maxlength="32" class="form-control" >
                                    {if isset($error['cpswd'])}<span class='val-error' >{$error['cpswd']} </span>{/if}
                                </div>
                            </div>
                          <div class="col-sm-12">  <h2>{lang('personal_information')}</h2></div>
                            <hr>
                            <div class="form-group">
                              
                                <div class="col-sm-7">
                                      <label class=" control-label" for="first_name">{lang('first_name')}:<font color="#ff0000">*</font></label>
                                    <input tabindex="11" type="text" maxlength="32"  name="first_name" id="first_name"  autocomplete="Off"  class="form-control"  {if isset($reg_post_array['first_name'])} value="{$reg_post_array['first_name']}" {/if} />
                                    {if isset($error['first_name'])}<span class='val-error' >{$error['first_name']} </span>{/if}
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="col-sm-7">
                                    <label class="control-label" for="last_name">{lang('last_name')}:<font color="#ff0000">*</font></label>
                                    <input tabindex="12"  type="text"   name="last_name" id="last_name"  maxlength="32"autocomplete="Off"  class="form-control" {if isset($reg_post_array['last_name'])} value="{$reg_post_array['last_name']}" {/if} >
                                    {if isset($error['last_name'])}<span class='val-error' >{$error['last_name']} </span>{/if}
                                </div>
                            </div>
                            <div class="form-group">
                              
                                <div class="col-sm-7">
                                      <label class="control-label" for="gender">{lang('gender')}:<font color="#ff0000">*</font></label>
                                    <select  tabindex="13"name="gender" id="gender"  class="form-control">
                                        <option value="">{lang('select_gender')}</option>
                                        <option value='M' {if isset($reg_post_array['gender'])&&$reg_post_array['gender']=="M"}selected{/if}>{lang('male')} </option>
                                        <option value='F' {if isset($reg_post_array['gender'])&&$reg_post_array['gender']=="F"}selected{/if}>{lang('female')}</option>
                                    </select>
                                    {if isset($error['gender'])}<span class='val-error' >{$error['gender']} </span>{/if}
                                </div>
                            </div> 
                            <div class="form-group">
                              
                                <div class="col-sm-7 yr">
                                      <label class="control-label" for="date_of_birth">{lang('date_of_birth')}:<font color="#ff0000">*</font> </label>

                                    <p>
                                    <div class="col-sm-4" style="margin-left: -14px;">
                                        <select  tabindex="14" name="year" id="year" class="form-control"  onchange="change_year(this);" onblur="day_year(this);">
                                            <option value="">{lang('year')}</option>
                                            {for $year = 1900 to {'Y'|date}}
                                                {if $reg_count}
                                                    <option value="{$year}" {if $year==$reg_post_array['year']}selected{/if}>{$year}</option>
                                                {else}
                                                    <option value="{$year}" >{$year}</option>
                                                {/if}
                                            {/for}                                           
                                        </select>
                                    </div>
                                    </p>
                                    <p>
                                    <div class="col-sm-4">
                                        <select  tabindex="15" name="month" id="month" onchange="change_month(this);"class="form-control" onblur="day_month(this);">   
                                            <option value="">{lang('month')}</option>
                                            {for $month = 1 to 12}
                                                {$month_value = {"%02d"|sprintf:$month}}
                                                {if $reg_count}
                                                    <option value="{$month_value}" {if $month_value==$reg_post_array['month']}selected{/if}>{$month_value}</option>
                                                {else}
                                                    <option value="{$month_value}" >{$month_value}</option>
                                                {/if}
                                            {/for}                                            
                                        </select> 
                                    </div>
                                    </p>
                                    <p>
                                    <div class="col-sm-4">
                                        <select tabindex="16" name="day" id="day" onchange="change_day(this);" class="form-control" >
                                            <option value="">{lang('day')}</option>
                                            {for $day = 1 to 31}
                                                {$day_value = {"%02d"|sprintf:$day}}
                                                {if $reg_count}
                                                    <option value="{$day_value}" {if $day_value==$reg_post_array['day']}selected{/if}>{$day_value}</option>
                                                {else}
                                                    <option value="{$day_value}" >{$day_value}</option>
                                                {/if}
                                            {/for}   
                                        </select>
                                    </div>
                                    </p>
                                    {if isset($error['day'])|| isset($error['year']) ||isset($error['month'])}<span class='val-error' >{$error['year']} </span>{/if} 
                                </div>
                            </div>
                            <div class="form-group">
                              
                                <div class="col-sm-7">

                                  
                                        <label class="control-label" for="address">{lang('adress_line1')}:<font color="#ff0000">*</font></label>
                                    <input   tabindex="17" type="text"   name="address" size="70" id="address"  maxlength="128"autocomplete="Off"  class="form-control" {if isset($reg_post_array['address'])} value="{$reg_post_array['address']}" {/if} >                                    
                                    <span id="errmsg1" style="display: none;"></span>
                                   
                                    {if isset($error['address'])}<span class='val-error' >{$error['address']} </span>{/if}
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="col-sm-7">
                                    <label class="control-label" for="address_line2">{lang('adress_line2')}:</label>
                                    <input  tabindex="18" type="text"   name="address_line2" id="address_line2"  maxlength="128"autocomplete="Off"  class="form-control"  {if isset($reg_post_array['address_line2'])} value="{$reg_post_array['address_line2']}" {/if} >

                                    {if isset($error['address_line2'])}<span class='val-error' >{$error['address_line2']} </span>{/if}
                                </div>
                            </div>
                            <div class="form-group">
                               
                                <div class="col-sm-7">
                                     <label class=" control-label" for="pin">{lang('zip_code')}:</label>
                                    <input  tabindex="19" type="text"  name="pin" id="pin"   autocomplete="Off" class="form-control" maxlength="6" {if isset($reg_post_array['pin'])} value="{$reg_post_array['pin']}" {/if} >
                                    <span id="errmsg2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="col-sm-7">
                                   <label class="control-label" for="country">{lang('country')}:<font color="#ff0000">*</font></label>
                                    <select  tabindex="20" name="country" id="country" onChange="getAllStates(this.value)" class="form-control" >       

                                        <option value="" class="form-control">{lang('select_country')}</option>
                                        {$countries}
                                    </select>
                                    {if isset($error['country'])}<span class='val-error' >{$error['country']} </span>{/if}
                                </div>
                            </div>
                            <div class="form-group">                  
                               
                                <div class="col-sm-7">
                                     <label class=" control-label" for="">{lang('state')}:</label>
                                    <select  tabindex="21" name="state" id="state" onChange="" class="form-control" >
                                        <option value='' selected='selected'>{lang('select_state')}</option>
                                        {$states}
                                    </select>
                                </div>
                            </div>   

                            <div class="form-group">
                               
                                <div class="col-sm-7">
                                     <label class="control-label" for="city">{lang('city')}:<font color="#ff0000">*</font></label>
                                    <input   tabindex="22" type="text"  name="city" id="city" maxlength="32" autocomplete="Off" class="form-control" {if isset($reg_post_array['city'])} value="{$reg_post_array['city']}" {/if} >
                                    {if isset($error['city'])} <span class='val-error' >{$error['city']} </span>{/if}
                                </div>
                            </div>                                
                            <div class="form-group">

                               
                                <div class="col-sm-7">
                                     <label class=" control-label" for="email">{lang('email')}:<font color="#ff0000">*</font></label>
                                    <input tabindex="23" name="email" id="email" type="text"  autocomplete="Off" maxlength="75" class="form-control" {if isset($reg_post_array['email'])} value="{$reg_post_array['email']}" {/if}>
                                    {if isset($error['email'])}<span class='val-error' >{$error['email']} </span>{/if}
                                </div> 
                            </div>
                            <div class="form-group">

                              
                                <div class="col-sm-7">
                                      <label class="  control-label" for="land_line">{lang('land_line_no')}:</label>
                                    <input tabindex="24" name="land_line" id="land_line"  type="text" autocomplete="Off" maxlength="20" class="form-control" {if $reg_count>0} value="{$reg_post_array['land_line']}" {/if}>
                                    <span id="errmsg4"></span>
                                </div>
                            </div>

                            <label class="control-label" for="mobile" style="margin-left: 15px;">{lang('mobile_no')}:<font color="#ff0000">*</font></label>
                            <div class="form-group">
                               
                                <div class="col-sm-7">
                                     
                                    <div class="col-sm-2">

                                        <input  tabindex="25" name="mobile_code" readonly="" style="margin-left: -10px;" id="mobile_code" {if $reg_count>0}value="{$reg_post_array['mobile_code']}"{/if} type="text" autocomplete="Off" class="form-control" maxlength="10">
                                    </div> 

                                    <div class="col-sm-9">
                                        <input  tabindex="26" name="mobile" style="margin-left:-30px;" id="mobile" type="text" autocomplete="Off" class="form-control" maxlength="10" {if $reg_count>0} value="{$reg_post_array['mobile']}" {/if} >
                                        {if isset($error['mobile'])}<span class='val-error' >{$error['mobile']} </span>{/if}
                                        <span id="errmsg5"></span>
                                    </div>
                                </div>
                            </div>
                        <div class="col-sm-12">    <h3> {lang('bank_info')}</h3></div>
                            <hr> 
                            <div class="form-group">

                               
                                <div class="col-sm-7">
                                     <label class=" control-label" for="bank_name">{lang('bank_name')}:</label>
                                    <input  tabindex="27" type="text" maxlength="32" name="bank_name" id="bank_name"  autocomplete="Off"  class="form-control" {if $reg_count >0} value="{$reg_post_array['bank_name']}" {/if}>
                                </div>
                            </div>
                            <div class="form-group">
                               
                                <div class="col-sm-7">
                                     <label class="control-label" for="bank_branch">{lang('branch_name')}:</label>
                                    <input  tabindex="28"  type="text"  name="bank_branch" id="bank_branch" maxlength="32" autocomplete="Off"  class="form-control" {if $reg_count >0} value="{$reg_post_array['bank_branch']}" {/if}>
                                </div> 
                            </div>
                            <div class="form-group">
                               
                                <div class="col-sm-7">
                                     <label class="control-label" for="bank_acc_no">{lang('bank_account_number')}:</label>
                                    <input  tabindex="29" type="text"  name="bank_acc_no" maxlength="32" id="bank_acc_no"  autocomplete="Off" class="form-control" {if $reg_count >0} value="{$reg_post_array['bank_acc_no']}" {/if}>
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="col-sm-7">
                                    <label class="control-label" for="ifsc">{lang('ifsc_code')}:</label>
                                    <input  tabindex="30" type="text"  name="ifsc" id="ifsc" maxlength="32" autocomplete="Off"  class="form-control" {if $reg_count >0} value="{$reg_post_array['ifsc']}" {/if}>
                                </div>
                            </div>

                            <div class="form-group">
                                
                                <div class="col-sm-7">
                                    <label class="control-label">
                                    {lang('pan_no')}:
                                </label>
                                    <input  tabindex="31" class="form-control"  type="text" name="pan_no" maxlength="32" id="pan_no" {if $reg_count >0} value="{$reg_post_array['pan_no']}" {/if} placeholder="ABCDE1234Z">
                                </div>
                            </div>

                            <div class="modal fade" id="panel-config" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                                                &times;
                                            </button>
                                            <h4 class="modal-title">{lang('terms_conditions')}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <table cellpadding="0" cellspacing="0" align="center">
                                                <tr>
                                                    <td width="80%">
                                                        {$termsconditions}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button  type="button" class="btn btn-default" data-dismiss="modal" >
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                  <label class="checkbox-inline">
                                        <input name="agree" id="agree"  type="checkbox" value="" tabindex="32" style="margin-left: -4px !important;">
                                        <a class="btn btn-xs btn-link panel-config" data-toggle="modal" href ="#panel-config"  style="text-decoration: none" >
                                            {lang('I_ACCEPT_TERMS_AND_CONDITIONS')}
                                        </a>
                                        <font color="#ff0000">*</font>
                                    </label>
                        
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-3">
                                    <button tabindex="33" class="btn btn-dark-grey back-step btn-block" style="margin-bottom: 10px;display:none;"  disabled="" >
                                        <i class="fa fa-circle-arrow-left"></i> {lang('back')}
                                    </button>
                                </div> 

                                <div class="col-sm-2 col-sm-offset-3">

                                    <button tabindex="34" class="btn btn-blue next-step btn-block"  id="next_2" disabled="" style="display:none;">
                                        {lang('next')} <i class="fa fa-arrow-circle-right"></i>
                                    </button> 
                                </div>
                            </div>
                        </div> 
                        {*END STEP-2*}
                        {*START STEP-3*}
                        <div id="step-3">
                            <center> 
                                {if $MODULE_STATUS['product_status'] == "yes" || $registration_fee}
                                    <div class="row">
                                        <h2>{lang('total_amount')}:  
                                            <span style="font-family: monospace;height:15px; width:100px" class="total-title" id="total_product_amount">
                                                <b>{$registration_fee}</b>
                                            </span>
                                        </h2>
                                    </div>
                                {/if}
                            </center>
                            <h3></h3>
                            <h2 class="StepTitle">{lang('reg_type')}</h2>
                            <h3></h3>
                            {assign var=total value=''}

                            <div class="tabbable ">
                                <ul id="myTab3" class="nav nav-tabs tab-green">                                    
                                    {assign var=active_tab_val value="free_join_tab"} 
                                    {$active_tab_val="free_join_tab"}  
                                    <li  class="active" id="free_join_tab">
                                        <a href="#panel_tab4_example5" data-toggle="tab">
                                            <i class="blue fa fa-user"></i>{lang('free_join')}
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <input type="hidden" name="active_tab" id="active_tab" value="{$active_tab_val}" >
                                    <div class="tab-pane active"  id="panel_tab4_example5">
                                        <div class="panel panel-default">
                                            <div class="panel-heading freejoin def">
                                                <i class="fa fa-external-link-square">{lang('free_join')}
                                                </i>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="col-sm-2 ">
                                                        <button class="btn btn-dark-grey back-step btn-block"  style="margin-bottom: 10px;display: none;">
                                                            <i class="fa fa-circle-arrow-left"></i> {lang('back')}
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2 col-sm-offset-8">


                                                        <button class="btn btn-bricky btn-block" name="free_join" id="free_join" >
                                                            {lang('finish')} <i class="fa fa-arrow-circle-right"></i>
                                                        </button>  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        {*END STEP-3*}
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

<div id="div_pos" style="display: none;">
    <option value="">{lang('select_leg')}</option>
    <option value="L">{lang('left_leg')}</option>
    <option value="R">{lang('right_leg')}</option>
</div>

{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{/if}

<script>
    $(function() {

    {if $reg_count}
        $("#position").trigger('change');
        {if $MODULE_STATUS['product_status'] == "yes"}
        $("#product_id").trigger('change');
        {/if}
    {/if}
        
    window.onload = function() {
        $("#sponsor_user_name").trigger('blur');
    }
    });
</script> 

{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
{/if}