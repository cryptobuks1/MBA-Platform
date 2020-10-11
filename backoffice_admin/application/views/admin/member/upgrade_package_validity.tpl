{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;">
        <span id="errmsg">{lang('You_must_enter_keyword_to_search')}</span>
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span>
    </div>
    <div class="button_back">
        <a href="{BASE_URL}/admin/member/package_validity"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</button></a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <legend><span class="fieldset-legend">{lang('package_details')}</span></legend>
                    {if $product_status }
                         <p>{lang('your_product_currently_not_available')}</p>   
                    {else}
                    <div class="col-lg-5 col-sm-offset-1 b-r ">
                        <div class="clearfix text-center">
                            <div class="inline">
                                <div ui-jq="easyPieChart" ui-options="{
                                     percent: 75,
                                     lineWidth: 5,
                                     trackColor: '#e8eff0',
                                     barColor: '#23b7e5',
                                     scaleColor: false,
                                     color: '#3a3f51',
                                     size: 134,
                                     lineCap: 'butt',
                                     rotate: -90,
                                     animate: 1000
                                     }" class="easyPieChart">
                                    <div class="thumb-xl"> <img src="{$SITE_URL}/uploads/images/profile_picture/{$user_img}" class="img-circle" alt="..."> </div>
                                    <canvas width="134" height="134"></canvas>
                                </div>
                                <div class="h4 m-b-xs">{$expired_users.user_name}</div> 
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="upgrade_user_name" value="{$expired_users.user_name}">
                    <div class="col-lg-4">
                        {if count($expired_users)>0}
                            {assign var="user_name" value="{$expired_users.user_name}"}
                            {assign var="product_validity" value="{$expired_users.product_validity}"}
                            {assign var="sponsor_name" value="{$expired_users.sponsor_name}"}
                            {assign var="user_img" value="{$expired_users.user_img}"}
                            <table class="table table-responsive boder_none_modal">
                                <tbody>
                                    <tr>
                                        <td class="width_name_space">{lang('user_name')}</td>
                                        <td class="width_name_space_dot">:</td>
                                        <td>{$user_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="width_name_space">{lang('sponser_name')}</td>
                                        <td class="width_name_space_dot">:</td>
                                        <td>{$sponsor_name}</td>
                                    </tr>
                                    <tr>
                                        <td class="width_name_space">{lang('product_validity')}</td>
                                        <td class="width_name_space_dot">:</td>
                                        <td>{$product_validity}</td>
                                    </tr>
                                    <tr>
                                        <td class="width_name_space">{lang('amount_to_pay')}</td>
                                        <td class="width_name_space_dot">:</td>
                                        <td>{$DEFAULT_SYMBOL_LEFT} {number_format($product_amount * $DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                </tbody>
                            </table>
                        {else}
                            <tbody>
                                <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_User_Found')}</h4></td></tr>
                            </tbody>
                        {/if}
                    </div>
                        {/if}
                </div>
            </div>
        </div>
    </div>
    {if count($expired_users) > 0 && !$product_status}
    <legend><span class="fieldset-legend">{lang('reactivation_option')}</span></legend>
    {include file="admin/member/payment_tab.tpl" title="Example Smarty Page" name=""} 
    {/if}
{/block} 
{block name=style}
    {$smarty.block.parent}
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/user_tab.css" type="text/css" />
{/block}
{block name=script}
    {$smarty.block.parent} 
    <script src="{$PUBLIC_URL}theme/js/tabs_new.js"></script> 
{/block}