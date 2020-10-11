{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    {if $from_replica}
        {include file="layout/alert_box.tpl"}
    {/if}

    <div class="button_back"> 
        {if $MLM_PLAN != "Board"}
            {if $LOG_USER_ID && !$from_replica}
                <a href="{$PATH_TO_ROOT}{$user_type}/tree/genology_tree" style="text-decoration:none">
                    <button class="btn m-b-xs btn-sm btn-primary">
                        {lang('go_to_tree_view')}
                    </button>
                </a>
            {/if}
        {else}
            {if $LOG_USER_ID && !$from_replica}
                <a href="{$PATH_TO_ROOT}{$user_type}/boardview/view_board_details" style="text-decoration:none">
                    <button class="btn m-b-xs btn-sm btn-primary">
                        {lang('Club_View')}
                    </button>
                </a>
            {/if}
        {/if}
        <a href="" onclick="print_report(); return false;"> 
            <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="icon-printer"></i>{lang('Print')}</button>
        </a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body" id="print_area">
            <div class="row">
                <div class="img">
                    <div class="col-sm-6"> <img src="{$SITE_URL}/uploads/images/logos/{$site_info["logo"]}" /> </div>
                </div>
                <div class="col-sm-6 text-right">
                    <p> {$site_configuration['company_name']}</p>
                    <p> {$site_configuration['company_address']}</p>
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table st-table="rowCollectionBasic" class="table table-bordered table-striped ">
                            <tbody>
                                <tr>
                                    <td  class="user_table_width"><strong>{lang('User_Name')}</strong></td>
                                    <td class="mobile_text_left">{$user_registration_details['user_name']} </td>
                                </tr>
                                <tr>
                                    <td><strong>{lang('fullname')}</strong></td>
                                    <td class="mobile_text_left">{$user_registration_details['first_name']} {$user_registration_details['last_name']}</td>
                                </tr>
                                <tr>
                                    <td><strong>{lang('phone_number')}</strong></td>
                                    <td class="mobile_text_left">{$user_registration_details['mobile']}</td>
                                </tr>
                                <tr>
                                    <td><strong>{lang('email')}</strong></td>
                                    <td class="mobile_text_left">{$user_registration_details['email']}</td>
                                </tr>
                                <tr>
                                    <td><strong>{lang('date_of_joining')}</strong></td>
                                    <td class="mobile_text_left">{$user_registration_details['reg_date']}</td>
                                </tr>
                                {if $user_registration_details['reg_amount']>0}
                                    <tr>
                                        <td><strong>{lang('registration_amount')}</strong></td>
                                        <td class="mobile_text_left"> {$DEFAULT_SYMBOL_LEFT}{number_format($user_registration_details['reg_amount']*$DEFAULT_CURRENCY_VALUE,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                {/if}
                                {if $MODULE_STATUS['product_status'] == "yes"}
                                    <tr>
                                        <td><strong>{lang('package')}</strong></td>
                                        <td class="mobile_text_left">{$user_registration_details['product_name']}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{lang('package_amount')}</strong></td>
                                        <td class="mobile_text_left">{$DEFAULT_SYMBOL_LEFT}{round($user_registration_details['product_amount']/$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                {/if}
                                {if $referal_status == "yes"}
                                    <tr>
                                        <td><strong>{lang('sponsor')}</strong></td>
                                        <td class="mobile_text_left">{$sponsorname}</td>
                                    </tr>
                                {/if}
                                {if !$is_pending_registration}
                                    <tr>
                                        <td><strong>{lang('Placment_ID')}</strong></td>
                                        <td class="mobile_text_left">{$placement_user_name}</td>
                                    </tr>
                                {/if}
                                {if $FOOTER_DEMO_STATUS=="yes"}
                                    <tr>
                                        <td><strong>{lang('Login_Link')}</strong></td>
                                        <td class="mobile_text_left"> 
                                            {if $DEMO_STATUS == "yes"}
                                                {$PATH_TO_ROOT}login/index/user/{$admin_user_name}/{$user_name}
                                            {else}
                                                {$PUBLIC_VARS['USER_URL']}/login/index/{$user_name_encrypted}
                                            {/if} 
                                        </td>
                                    </tr>
                                {/if}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="well m-t bg-light lt"> 
                {$letter_arr['main_matter']}
                <br />
                {lang('winning_regards')},<br />
                <br />
                {lang('admin')}<br />
                <br />
                {$site_configuration['company_name']} <br />
                <br />
                {lang('date')}<br />
                {$date} <br />
            </div>
        </div>
    </div>
{/block}