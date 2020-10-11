{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{/if}
<style type="text/css">
    body{
        font-family:Arial, Helvetica, sans-serif;
        font-size:12px;
        margin:0px;
        line-height:18px;
    }
    img{
        border:none;
    }
    .brdr_style{
        border:1px solid #ccc;
    }
    .text_trnfm{
        text-transform:uppercase;
    }
    .preview-subtitle{
        font-weight:  bold;
    }
</style>

<style type="text/css" media="print">
    body * { visibility: hidden; }
    #print_div * { 
        visibility: visible; 
    }
    #print_div { 
        position: absolute; 
        top: 30px; 
        left: 10px; 
        width: 95%; 
        font-family:Arial, Helvetica, sans-serif;
        font-size:13px;
        margin:0px;
        line-height:24px;
    }
</style>
<div id="message_box"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('preview')} 
            </div>
            <div class="panel-body">

                <div id="print_div">
                    <table width = "100%">
                        <tr>
                            <td>   
                                <img  height="50px" src="{$SITE_URL}/uploads/images/logos/{$site_info["logo"]}" alt="" /> 
                            </td>
                            <td align="right">
                                {$letter_arr['company_name']} <br />
                                {$letter_arr['address_of_company']}
                            </td>
                        </tr>
                        <tr><td colspan="2"><hr /></td></tr>
                    </table>
                    <table> 
                        <tr style="font-size: 13px;">
                            <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('User_Name')}</label>
                            </td>
                            <td>:  {$user_registration_details['user_name']}</td>
                        </tr>
                        <tr style="font-size: 13px;">
                            <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('distributers_name')}</label>
                            </td>
                            <td>:  {$user_registration_details['first_name']} {$user_registration_details['last_name']}</td>
                        </tr>
                        <tr style="font-size: 13px;">
                            <td valign="top">   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('address')}</label>
                            </td>
                            <td><span class="pull-left">:</span> 
                                <div class="col-sm-12">
                                    {$user_registration_details['address']}<br/>
                                    {$user_registration_details['address_line2']}<br/>
                                    {$user_registration_details['state_name']}<br/>
                                    {$user_registration_details['country_name']}
                                </div>
                            </td>
                        </tr>
                        <tr style="font-size: 13px;">
                            <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('phone_number')}</label>
                            </td>
                            <td>:  {$user_registration_details['mobile']}</td>
                        </tr>

                        <tr style="font-size: 13px;">
                            <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('email')}</label>
                            </td>
                            <td>:  {$user_registration_details['email']}</td>
                        </tr>
                        <tr style="font-size: 13px;">
                            <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('date_of_joining')}</label>
                            </td>
                            <td>:  {$user_registration_details['reg_date']}</td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <h4><br/></h4>
                            </td>
                        </tr>
                        {if $user_registration_details['reg_amount']>0}
                            <tr style="font-size: 13px;">
                                <td>   
                                    <label class="col-sm-12 preview-subtitle" for="user_name">{lang('registration_amount')}</label>
                                </td>
                                <td>:  {$user_registration_details['reg_amount']}</td>
                            </tr>
                        {/if}


                        {if $MODULE_STATUS['product_status'] == "yes"}
                            <tr style="font-size: 13px;">
                                <td>   
                                    <label class="col-sm-12 preview-subtitle" for="user_name">{lang('package')}</label>
                                </td>
                                <td>:  {$user_registration_details['product_name']}</td>
                            </tr>
                            <tr style="font-size: 13px;">
                                <td>   
                                    <label class="col-sm-12 preview-subtitle" for="user_name">{lang('package')}</label>
                                </td>
                                <td>:  {$user_registration_details['product_amount']}</td>
                            </tr>
                        {/if}

                        {if $referal_status == "yes"}
                            <tr style="font-size: 13px;">
                                <td>   
                                    <label class="col-sm-12 preview-subtitle" for="user_name">{lang('sponsor')}</label>
                                </td>
                                <td>:  {$sponsorname}</td>
                            </tr>

                        {/if}
                        <tr style="font-size: 13px;">
                            <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('Placment_ID')}</label>
                            </td>
                            <td>:  {$adjusted_id}</td>
                        </tr>
                        {if $FOOTER_DEMO_STATUS=="yes"}
                            <tr style="font-size: 13px;">
                                <td>   
                                    <label class="col-sm-12 preview-subtitle" for="user_name">{lang('Login_Link')}</label>
                                </td>
                                <td>:  {$PATH_TO_ROOT}login/index/user/{$admin_user_name}/{$user_name}</td>
                            </tr>
                        {/if}
                    </table>

                    <br/>
                    <hr/>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>
                                    {$letter_arr['main_matter']}
                                </p>
                            </div>
                        </div></div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>
                                    {lang('winning_regards')},
                                </p>
                            </div>
                        </div></div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>
                                    {lang('admin')}
                                </p>
                            </div>
                        </div></div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p>
                                    {$letter_arr['company_name']} 
                                </p>
                            </div>
                        </div></div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-1 control-label" for="user_name">{lang('place')}</label>

                            <div class="col-sm-12">
                                {$letter_arr['place']}
                            </div>
                        </div></div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-1 control-label" for="user_name">{lang('date')}</label>

                            <div class="col-sm-12">
                                {$date}
                            </div>
                        </div></div>
                </div>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                    <input type="hidden" id="id" name="id" value="{$id}">
                    <td align="right">

                        {if $MLM_PLAN != "Board"}
                            <a href="{$PATH_TO_ROOT}{$user_type}/tree/genology_tree" style="text-decoration:none">
                                <div class="col-sm-6 col-sm-offset-2">
                                    <button class="btn btn-bricky"  value="{lang('go_to_tree_view')}">
                                        {lang('go_to_tree_view')}
                                    </button>
                                </div>
                            </a>
                        {else}
                            <a href="{$PATH_TO_ROOT}{$user_type}/boardview/view_board_details" style="text-decoration:none">

                                <div class="col-sm-6 col-sm-offset-2">
                                    <button class="btn btn-bricky"  value="{lang('Club_View')}">
                                        {lang('Club_View')}
                                    </button>
                                </div>

                            </a>
                        {/if}
                    </td>
                    <td>
                        <div id = "frame">
                            <a href="" onClick="window.print();
                                    return false"> <img align="right" src="{$PUBLIC_URL}images/1335779082_document-print.png" alt="Print" border="none"></a>	
                        </div></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{/if}

{if $LOG_USER_TYPE=='user'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
{/if}

