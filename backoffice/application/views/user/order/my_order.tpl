
{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('my_order')} 
            </div>
            <div class="panel-body">
                {form_open_multipart('', 'role="form" class="" name="searchform" id="searchform" method="post"')}
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="submit_date">
                          {lang('date')} 
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" autocomplete="off" data-date-viewmode="years" class="form-control date-picker" name="submit_date" id="submit_date" type="text" tabindex="3" size="20" maxlength="10"  value="" >
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                            </div>
                        </div>
                    </div>                                      
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" id="view_order" value="view_order" name="view_order" >
                               {lang('view_orders')} 
                            </button>
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{if $flag!="TRUE" && $flag1=="TRUE"}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('order_details')}<b>{if $user_name!="admin"} {$user_name}{/if}</b>
                </div>
                <div class="panel-body">

                    <table class="table table-striped table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th">
                                <th><b> {lang('order_ id')}</b></th>
                                <th><b> {lang('customer')}</b></th>
                                <th><b> {lang('product')}</b></th>
                                <th><b> {lang('quantity')}</b></th>
                                <th><b> {lang('date')}</b></th>
                                <th><b> {lang('shipping_method')} </b></th>
                                <th><b> {lang('shipping_address')} </b></th>
                                <th></th>
                            </tr>
                        </thead>
                        {if $count>0} 
                            <tbody>
                                {assign var="root" value="{$BASE_URL}user/"}
                                {foreach from=$order_details item=v}
                                    <tr>
                                        <td>{$v.order_id_with_prefix}</td>
                                        <td>{$v.customer_name}</td>
                                        <td>{$v.model}</td>
                                        <td>{$v.quantity}</td>
                                        <td>{$v.date_added}</td>
                                        <td>{$v.shipping_method}</td>
                                        <td><b>{$v.shipping_firstname} {$v.shipping_lastname}</b><br>{$v.shipping_address_1}</br>{$v.shipping_city}, {$v.shipping_zone}</br>{$v.shipping_country}</td>
                                        <td>
                                            <a href="{$BASE_URL}user/order/order_details/{$v.order_id}" target="_blank">
                                                <button type="button" name="order_id" id="order_id" class="btn btn-bricky top-btn" value="{$v.order_id}">View More</button>
                                            </a>
                                        </td>                                
                                    </tr>
                                {/foreach}
                            </tbody>
                        {else}
                            <tbody>
                                <tr><td colspan="8" align="center"><h4 align="center"> No Order Found.</h4></td></tr>
                            </tbody>
                        {/if}
                    </table> {$result_per_page}

                </div>
            </div>
        </div>
    </div>
{/if}

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}