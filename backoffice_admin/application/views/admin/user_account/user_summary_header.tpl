<legend>
	<span class="fieldset-legend">{lang('user_overview')}</span>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        <!-- <div class="app-header-fixed"></div> -->
        <div class="row">
            <div class="col-sm-12">
                <div class="user_account-user-details-container">
                    <div class="user_account-user-img b b-3x">
                            <img src="{$SITE_URL}/uploads/images/profile_picture/{$file_name}" class="">
                    </div>
                    <div class="user_account-user-details">
                        <div class="user_account-user-details1">
                            <span>{lang('user_name')} </span> : &nbsp; 
                            {$user_name}
                        </div>
                        <div class="user_account-user-details1">
                            <span>{lang('first_name')} </span> : &nbsp; 
                            {$user_detail['name']}
                        </div>
                        <!-- <div class="user_account-user-details1">
                            <span>{lang('last_name')} </span> : &nbsp; 
                            {$user_detail['second_name']}
                        </div> -->

                    </div>                            
                </div>
            </div>    

            <!-- <div class="col-sm-8 col-sm-offset-2">
                <div class="panel b-a">
                    <div class="text-center m-b clearfix">
                        <div class="thumb-lg avatar m-t-n-xxl">
                            <img src="{$SITE_URL}/uploads/images/profile_picture/{$file_name}" class="b b-3x">
                    
                        </div>
                    </div>
                    <div class="panel panel-default table-responsive">
                        <table st-table="rowCollectionBasic" class="table table-bordered table-striped no-border">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="user_table_width">{lang('user_name')}</td>
                                    <td class="user_table_width">{$user_name}</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width">{lang('first_name')}</td>
                                    <td class="user_table_width">{$user_detail['name']}</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width">{lang('last_name')}</td>
                                    <td class="user_table_width">{$user_detail['second_name']}</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width">{lang('date_of_birth')}</td>
                                    <td class="user_table_width">{$user_detail['dob']}</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width">{lang('gender')}</td>
                                    <td class="user_table_width">{if $user_detail['gender'] == "M"}{lang('male')|ucfirst}{else}{lang('female')|ucfirst}{/if}</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width">{lang('mobile_no')}</td>
                                    <td class="user_table_width">{$user_detail['mobile']}</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width">{lang('email')}</td>
                                    <td class="user_table_width">
                                        <a href="mailto:{$user_detail['email']}?%20again" target="_top">{$user_detail['email']}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->

        </div>
        <br>
        <div class="row">
            <div class="button-container">
            <div class="col-sm-2 m-b-sm padding_both">
                {form_open('admin/profile_view', 'method="post"')}
                    <input type="hidden" name="user_name" value="{$user_name}" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-address-book-o f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm">{lang('profile')}</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                {form_close()}
            </div>
            <div class="col-sm-2 m-b-sm padding_both_small">
                {form_open('admin/income', 'method="post"')}
                    <input type="hidden" name="user_name" value="{$user_name}" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-money f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm">{lang('income_details')}</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                {form_close()}
            </div>
            <div class="col-sm-2 m-b-sm padding_both_small">
                {form_open('admin/my_referal', 'method="post"')}
                    <input type="hidden" name="user_name" value="{$user_name}" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-user-circle-o f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm">{lang('refferal_details')}</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                {form_close()}
            </div>
            {if $MLM_PLAN == "Binary"}
                <div class="col-sm-2 m-b-sm padding_both_small">
                    {form_open('admin/view_leg_count', 'method="post"')}
                        <input type="hidden" name="user_name" value="{$user_name}" />
                        <input type="hidden" name="from_page" id="from_page" value="user_account" />
                        <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                        <button class="btn-block btn-link user_button">
                            <div class="card_1 table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="fa fa-sitemap f-30"></i>
                                    </div>
                                    <div class="text-center text-center-width">
                                        <h4 class="f-w-300 m-t-sm m-b-sm">{lang('binary_details')}</h4>
                                    </div>
                                </div>
                            </div>
                        </button>
                    {form_close()}
                </div>
            {/if}
            <div class="col-sm-2 m-b-sm padding_both_small">
                {form_open('admin/my_ewallet', 'method="post"')}
                    <input type="hidden" name="user_name" value="{$user_name}" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-briefcase f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm">{lang('ewallet_details')}</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                {form_close()}
            </div>
            {if $MODULE_STATUS['purchase_wallet'] == 'yes'}
                <div class="col-sm-2 m-b-sm padding_both_small">
                    {form_open('admin/purchase_wallet', 'method="post"')}
                        <input type="hidden" name="user_name" value="{$user_name}" />
                        <input type="hidden" name="from_page" id="from_pagez" value="user_account" />
                        <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                        <button class="btn-block btn-link user_button">
                            <div class="card_1 table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="fa fa-shopping-basket f-30"></i>
                                    </div>
                                    <div class="text-center text-center-width">
                                        <h4 class="f-w-300 m-t-sm m-b-sm">{lang('purchase_wallet')}</h4>
                                    </div>
                                </div>
                            </div>
                        </button>
                    {form_close()}
                </div>
            {/if}
            {if $pin_status=="yes"}
                <div class="col-sm-2 m-b-sm padding_both_small">
                    {form_open('admin/view_pin_user', 'method="post"')}
                        <input type="hidden" name="user_name" value="{$user_name}" />
                        <input type="hidden" name="from_page" id="from_page" value="user_account" />
                        <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                        <button class="btn-block btn-link user_button">
                            <div class="card_1 table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="fa fa-bookmark-o f-30"></i>
                                    </div>
                                    <div class="text-center text-center-width">
                                        <h4 class="f-w-300 m-t-sm m-b-sm">{lang('user_epin')}</h4>
                                    </div>
                                </div>
                            </div>
                        </button>
                    {form_close()}
                </div>
            {/if}
            <div class="col-sm-2 m-b-sm padding_both_small">
                {form_open('admin/my_income', 'method="post"')}
                    <input type="hidden" name="user_name" value="{$user_name}" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-money f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm">{lang('income_statement')}</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                {form_close()}
            </div>
            {if $MLM_PLAN == "Binary"}
                <div class="col-sm-2 m-b-sm padding_both_small">
                    {form_open('admin/business_volume', 'method="post"')}
                        <input type="hidden" name="user_name" value="{$user_name}" />
                        <input type="hidden" name="from_page" id="from_page" value="user_account" />
                        <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                        <button class="btn-block btn-link user_button">
                            <div class="card_1 table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="fa fa-tint f-30"></i>
                                    </div>
                                    <div class="text-center text-center-width">
                                        <h4 class="f-w-300 m-t-sm m-b-sm">{lang('business_volume')}</h4>
                                    </div>
                                </div>
                            </div>
                        </button>
                    {form_close()}
                </div>
            {/if}
            
            <!--reward code bgins here  --sahla  -->
            <div class="col-sm-2 m-b-sm padding_both_small">
                {form_open('admin/rank_rewards', 'method="post"')}
                    <input type="hidden" name="user_name" value="{$user_name}" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-money f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm">{lang('rewards')}</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                {form_close()}
            </div>
            <!--end reward-->
            </div>
        </div>
    </div>
</div>