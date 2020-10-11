{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<main>
    <div id="span_js_messages" style="display: none;">
        <span id="error_msg">{lang('please_select_at_least_one_checkbox')}</span>
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span>
        <span id="show_msg1">{lang('are_you_sure_you_want_to_Delete_There_is_NO_undo')}</span>
        <span id="show_msg2">{lang('digits_only')}</span>
        <span id="err_msg1">{lang('main_password_required')}</span>
        <span id="err_msg2">{lang('second_password_required')}</span>
        <span id="err_msg3">{lang('wallet_id_required')}</span>
        <span id="err_msg4">{lang('passphrase_required')}</span>
        <span id="err_msg5">{lang('wallet_name_required')}</span>
        <span id="err_msg6">{lang('wallet_password_required')}</span>
        <span id="otp_err1">{lang('you_must_enter_otp')} </span>
        <span id="otp_err2">{lang('otp_is_numeric')} </span>
    </div>
    <div class="tabsy">
        <input type="hidden" id="checkAll" type="submit" value="Check All"> {if $MODULE_STATUS['payout_release_status']=="both"}
        <input type="radio" id="tab1" name="tab" {if $tab1}checked{/if}>
        <label class="tabButton" for="tab1">{lang('from_e_wallet')}</label>
        <div class="tab">
            <div class="content">
            <div class="m-b pink-gradient">
                <div class="card-body ">
                    <div class="media">
                        <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
                        <div class="media-body">
                            <h6 class="my-0">Shows the list of payout based on user's ewallet balance. Admin can pay the amount by choosing a payout method. </h6>
                        </div>
                    </div>
                </div>
            </div>
                {form_open('/admin/post_payout_release', 'name="ewallet_form_det" class="" id="ewallet_form_det" method="post" ')} {if $count1>0}
                <input type="hidden" name="current_tab" id="current_tab" value="tab1">
                <input type='hidden' name="table_rows" value="{$count1}">
                <input type="hidden" id="payment_method" name="payment_method" value="{$payment_type}">
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('user_full_name')}</th>
                                <th>{lang('balance_amount')}</th>
                                <th>{lang('Payout_Amount')}</th>
                                <th>{lang('payout_type')}</th>
                                <th class="check_all">{lang('check')}/<a class="cursor" type="submit" name="check_all_tab1" value="Check All" id="check_all_tab1">{lang('check_all')}</a></th>
                                <th>{lang('view_user_data')}</th>
                            </tr>
                        </thead>
                        {assign var="i" value=0}{assign var="path" value="{$BASE_URL}admin/"}
                        <tbody>
                            {foreach from=$payout_details1 item="v"}
                            <tr>
                                <td>{$start1++}
                                    <input type='hidden' name='request_id{$i}' value='{$v.req_id}'>
                                    <input type='hidden' name='user_name{$i}' value='{$v.user_name}'>
                                    <input type='hidden' name='balance_amount{$i}' value='{$v.balance_amount}'>
                                    <input type='hidden' name='requested_date{$i}' value='{$v.requested_date}'>
                                    <input type='hidden' name='payout_amount{$i}' value='{$v.payout_amount}'>
                                </td>
                                <td>{$v.user_name} </td>
                                <td>{$v.full_name}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                <td>
                                    <div class="input_width">
                                        <div class="input-group"> {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                                            <input type="text" class="payout_amount form-control" name="payout{$i}" id="payout_amount{$i}" value="{round($v.payout_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" {if $MODULE_STATUS[ 'payout_release_status']!="ewallet_request" }{/if}/>
                                        </div>
                                    </div>
                                    <span id="errmsg1"></span>
                                </td>
                                <td>{$v.payout_type|ucfirst}</td>
                                <td>
                                    <div class="checkbox">
                                        <label class="i-checks">
                      <input type="checkbox" name="release_tab1{$i}" id="release_tab1{$i}" class="release release_tab1">
                      <i> </i></label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" title="View" class="btn-link btn-xs text-info" onclick="view_popup('{$v.user_name}', this.parentNode.parentNode.rowIndex, 'admin', '{$path}')" data-toggle="modal" data-target="#panel-config"><i class="fa fa-eye"></i></button></td>
                            </tr>
                            {$i=$i+1} {/foreach}
                        </tbody>
                    </table>{$result_per_page1}
                </div>
                <div class="payment f-Blockchain" {if $payment_type !='Blockchain' }style="display:none;" {/if}>
                <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>
                     

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="main_password">{lang('main_password')}</label>
                            <input class="form-control" type="password" name="main_password" id="main_password" value="" title="">
                            <span id="errmsg3"></span> {form_error('main_password')}
                        </div>
                    </div>
                    <div class=" form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="second_password">{lang('second_password')}</label>
                            <input class="form-control" type="password" name="second_password" id="second_password" value="" title="">
                            <span id="errmsg3"></span> {form_error('second_password')}
                        </div>
                    </div>

                </div>
                <div class="payment f-Bitgo" {if $payment_type !='Bitgo' }style="display:none;" {/if}>
                   <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class=" control-label required" for="wallet_id">{lang('wallet_id')}</label>
                            <input class="form-control" type="text" name="wallet_id" id="wallet_id" value="" title="">
                            <span id="errmsg3"></span> {form_error('wallet_id')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="passphrase">{lang('passphrase')}</label>
                            <input class="form-control" type="password" name="passphrase" id="passphrase" value="" title="">
                            <span id="errmsg3"></span> {form_error('passphrase')}
                        </div>
                    </div>
                </div>
                <div class="payment f-Bitcoin" {if $payment_type !='Bitcoin' }style="display:none;" {/if}>
                    <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="wallet_name">{lang('wallet_name')}</label>
                            <input class="form-control" type="text" name="wallet_name" id="wallet_name" value="" title="">
                            <span id="errmsg3"></span> {form_error('wallet_name')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_password">{lang('wallet_password')}</label>
                            <input class="form-control" type="password" name="wallet_password" id="wallet_password" value="" title="">
                            <span id="errmsg3"></span> {form_error('wallet_password')}
                        </div>
                    </div>
                </div>
                <div>
                <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                    <input type="hidden" value='release_payout_tab1' name='release_payout'>
                    <button class="btn btn-sm btn-primary mark_paid" name="release_payout_tab1" id="release_payout_tab1" type="button" value="release_payout"> {lang('release')} </button>
                </div>
                </div>
                </div>
                {else}
                <h4 align="center">{lang('no_payout_found')}</h4>
                {/if} {form_close()}
            </div>
            
        </div>
        <input type="radio" id="tab2" name="tab" {if $tab2}checked{/if}>
        <label class="tabButton" for="tab2">{lang('e_wallet_request')}</label>
        <div class="tab">
            <div class="content">
            
            <div class="m-b pink-gradient">
                <div class="card-body ">
                    <div class="media">
                        <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
                        <div class="media-body">
                            <h6 class="my-0">Shows the list of payout requests. Admin can pay the amount by choosing a payout method or reject payout request.</h6>
                        </div>
                    </div>
                </div>
            </div>
                {form_open('/admin/post_payout_release', 'name="ewallet_form_det" class="" id="ewallet_form_det2" method="post"')} {if $count2>0}
                <input type="hidden" name="current_tab" id="current_tab" value="tab2">
                <input type='hidden' name="table_rows" value="{$count2}">
                <input type="hidden" id="payment_method" name="payment_method" value="{$payment_type}">
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')} </th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('user_full_name')}</th>
                                <th>{lang('balance_amount')}</th>
                                <th>{lang('Payout_Amount')}</th>
                                <th>{lang('payout_type')}</th>
                                <th class="check_all">{lang('check')}/<a class="cursor" type="submit" name="check_all_tab2" value="Check All" id="check_all_tab2">{lang('check_all')}</a></th>
                                <th>{lang('delete')}</th>
                                <th>{lang('view_user_data')}</th>
                            </tr>
                        </thead>
                        {assign var="i" value=0}{assign var="path" value="{$BASE_URL}admin/"}
                        <tbody>
                            {foreach from=$payout_details2 item="v"}
                            <tr>
                                <td>{$start2++}
                                    <input type='hidden' name='request_id{$i}' value='{$v.req_id}'>
                                    <input type='hidden' name='user_name{$i}' value='{$v.user_name}'>
                                    <input type='hidden' name='balance_amount{$i}' value='{$v.balance_amount}'>
                                    <input type='hidden' name='requested_date{$i}' value='{$v.requested_date}'>
                                    <input type='hidden' name='payout_amount{$i}' value='{$v.payout_amount}'>
                                </td>
                                <td>{$v.user_name}</td>
                                <td>{$v.full_name}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                <td>
                                    <div class="input_width">
                                        <div class="input-group">{if $DEFAULT_SYMBOL_LEFT} <span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span> {/if}
                                             <input type="text" class="form-control" name="payout{$i}" id="payout_amount{$i}" value="{round($v.payout_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" {if $MODULE_STATUS[ 'payout_release_status']!="ewallet_request" }{/if}/>
                                        </div>
                                    </div>
                                </td>
                                <td>{$v.payout_type|ucfirst}</td>
                                <td>
                                    <div class="checkbox">
                                        <label class="i-checks">
                      <input type="checkbox" name="release_tab2{$i}" id="release_tab2{$i}" class="release_tab2 release" />
                      <i></i> </label>
                                    </div>
                                </td>
                                <td><button type="button" onclick="delete_request('{$v.req_id}','{$path}','{$v.user_name}','{$v.payout_type}')" class="btn-link text-danger"> <i class="fa fa-trash-o"> </i> </button></td>
                                <td>
                                    <button type="button" title="View" class="btn-link text-info" onclick="view_popup('{$v.user_name}', this.parentNode.parentNode.rowIndex, 'admin', '{$path}')" data-toggle="modal" data-target="#panel-config"><i class="fa fa-eye"></i></button>

                                </td>
                            </tr>
                            {$i=$i+1} {/foreach}
                        </tbody>
                    </table>{$result_per_page2}
                </div>
                <div class="payment2 s-Blockchain" {if $payment_type !='Blockchain' }style="display:none;" {/if}>
                   <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="main_password">{lang('main_password')}</label>
                            <input class="form-control" type="password" name="main_password" id="main_password" value="" title="">
                            <span id="errmsg3"></span> {form_error('main_password_2')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="second_password">{lang('second_password')}</label>
                            <input class="form-control" type="password" name="second_password" id="second_password" value="" title="">
                            <span id="errmsg3"></span> {form_error('second_password_2')}
                        </div>
                    </div>

                </div>
                <div class="payment2 s-Bitgo" {if $payment_type !='Bitgo' }style="display:none;" {/if}>
                  <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="wallet_id">{lang('wallet_id')}</label>
                                <input class="form-control" type="text" name="wallet_id" id="wallet_id" value="" title="">
                                <span id="errmsg3"></span> {form_error('wallet_id_2')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="passphrase">{lang('passphrase')}</label>
                                <input class="form-control" type="password" name="passphrase" id="passphrase" value="" title="">
                                <span id="errmsg3"></span> {form_error('passphrase_2')}
                        </div>
                    </div>
                </div>
                <div class="payment2 s-Bitcoin" {if $payment_type !='Bitcoin' }style="display:none;" {/if}>
                   <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="wallet_name">{lang('wallet_name')}</label>
                                <input class="form-control" type="text" name="wallet_name" id="wallet_name" value="" title="">
                                <span id="errmsg3"></span> {form_error('wallet_name_2')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_password">{lang('wallet_password')}</label>
                                <input class="form-control" type="password" name="wallet_password" id="wallet_password" value="" title="">
                                <span id="errmsg3"></span> {form_error('wallet_password_2')}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                 <div class="col-sm-4 padding_both_small">
                    <input type="hidden" value='release_payout_tab2' name='release_payout'>
                    <button class="btn btn-sm btn-primary mark_paid" name="release_payout_tab2" id="release_payout_tab2" type="button" value="release_payout"> {lang('release')} </button>
                </div>
                </div>
                {else}
                <h4 align="center">{lang('no_payout_found')}</h4>
                {/if} {form_close()}
            </div>

        </div>
        {else}
        <input type="radio" id="tab1" name="tab" checked>
        <label class="tabButton" for="tab1">{$tab_title}</label>
        <div class="tab">
            <div class="content">
             <div class="m-b pink-gradient ">
                <div class="card-body ">
                    <div class="media ">
                        <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
                        <div class="media-body ">
                            <h6 class="my-0 ">Shows the list of payout based on user's ewallet balance. Admin can pay the amount by choosing a payout method. </h6>
                        </div>
                    </div>
                </div>
            </div>
                {form_open('/admin/post_payout_release', 'name="ewallet_form_det" class="" id="ewallet_form_det" method="post" ')} {if $count>0}
                <input type="hidden" id="payment_method" name="payment_method" value="{$payment_type}">
                <input type='hidden' name="table_rows" value="{$count}">
                <div class="panel panel-default table-responsive">


                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('user_full_name')}</th>
                                <th>{lang('balance_amount')}</th>
                                <th>{lang('Payout_Amount')}</th>
                                <th>{lang('payout_type')}</th>
                                <th class="check_all">{lang('check')}/<a class="cursor" type="submit" name="check_all" value="Check All" id="check_all" onclick="checkAll();">{lang('mark_all')}</a>
                                    <a class="cursor" type="submit" name="uncheck_all" value="Uncheck All" id="uncheck_all" onclick="uncheckAll();" style="display:none;">{lang('unmark_all')}</a></th>
                                {if $MODULE_STATUS['payout_release_status']=="ewallet_request"}
                                <th>{lang('delete')}</th>
                                {/if}
                                <th>Last Successful Payout</th>
                                <th>{lang('view_user_data')}</th>
                                <th>Registered with Payeer</th>
                            </tr>
                        </thead>
                        {assign var="i" value=0} {assign var="path" value="{$BASE_URL}admin/"}
                        <tbody>
                            {foreach from=$payout_details item="v"}

                            <tr>
                                <td>{$start++}
                                    <input type='hidden' name='request_id{$i}' value='{$v.req_id}'>
                                    <input type='hidden' name='user_name{$i}' value='{$v.user_name}'>
                                    <input type='hidden' name='balance_amount{$i}' value='{$v.balance_amount}'>
                                    <input type='hidden' name='requested_date{$i}' value='{$v.requested_date}'>
                                    <input type='hidden' name='payout_amount{$i}' value='{$v.payout_amount}'>
                                </td>
                                <td>{$v.user_name} </td>
                                <td>{$v.full_name}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                <td>
                                    <div class="input_width">
                                        <div class="input-group"> {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                                            <input type="text" class="payout_amount form-control" name="payout{$i}" id="payout_amount{$i}" value="{round($v.commision_details*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" {if $MODULE_STATUS[ 'payout_release_status' ]!="ewallet_request" }{/if}/> </div>
                                    </div>
                                    <span id="errmsg1"></span>
                                </td>
                                <td>{$v.payout_type|ucfirst}</td>
                                <td>
                                    <div class="checkbox">
                                        <label class="i-checks">
                                            <input type="checkbox" name="release{$i}" id="release{$i}" class="release">
                                            <i> </i></label>
                                    </div>
                                </td>
                                {if $MODULE_STATUS['payout_release_status']=="ewallet_request"}
                                <td><button type="button" onclick="delete_request('{$v.req_id}','{$path}','{$v.user_name}','{$v.payout_type}')" class="btn btn-xs btn-danger">
                                            <i class="fa fa-times"> </i> </button></td>
                                {/if}
                                <td>Probably today lol</td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-info" title="View" onclick="view_popup('{$v.user_name}', this.parentNode.parentNode.rowIndex, 'admin', '{$path}')" data-toggle="modal" data-target="#panel-config" style='color:#000;'><i class="fa fa-eye"></i></button>

                                </td>
                                
                                <td>{$v.valid_payeer_account}</td> 
                            </tr>
                            {$i=$i+1} {/foreach}
                        </tbody>
                    </table>{$result_per_page}
                </div>
                <div class="payment f-Blockchain" {if $payment_type !='Blockchain' }style="display:none;" {/if}>
                    <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="main_password">{lang('main_password')}</label>
                                <input class="form-control" type="password" name="main_password" id="main_password" value="" title="">
                                <span id="errmsg3"></span> {form_error('main_password')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="second_password">{lang('second_password')}</label>
                                <input class="form-control" type="password" name="second_password" id="second_password" value="" title="">
                                <span id="errmsg3"></span> {form_error('second_password')}
                        </div>
                    </div>

                </div>
                <div class="payment f-Bitgo" {if $payment_type !='Bitgo' }style="display:none;" {/if}>
                    <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_id">{lang('wallet_id')}</label>
                                <input class="form-control" type="text" name="wallet_id" id="wallet_id" value="" title="">
                                <span id="errmsg3"></span> {form_error('wallet_id')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="passphrase">{lang('passphrase')}</label>
                                <input class="form-control" type="password" name="passphrase" id="passphrase" value="" title="">
                                <span id="errmsg3"></span> {form_error('passphrase')}
                        </div>
                    </div>
                </div>
                <div class="payment f-Bitcoin" {if $payment_type !='Bitcoin' }style="display:none;" {/if}>
                      <legend><span class="fieldset-legend">{lang('account_details')}</span></legend>

                    <div class=" form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_name">{lang('wallet_name')}</label>
                                <input class="form-control" type="text" name="wallet_name" id="wallet_name" value="" title="">
                                <span id="errmsg3"></span> {form_error('wallet_name')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_password">{lang('wallet_password')}</label>
                                <input class="form-control" type="password" name="wallet_password" id="wallet_password" value="" title="">
                                <span id="errmsg3"></span> {form_error('wallet_password')}
                        </div>
                    </div>
                </div>
                 
                <div class="form-group" style="min-height:100px !important;">
                        <div class="col-sm-4 padding_both_small">
                    <input type="hidden" value='release_payout' name='release_payout'>
                    <button class="btn btn-sm btn-primary mark_paid" name="release_payout" id="release_payout" type="button" value="release_payout"> {lang('release')} </button>
                </div>
                </div>
                {else}
                <h4 align="center ">{lang('no_payout_found')}</h4>
                {/if} {form_close()}
            </div>
           
        </div>
        {/if}
    </div>
    {include file="layout/otp_modal.tpl"}
    <div id='transaction' type="hidden">
        <div class="modal fade " id='panel-config' tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title">{lang('user_details')}</h4>
                </div>
                    <div class="modal-body">
                        <div id='div1'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{/block}