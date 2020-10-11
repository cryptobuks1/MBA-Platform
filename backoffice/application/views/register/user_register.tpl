{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_sponsor_name">{sprintf(lang('required'),lang("sponsor name"))}</span>
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
    <span id="validate_msg69">{lang('enter_atleast_3_digits')}</span>
    <span id="validate_msg70">{lang('mobile_number_must_10digits_long')}</span>
    <span id="validate_msg71">{lang('duplicate_epin')}</span>
    <span id="validate_msg72">{lang('user_name_cannot_be_null')}</span>
    <span id="validate_msg73">{lang('must_enter_first_name')}</span>
    <span id="validate_msg74">{lang('must_enter_second_name')}</span>
    <span id="validate_msg75">{lang('only_alphanumerals')}</span>
    <span id="validate_msg76">{lang('username_cannot_be_greater_than_12_characters')}</span>
    <span id="validate_msg78">{lang('city_field_characters')}</span>
    <span id="validate_msg79">{lang('adderss_field_characters')}</span>
    <span id="validate_msg80">{lang('password_characters_allowed')}</span>
    <span id="validate_msg81">{lang('digits_only')}</span>
    <span id="validate_msg82">{lang('you_must_enter_transaction_password')}</span>
    <span id="validate_msg83">{lang('invalid_bitcoin_address')}</span>
    <span id="validate_msg90">{lang('You_should_be_atleast_n_years_old')}</span>
    <span id="validate_msg91">{lang('only_alpha_space')}</span>
    <span id="validate_msg92">{lang('no_more_than_10_dgts')}</span>
    <span id="validate_msg93">{lang('enter_atleast_3_chars')}</span>
    <span id="validate_msg95">{lang('enter_atleast_5_digits')}</span>
    <span id="validate_msg96">{lang('enter_max_digits')}</span>
    <span id="validate_msg97">{lang('invalid_sponsor_full_name')}</span>
    <span id="validate_msg98">{lang('sponsor_full_name_validated')}</span>
    <span id="validate_msg99">{lang('checking_sponsor_full_name')}</span>
    <span id="validate_msg100">{lang('no_more_than_32_characters')}</span>
    <span id="validate_msg101">{lang('you_must_enter_last_name')}</span>
    <span id="validate_msg102">{lang('you_must_enter_address_line_2')}</span>
    <span id="validate_msg103">{lang('you_must_enter_zip_code')}</span>
    <span id="validate_msg104">{lang('you_must_enter_land_line')}</span>
    <span id="validate_msg105">{lang('you_must_select_state')}</span>
    <span id="select_state">{lang('select_state')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="year_error">{if isset($error['year'])}{$error['year']}{/if}</span>
    <span id="month_error">{if isset($error['month'])}{$error['month']}{/if}</span>
    <span id="day_error">{if isset($error['day'])}{$error['day']}{/if}</span>
    <span id="dob_error">{if isset($error['date_of_birth'])}{$error['date_of_birth']}{/if}</span>
    <span id="year_val">{if isset($reg_post_array['year'])}{$reg_post_array['year']}{/if}</span>
    <span id="month_val">{if isset($reg_post_array['month'])}{$reg_post_array['month']}{/if}</span>
    <span id="day_val">{if isset($reg_post_array['day'])}{$reg_post_array['day']}{/if}</span>
    <span id="finish_lang">{lang('finish')}</span>
    <span id="next_lang">{lang('next')}</span>
    <span id="back_lang">{lang('back')}</span>
</div>

<div class="col-md-7 col-md-offset-2 m-b-xxl">
  {form_open_multipart('register/register_submit', 'role="form" method="post"  name="form" id="msform"')}
                    {if $from_replica}{include file="layout/alert_box.tpl"}{/if}
                    <input type="hidden" name="sponsor_required" id="sponsor_required" value="{$signup_settings['sponsor_required']}"/>
                    <input type="hidden" name="age_limit" id="age_limit" value="{$signup_settings['age_limit']}"/>
                    <input type="hidden" name="mlm_plan" id="mlm_plan" value="{$MLM_PLAN}"/>
                    <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}"/>
                    <input type="hidden" name="lang_id" id="lang_id" value="{$LANG_ID}"/>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"/>
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}"/>
                    <input type="hidden" id="reg_from_tree" name="reg_from_tree" value="{$reg_from_tree}"/>
                    <input type="hidden" id="username_type" name="username_type" value="{$user_name_type}"/>
                    <input type="hidden" id="pin_count" name="pin_count" value="{$pin_count}" /> 
                    <input type="hidden" id="epin_count" name="epin_count" value="0" /> 
                    <input type="hidden" id="ewallet_bal" name="ewallet_bal" value="0"/>
                    <input type="hidden" id ="ewallet_cheking_type" name= "ewallet_cheking_type"  value = "register" />
                    <input type="hidden" id ="registration_fee" name= "registration_fee"  value = "{$registration_fee}" />
                    <input type="hidden" id ="product_amount" name= "product_amount"  value = "{$registration_fee}" />
                    <input type="hidden" id ="total_reg_amount" name= "total_reg_amount"  value = "{$registration_fee}" />
                    <input type="hidden" id ="total_reg_amount1" name= "total_reg_amount1"  value = "{$registration_fee1}" />
                    <input type="hidden" id ="product_status" name= "product_status"  value = "{$MODULE_STATUS['product_status']}" />                          
                    <input name="date_of_birt" id="date_of_birt" type="hidden" size="16" maxlength="10"  {if $reg_count>0} value="{$reg_post_array['date_of_birth']}" {/if} />
                    <input type="hidden" name="default_country" id="default_country" value="{$signup_settings['default_country']}"/>
                    <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active"></li>
    <li></li>
    <li></li>
    <li></li>
  </ul>
  <!-- fieldsets -->
  <fieldset>
      <h2 class="fs-title"> {lang('sponsor_and_package_information')}</h2>
      <div class="form-group">
          <label class="control-label" for="sponsor_user_name">{lang('sponsor_user_name')}<font color="#ff0000">*</font></label>
              {if $LOG_USER_ID}
              <input name="sponsor_user_name" id="sponsor_user_name" type="text" size="22" autocomplete="Off" value="{$sponsor_user_name}"  title="" class="form-control" {if $LOG_USER_TYPE != 'admin' && $LOG_USER_TYPE != 'employee'} readonly="" {/if}/>
          {else}
              <input name="sponsor_user_name" id="sponsor_user_name" type="text" size="22" autocomplete="Off" value="{$sponsor_user_name}"  title="" class="form-control"/>    
          {/if}
          <span id="referral_box" style="display:none;"></span> 
          <span id="errormsg4"></span>
          {if isset($error['sponsor_user_name'])}
              <span class='val-error' >{$error['sponsor_user_name']} </span>
          {/if} 
      </div>
      <div class="form-group">
          <div class="col-sm-12" id="referal_div"  height="30" class="text" style="display:none; padding: 0px;">
          </div>
          {if isset($error['sponsor_full_name'])}<div class="col-sm-4 height_mode_tranpass "> <span class='val-error' >{$error['sponsor_full_name']} </span> </div>{/if}   
      </div> 


      {$plan_array = array("Unilevel","Stair_Step")}
      {if $reg_from_tree && !in_array($MLM_PLAN, $plan_array)} 
          <div class="form-group">  
              <label class="control-label" for="placement_user_name">{lang('placement_user_name')}<font color="#ff0000">*</font></label>
              <input type="text" name="placement_user_name" id="placement_user_name" size="20" value="{$placement_user_name}" readonly="" autocomplete="Off" title="" class="form-control"/> 
              <span id="username_box" style="display:none;"></span>

          </div>
          <div class="form-group">
              <label class="control-label" for="placement_full_name">{lang('placement_full_name')}</label>
              <input type="text" name="placement_full_name" id="placement_full_name" size="22" value="{$placement_full_name}" readonly="" autocomplete="Off"  class="form-control">
          </div>
      {else}
          <input type="hidden" name="placement_user_name" id="placement_user_name" size="20" value="{$placement_user_name}" readonly="" autocomplete="Off" title="" class="form-control"/> 
          <input type="hidden" name="placement_full_name" id="placement_full_name" size="22" maxlength="50"  value="{$placement_full_name}" readonly="" autocomplete="Off"  class="form-control">
      {/if}

      {if $MLM_PLAN == "Binary"}
          <div class="form-group">
              <label class="control-label" for="position">{lang('position')}<font color="#ff0000">*</font></label>
              <select name="position" id="position" class="form-control" >
                  {if $reg_from_tree}
                      {if $position == 'L'}
                          <option value="L">{lang('left_leg')}</option>
                      {elseif $position == 'R'}
                          <option value="R">{lang('right_leg')}</option>
                      {/if}
                  {else}
                      <option value="">{lang('select_leg')}</option>
                      <option value="L" {if isset($reg_post_array['position']) && $reg_post_array['position'] == 'L'} selected {/if}>{lang('left_leg')}</option>
                      <option value="R" {if isset($reg_post_array['position']) && $reg_post_array['position'] == 'R'} selected {/if}>{lang('right_leg')}</option>
                  {/if}
              </select>
              <span id="errormsg2"></span>
              {if isset($error['position'])}<span class='val-error' >{$error['position']} </span>{/if}
          </div>
      {else}
          <input type='hidden' value='{$position}' name='position' id='position' class="form-control">
      {/if}
      {if $MODULE_STATUS['product_status'] == "yes"}
          <div class="form-group">
              <label class="control-label" for="product_id">{lang('product')}<font color="#ff0000">*</font></label> 
              <select name="product_id" id="product_id" class="form-control">                                           
                  {$products}
              </select> 
              <span id="error_product"></span>
              {if isset($error['product_id'])}<span class='val-error' >{$error['product_id']} </span>{/if}
          </div>   
      {else}
          <input type='hidden' value='0' name='product_id' id='product_id' class="form-control">
      {/if}
      <input type="button" name="" id="product" class="next action-button" value="{lang('next')}"/>
  </fieldset>
    
    
  <fieldset class="m-b-lg">
          <h2 class="fs-title">{lang('contact_info')}</h2>

            {foreach from=$fields item=v}
                {$name = $v['field_name']}
                {$required = $v['required']}
                <div class="form-group">
                    <label class="control-label" for="{$name}">{lang($name)} {if $required == 'yes'}<font color="#ff0000">*</font> {/if}</label>
                    {if $name == 'country'}
                        <select name="country" id="country" onChange="getAllStates(this.value, 'admin');" class="form-control {if $required == 'yes'} required {/if}">{$countries}</select>
                    {elseif $name == 'gender'}
                        <select name="gender" id="gender" class="form-control {if $required == 'yes'} required {/if}">
                                <option value="">{lang('select_gender')}</option>
                                <option value='M' {if isset($reg_post_array['gender'])&&$reg_post_array['gender']=="M"}selected{/if} >{lang('male')}</option>
                                <option value='F' {if isset($reg_post_array['gender'])&&$reg_post_array['gender']=="F"}selected{/if} >{lang('female')}</option>
                        </select>
                    {elseif $name == 'state'}
                        <select name="state" id="state" class="form-control {if $required == 'yes'} required {/if}">{$states}</select>
                    {else}
                        <input type="text" name="{$name}" id="{$name}"  autocomplete="Off"  class="form-control {if $name =='date_of_birth'} date-picker-dob {/if} {if $required == 'yes'} required {/if}" {if isset($reg_post_array[$name])} value="{$reg_post_array[$name]}" {/if} />
                    {/if}
                    {if isset($error[$name])}<span class='val-error' >{$error[$name]} </span>{/if}
                </div>
            {/foreach}

          <input type="button" name="previous" class="previous action-button-previous" value="{lang('previous')}"/>
          <input type="button" name="next" class="next action-button" value="{lang('next')}"/>
      </fieldset>
                            
      <fieldset>
          <h2 class="fs-title">{lang('login_information')}</h2>
          <div class="form-group">
              {if {$user_name_type}!="dynamic"}
                  <label class="control-label" for="user_name_entry">{lang('User_Name')}<font color="#ff0000">*</font></label>
                  <input type="text" name="user_name_entry" id="user_name_entry" autocomplete="Off"   {if $reg_count >0} value="{$reg_post_array['user_name_entry']}" {/if} class="form-control">
                  <span id="errormsg3"></span>
                  <span id="errmsg33"></span>
                  {if isset($error['user_name_entry'])}<span class='val-error'>{$error['user_name_entry']} </span>{/if}
              {else}
                  <input type='hidden' value='{$user_name_type}' name='user_name_entry' id='user_name_entry' class="form-control">
              {/if}
          </div>
          <div class="form-group">
              <label class="control-label" for="password">{lang('password')}<font color="#ff0000">*</font></label>
              <input type="password"  name="pswd" id="pswd"  autocomplete="Off"  class="form-control" >
              {if isset($error['pswd'])}<span class='val-error' >{$error['pswd']} </span>{/if}
          </div>
          <div class="form-group">
              <label class="control-label" for="cpswd">{lang('confirm_password')}<font color="#ff0000">*</font></label>
              <input name="cpswd" id="cpswd" type="password" autocomplete="Off" class="form-control" >
              {if isset($error['cpswd'])}<span class='val-error' >{$error['cpswd']} </span>{/if}
          </div>
          <div class="form-group">
              <label > </label>
              <div class="checkbox" align="left">
                  <label class="i-checks">
                      <input name="agree" id="agree"  type="checkbox">
                       <i></i> <a class="" data-toggle="modal" href ="#panel-config"  style="text-decoration: none" >
                          {lang('I_ACCEPT_TERMS_AND_CONDITIONS')}
                      </a>
                      <font color="#ff0000">*</font>
                      {if isset($error['agree'])}<span class='val-error' >{$error['agree']} </span>{/if}
                  </label>
              </div>
          </div>
          <input type="button" name="previous" class="previous action-button-previous" value="{lang('previous')}"/>
          <input type="button" name="next" class="next action-button next2" value="{lang('next')}"/>
      </fieldset>
                           
  <fieldset>
  <h2 class="fs-title"> {lang('reg_type')}</h2>
  
  {if $MODULE_STATUS['product_status'] == "yes" || $registration_fee}
          <h4>{lang('total_amount')}:  
              <span style="font-family: monospace;height:15px; width:100px" class="total-title" id="total_product_amount">
                  <b>{$DEFAULT_SYMBOL_LEFT}{number_format($registration_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
              </span>
          </h4>
  {/if}
  {assign var=total value=''}
  {assign var=active_tab_val value="free_join_tab"}
  <div class="col-sm-12 bhoechie-tab-container">
  <div class=" col-sm-3 bhoechie-tab-menu">
    <div class="list-group">

    {if $payment_methods_tab}
        {$payment_pin_status = $payment_module_status_array['epin_type']}
        {$free_joining_status = $payment_module_status_array['free_joining_type']}
        {$payment_ewallet_status = $payment_module_status_array['ewallet_type']}
        {$payment_gateway_status = $payment_module_status_array['gateway_type']}
        {$bank_transfer_status = $payment_module_status_array['bank_transfer']}
        {$paypal_status = $payment_gateway_array['paypal_status']}
        {$bitcoin_status = $payment_gateway_array['bitcoin_status']}
        {$authorize_status = $payment_gateway_array['authorize_status']}
        {$blockchain_status = $payment_gateway_array['blockchain_status']}  
        {$bitgo_status = $payment_gateway_array['bitgo_status']}   
        {$payeer_status = $payment_gateway_array['payeer_status']}  
        {$sofort_status = $payment_gateway_array['sofort_status']}  
        {$squareup_status = $payment_gateway_array['squareup_status']}  
        {if $reg_count}
            {$active_tab_val="{$reg_post_array['active_tab']}"}
        {else}
            {if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes" }         
                {$active_tab_val="epin_tab"}
            {else if  $payment_ewallet_status== 'yes'  } 
                {$active_tab_val="ewallet_tab"}
            {else if $payment_gateway_status == "yes" && $paypal_status == "yes" }
                {$active_tab_val="paypal_tab"}
            {else if  $payment_gateway_status == "yes" && $authorize_status == 'yes'}
                {$active_tab_val="authorize_tab"}
            {else if  $payment_gateway_status == "yes" && $blockchain_status == 'yes'}
                {$active_tab_val="blockchain_tab"}
            {else if $payment_gateway_status == "yes" && $bitgo_status == "yes" }
                {$active_tab_val="bitgo_tab"}
            {else if $payment_gateway_status == "yes" && $sofort_status == "yes" }
                {$active_tab_val="sofort_tab"}
            {else if $payment_gateway_status == "yes" && $bitcoin_status == "yes" }
                {$active_tab_val="bitcoin_tab"}
            {else if $payment_gateway_status == "yes" && $payeer_status == "yes" }
                {$active_tab_val="payeer_tab"}
            {else if $payment_gateway_status == "yes" && $squareup_status == "yes" }
                {$active_tab_val="squareup_tab"}
            {else if  $bank_transfer_status == 'yes' }
                {$active_tab_val="bank_transfer"}
            {else if  $free_joining_status == 'yes' }
                {$active_tab_val="free_join_tab"}
            {/if}
        {/if}
        
        {if $is_logged_in}
        {if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes"}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='epin_tab'}active{/if}" onclick="changeActiveTab('epin_tab');">
                <h4 class="tabs_h4"><i class="icon-pin"></i></h4>
                    {lang('epin')} 
            </a> 
        {/if}
        {/if}
        {if $payment_ewallet_status== 'yes'}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='ewallet_tab'}active{/if}" onclick="changeActiveTab('ewallet_tab');">
                <h4 class="tabs_h4"><i class="icon-wallet"></i></h4>
                    {lang('ewallet')} 
            </a> 
        {/if}
        {if $bank_transfer_status == "yes" }
            <a href="#" class="list-group-item text-center {if $active_tab_val=='bank_transfer'}active{/if}" onclick="changeActiveTab('bank_transfer');">
                <h4 class="tabs_h4"><i class="fa fa-bank"></i></h4>
                    {lang('bank_transfer')} 
            </a> 
        {/if}
        {if $payment_gateway_status == "yes" && $paypal_status == "yes"}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='paypal_tab'}active{/if}" onclick="changeActiveTab('paypal_tab');">
                <h4 class="tabs_h4"><i class="fa fa-paypal"></i></h4>
                    {lang('paypal')} 
            </a> 
        {/if}
        {if $authorize_status == 'yes'}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='authorize_tab'}active{/if}" onclick="changeActiveTab('authorize_tab');">
                <h4 class="tabs_h4"><i class="icon-lock"></i></h4>
                    {lang('authorize')} 
            </a> 
        {/if}
        {if $payment_gateway_status == "yes" && $bitcoin_status == "yes"}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='bitcoin_tab'}active{/if}" onclick="changeActiveTab('bitcoin_tab');">
                <h4 class="tabs_h4"><i class="fa fa-btc"></i></h4>
                    {lang('blocktrail')} 
            </a> 
        {/if}
        {if $blockchain_status == 'yes'}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='blockchain_tab'}active{/if}" onclick="changeActiveTab('blockchain_tab');">
                <h4 class="tabs_h4"><i class="fa fa-asterisk"></i></h4>
                    {lang('blockchain')} 
            </a> 
        {/if}        
        {if $payment_gateway_status == "yes" && $bitgo_status == "yes"}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='bitgo_tab'}active{/if}" onclick="changeActiveTab('bitgo_tab');">
                <h4 class="tabs_h4"><i class="fa fa-btc"></i></h4>
                    {lang('bitgo')} 
            </a> 
        {/if}
        {if $payment_gateway_status == "yes" && $payeer_status == "yes"}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='payeer_tab'}active{/if}" onclick="changeActiveTab('payeer_tab');">
                <h4 class="tabs_h4"><i class="fa fa-product-hunt"></i></h4>
                    {lang('payeer')} 
            </a> 
        {/if}
        {if $payment_gateway_status == "yes" && $sofort_status == "yes"}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='sofort_tab'}active{/if}" onclick="changeActiveTab('sofort_tab');">
                <h4 class="tabs_h4"><i class="fa fa-euro"></i></h4>
                    {lang('sofort')} 
            </a>
        {/if}
        {if $payment_gateway_status == "yes" && $squareup_status == "yes"}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='squareup_tab'}active{/if}" onclick="changeActiveTab('squareup_tab');">
                <h4 class="tabs_h4"><i class="fa fa-square"></i></h4>
                    {lang('squareup')} 
            </a>
        {/if}
        {if $free_joining_status == 'yes'}
            <a href="#" class="list-group-item text-center {if $active_tab_val=='free_join_tab'}active{/if}" onclick="changeActiveTab('free_join_tab');">
                <h4 class="tabs_h4"><i class="fa fa-cog"></i></h4>
                    {lang('free_join')} 
            </a> 
        {/if}
    {else}  
        {$active_tab_val="free_join_tab"} 
        <a href="#" class="list-group-item text-center {if $active_tab_val=='free_join'}active{/if}" onclick="changeActiveTab('free_join_tab');">
            <h4 class="tabs_h4"><i class="fa fa-cog"></i></h4>
                {lang('free_join')} 
        </a>  
    {/if}        
    </div>
  </div>
  <div class="col-sm-9 bhoechie-tab">
    <input type="hidden" name="active_tab" id="active_tab" value="{$active_tab_val}" >
    <input type="hidden" name="free_join_status" id="free_join_status" value="yes" >
    {if $payment_methods_tab} 
        
        
  <!-- Epin section -->
{if $is_logged_in}
{if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes"}
      <div class="bhoechie-tab-content {if $active_tab_val=='epin_tab'}active{/if}">
                      <div class="content">
                          <div class="panel panel-default">
                              <table class="table table-striped table-bordered table-hover table-full-width overflow_table" id="p_scents" st-table="rowCollectionBasic">
                                  <thead>
                                      <tr align="center">
                                          <th>{lang('sl_no')}</th>
                                          <th>{lang('epin')} </th> 
                                          <th>{lang('epin_amount')}  </th>
                                          <th>{lang('remain_epin_amount')}  </th> 
                                          <th>{lang('req_epin_amount')} </th> 
                                      </tr>
                                  </thead>
                                  <tbody>
                                      {if $pin_count}
                                          {for $i=1 to $pin_count}
                                              <tr   align="center" >
                                                  <td>{$i}</td>  
                                                  <td>
                                          <input type="text" name="epin{$i}" id="epin{$i}" size="20"   autocomplete="Off"   class="form-control rounded width_table" onblur="check_epin_submit();" value="{$reg_post_array["epin{$i}"]}"/>
                                                      <span id="pin_box_{$i}" style="display:none;"></span>
                                                      {if isset($error["epin$i"])}<span class='val-error' >{$error["epin$i"]}</span>{/if}   
                                                  </td>
                                                  <td> 
                                          {$DEFAULT_SYMBOL_LEFT}<input type="text" name="pin_amount{$i}" id="pin_amount{$i}" size="20"   autocomplete="Off"   class="form-control rounded width_table" readonly value="{$reg_post_array["pin_amount{$i}"]}"/> {$DEFAULT_SYMBOL_RIGHT}
                                                      <span id="pin_amount_span" style="display:none;"></span>
                                                  </td>
                                                  <td>
                                          {$DEFAULT_SYMBOL_LEFT}<input type="text" name="remaining_amount{$i}" id="remaining_amount{$i}" size="20"   autocomplete="Off"   class="form-control rounded width_table" readonly value="{$reg_post_array["remaining_amount{$i}"]}"/> {$DEFAULT_SYMBOL_RIGHT}
                                                      <span id="remain_amount_span" style="display:none;"></span>
                                                  </td>
                                                  <td>
                                          {$DEFAULT_SYMBOL_LEFT}<input type="text" name="$i}" id="balance_amount{$i}" size="19"   autocomplete="Off"   class="form-control rounded width_table" readonly value="{$reg_post_array["balance_amount{$i}"]}"/> {$DEFAULT_SYMBOL_RIGHT}
                                                      <span id="balance_amount_span" style="display:none;"></span>                                                            
                                                  </td>
                                              </tr> 
                                          {/for}
                                      {else}
                              <tr align="center" id="epin_raw1">
                                              <td>1</td>  
                                              <td>
                                                  <p style="margin: 0px 0 0px;">
                                          <input  type="text" name="epin1" id="epin1" size="20"   autocomplete="Off"   class="form-control rounded width_table" onblur="check_epin_submit();"/>  
                                                  </p>
                                                  <span id="pin_box_1" style="display:none;"></span>  
                                              </td>
                                              <td> 
                                      <input type="text" name="pin_amount1" id="pin_amount1" size="20"   autocomplete="Off"   class="form-control rounded width_table" readonly/>  
                                                  <span id="pin_amount_span" style="display:none;"></span>                                                       
                                              </td>
                                              <td>
                                      <input type="text" name="remaining_amount1" id="remaining_amount1" size="20"   autocomplete="Off"   class="form-control rounded width_table" readonly/>  
                                                  <span id="remain_amount_span" style="display:none;"></span>
                                              </td>
                                              <td>
                                      <input type="text" name="balance_amount1" id="balance_amount1" size="19"   autocomplete="Off"   class="form-control rounded width_table" readonly/>  
                                                  <span id="balance_amount_span" style="display:none;"></span>                                                        
                                              </td>
                                          </tr>
                                      {/if}
                                  </tbody>
                              </table>
                          </div>
                      <div class="pull-left">
                          <div class="form-group line_block">
                              <label  class="bg_color_none" >{lang('total_amount')}</label>
                              <input type="text" name="epin_total_amount" id="epin_total_amount" size="20"   autocomplete="Off"   class="form-control"  readonly {if isset($reg_post_array["epin_total_amount"])}value="{$reg_post_array["epin_total_amount"]}"{/if}/>  
                              <span id="epin_total_amount_span" style="display:none;"></span>
                          </div>
                          <div class="form-group line_block"  id="validate_epin_div">
                              <button type="button" class="btn m-b-xs btn-primary validate_e_pin" id ="pin_btn" name= "pin_btn" onclick="validate_epin();">{lang('epin_val')}</button>
                          </div>
                      </div>
                  </div> 
        </div>  
{/if}
{/if} 
<!-- Ewallet section -->
{if $payment_ewallet_status== 'yes'}
    <div class="bhoechie-tab-content {if $active_tab_val=='ewallet_tab'}active{/if}">
        <div class="content">
                <div class="form-group">
                    <label class="bg_color_none" >{lang('User_Name')}<font color="#ff0000">*</font></label>
                    <input type="text" class="form-control" id="user_name_ewallet" name="user_name_ewallet"  title="{lang('User_Name')}" class="form-control" autocomplete="off"/>    
                    <span id="user_name_ewallet_box" style="display:none;"  class="help-block m-b-none"></span>
                    {if isset($error['user_name_ewallet'])}<span class='val-error' >{$error['user_name_ewallet']} </span>{/if}
                </div>

                    <div class="form-group">
                        <label class="bg_color_none">{lang('transaction_password')}<font color="#ff0000">*</font></label>
                        <input type="password" class="form-control" id="tran_pass_ewallet" name="tran_pass_ewallet" title="{lang('transaction_password')}" class="form-control" autocomplete="off"/>  
                        <span id="tran_pass_ewallet_box" style="display:none;" class="help-block m-b-none"></span>
                        {if isset($error['tran_pass_ewallet'])}<span class='val-error' >{$error['tran_pass_ewallet']} </span>{/if}
                    </div>                    
                    <div class="form-group">
                        <div id="check_ewallet_button">
                            <button type="button" id="ewallet_btn" name="ewallet_btn" class="btn btn-primary  update_social_info-submit" onclick="validate_ewallet();">{lang('check_availability')}</button>
                        </div> 
                    </div>
        </div>
    </div>
{/if}  
  
<!-- Bank section -->
{if $bank_transfer_status== 'yes'}
    <div class="bhoechie-tab-content bank {if $active_tab_val=='bank_transfer'}active{/if}">
        <div class="content">
            <div class="form-group">
                <label class="no_bg_clr">{lang('select_reciept')} <font color="#ff0000">*</font></label>
                <input class="m-b-xs padding_center" id="userfile" name="userfile" accept="image/*" type="file">  
                <p style="color: #ff0000;">({lang('Allowed_types_are_pg_jpeg_png')})</p>       
                <img class="m-i-xs" id="img_prev" src="#" alt=""/>
                <a href="#" class="btn btn-light-grey btn-file fileupload-exists" data-dismiss="fileupload" id="remove_id" style="display:none;">
                    <i class="fa fa-times"></i> {lang('remove')}
                </a>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-addon m-b-xs btn-info update_profile_image" id="update_profile_image"> <i class="fa fa-arrow-circle-o-up"></i> {lang('upload')} </button>
            </div>
            </div>
    </div>
{/if}

<!-- Paypal section -->
{if $paypal_status == "yes"} 
    <div class="bhoechie-tab-content {if $active_tab_val=='paypal_tab'}active{/if}">
        <div class="content">
            <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
        </div>
    </div>
{/if}

<!-- Authorize.net section -->
{if $authorize_status == "yes"} 
    <div class="bhoechie-tab-content {if $active_tab_val=='authorize_tab'}active{/if}">
        <div class="content">
            <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
        </div>
    </div>
{/if}


<!-- Bitcoin section -->
{if $bitcoin_status == "yes"}  
    <div class="bhoechie-tab-content {if $active_tab_val=='bitcoin_tab'}active{/if}">
        <div class="content">
            <div class="form-group">
            {if DEMO_STATUS == 'yes'}
                <div class="content">
                    <pre class="alert alert-info">{lang('blocktrail_only_in_live')}</pre>
                </div>
            {else}
                <label class="no_bg_clr">{lang('bitcoin_address')} <font color="#ff0000">*</font></label>
                <input type="text" name="bitcoin_address" id="bitcoin_address" autocomplete="Off"  class="form-control"{if isset($reg_post_array['bitcoin_address'])} value="{$reg_post_array['bitcoin_address']}" {/if} >
                {if isset($error['bitcoin_address'])}<span class='val-error' >{$error['bitcoin_address']} </span>{/if}
            {/if}   
            </div>
        </div>
    </div>
{/if} 

{if $blockchain_status == 'yes'}                
    <div class="bhoechie-tab-content {if $active_tab_val=='blockchain_tab'}active{/if}">
        <div class="content">
            <pre class="alert alert-info">{lang('blockchain_only_in_live')}</pre>
        </div>
    </div>
{/if}

{if $bitgo_status == "yes"} 
    <div class="bhoechie-tab-content {if $active_tab_val=='bitgo_tab'}active{/if}">
        <div class="content">
            <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
        </div>
    </div> 
{/if}
{if $payeer_status == "yes"}
    <div class="bhoechie-tab-content {if $active_tab_val=='payeer_tab'}active{/if}">
        <div class="content">
            <pre class="alert alert-info">{lang('payeer_only_in_live')}</pre>
        </div>
    </div>
{/if}
{if $sofort_status == "yes"} 
    <div class="bhoechie-tab-content {if $active_tab_val=='sofort_tab'}active{/if}">
        <div class="content">
            <pre class="alert alert-info">{lang('sofort_only_in_live')}</pre>
        </div>
    </div> 
{/if}
{if $squareup_status == "yes"}
    <div class="bhoechie-tab-content {if $active_tab_val=='squareup_tab'}active{/if}">
        <div class="content">
            <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
        </div>
    </div>
{/if}
{if $free_joining_status == 'yes'}
    <div class="bhoechie-tab-content {if $active_tab_val=='free_join_tab'}active{/if}">
        <div class="content">
            <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
        </div>
    </div>
{/if}
{else}
        <div class="bhoechie-tab-content active">
            <div class="content">
                <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
            </div>

        </div>
{/if}
</div>
</div>
 
<input type="button" name="previous" class="previous action-button-previous" value="{lang('previous')}"/>
<input type="submit" name="submit" class="submit action-button sw-btn-finish" value="{lang('finish')}"/>
</fieldset>
  {form_close()}
<!-- link to designify.me code snippets -->
</div>
 
<div id="alert_div" style="display: none;">
    <div id="err_reciept" class="alert alert-dismissable text-left">
        <a href="#" style="display:block !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
</div>
<div id="div_pos" style="display: none;">
    <option value="">{lang('select_leg')}</option>
    <option value="L">{lang('left_leg')}</option>
    <option value="R">{lang('right_leg')}</option>
</div>

<div class="modal terms" id="panel-config" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                  &times;
              </button>
              <h4 class="modal-title" style="font-size: 16px;">{lang('terms_conditions')}</h4>
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

      </div>
  </div>
</div> 
{/block}

 {block name=style}
  {$smarty.block.parent}
<link rel="stylesheet" href="{$PUBLIC_URL}theme/css/user_tab.css" type="text/css" />
{/block}
 {block name=script}
  {$smarty.block.parent} 
<script src="{$PUBLIC_URL}theme/js/tabs_new.js"></script>
<script src="{$PUBLIC_URL}javascript/epin_register.js" type="text/javascript" ></script>
{/block}
