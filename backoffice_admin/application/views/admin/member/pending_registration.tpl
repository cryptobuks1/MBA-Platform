{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
    <span id="msg1">{lang('pending_registration_approval_confirm')}</span>
    <span id="error_msg">{lang('please_select_at_least_one_checkbox')}</span>
</div>

 <div class="m-b pink-gradient">
        <div class="card-body ">
            <div class="media">
                <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
                <h6 class="my-0">{lang('note_signup_approval')}</h6>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
    <div class="panel-body">
        {form_open('admin/approve_registration', 'name="pending_reg" class="" id="pending_reg" method="post"')}
    <input type="hidden" id="details" value='{json_encode($pending_registration_list)}'>
{if count($pending_registration_list)}
    <div class="panel panel-default table-responsive ng-scope">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('name')}</th>
                    <th>{lang('sponser_name')}</th>
                    <th>{lang('mobile')}</th>
                    <th>{lang('email')}</th>
                        {if $MODULE_STATUS['product_status'] == 'yes'}
                        <th>{lang('package')}</th>
                        {/if}
                    <th>{lang('total_amount')}</th>
                    <th>{lang('payment_method')}</th>
                    <th>{lang('view_reciept')}</th>
                    <th>{lang('check')}/<a class="cursor" type="submit" name="check_all" value="Check All" id="check_all" >{lang('check_all')}</a></th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="i" value=1}
                {foreach from = $pending_registration_list key = k item = v}
                    <tr>
                        <td>{$page_id + $i}</td>
                        <td>{$v['user_name']}</td>
                        <td>{$v['first_name']} {$v['last_name']}</td>
                        <td>{$v['sponsor_user_name']}</td>
                        <td>{$v['mobile']}</td>
                        <td>{$v['email']}</td>
                        {if $MODULE_STATUS['product_status'] == 'yes'}
                            <td>{$v['package_name']}</td>
                        {/if}
                        <td>{$DEFAULT_SYMBOL_LEFT}{($v['total_amount']*$DEFAULT_CURRENCY_VALUE)|round:$PRECISION}{$DEFAULT_SYMBOL_RIGHT}</td>
                        <td>{lang($v['payment_method'])}</td>
                        <td>{if $v['payment_method'] == 'bank_transfer'}<a class="btn btn-default"  style="background-color: #e7e7e7;" href="javascript:mym('{SITE_URL}/uploads/images/reciepts/{$v['reciept']}')"><img class="img-responsive"  src="{SITE_URL}/uploads/images/reciepts/{$v['reciept']}"alt=""/><i class="clip-target"></i></a>{else}NA{/if}</td>
                        
                        <td>
                            <div class="checkbox">
                                <label class="i-checks">
                                    <input type="checkbox" name="release[]" id="release{$i}" class="release" value="{$v['user_name']}"/><i> </i>
                                </label>
                            </div>
                        </td>
                        <td>
                            <a class="btn-link btn-sm btn-icon text-primary" title="More Details" data-toggle="modal" data-key="{$k}" data-target="#user_detail_modal">
                                <i class="fa fa-eye"></i>
                            </a>
                    </tr>
                    {$i = $i + 1}
                {/foreach}
            </tbody>
        </table>
        </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary approve" name="confirm_registr" id="confirm_registr" type="submit" value="confirm_registr"> {lang('approve')} </button>
            </div>
            </div>
    {else}
        <h4 class="text-center">{lang('no_data')}</h4>
    {/if}                                
    {form_close()}
    <div class="row">
        <div class="col-sm-12">
            {$result_per_page}
        </div>
    </div>


    <div id="user_detail_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{lang('user_info')}: <span class="user_name"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2">{lang('sponsor_package_info')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{lang('user_name')}:</td>
                                        <td class="user_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('sponsor_user_name')}:</td>
                                        <td class="sponsor_user_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('sponsor_full_name')}:</td>
                                        <td class="sponsor_full_name"></td>
                                    </tr>
                                    {if $MODULE_STATUS['product_status'] == 'yes'}
                                        <tr>
                                            <td>{lang('package')}:</td>
                                            <td class="package"></td>
                                        </tr>
                                    {/if}
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2">{lang('personal_info')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{lang('first_name')}:</td>
                                        <td class="first_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('last_name')}:</td>
                                        <td class="last_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('gender')}:</td>
                                        <td class="gender"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('date_of_birth')}:</td>
                                        <td class="date_of_birth"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2">{lang('contact_info')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{lang('address_line1')}:</td>
                                        <td class="address_line1"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('address_line2')}:</td>
                                        <td class="address_line2"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('country')}:</td>
                                        <td class="country"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('state')}:</td>
                                        <td class="state"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('city')}:</td>
                                        <td class="city"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('zip_code')}:</td>
                                        <td class="zip_code"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('email')}:</td>
                                        <td class="email"></td>
                                    </tr><tr>
                                        <td>{lang('mobile')}:</td>
                                        <td class="mobile"></td>
                                    </tr><tr>
                                        <td>{lang('landline')}:</td>
                                        <td class="landline"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2">{lang('bank_info')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{lang('account_holder')}:</td>
                                        <td class="account_holder"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('bank_name')}:</td>
                                        <td class="bank_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('branch_name')}:</td>
                                        <td class="branch_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('account_number')}:</td>
                                        <td class="account_number"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('ifsc_code')}:</td>
                                        <td class="ifsc_code"></td>
                                    </tr>
                                    <tr>
                                        <td>{lang('pan')}:</td>
                                        <td class="pan"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="EnSureModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                </div>
                <div class="modal-body" style="text-align:center;width:100%">
                    <img id="im" src="">
                    <!--                <p style="text-align:left;"id="des"></p>-->
                </div>
                <div class="form-group m-l">
                 
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{lang('close')}</button>
                 
                </div>
            </div>
        </div>
    </div>
    

</div>

   
{/block}