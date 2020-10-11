{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <input type="hidden" id="current_package_price" value="{$current_package_details['price']}">
    <input type="hidden" id="controller_name" value="{$CURRENT_CTRL}">
    {include file="layout/search_member.tpl"}
    <legend><span class="fieldset-legend">{lang('package_upgrade')}: {$user_name}</span></legend>
    {form_open('admin/upgrade_package_submit')}
    <input type="hidden" name="user_name" id="user_name" value="{$user_name}">
    <input type="hidden" name="upgrade_user_name" id="upgrade_user_name" value="{$user_name}">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="clearfix"> 
                        <div class="clear">
                            <small class="text-muted">{lang('current_package_details')}</small> 
                        </div>
                    </div>
                </div>
                <div class="list-group no-radius alt">
                    <div class="list-group-item" href=""> <span class="badge bg-info">{$current_package_details['package_id']}</span>{lang('package_id')}</div>
                    <div class="list-group-item" href=""> <span class="badge bg-info">{$current_package_details['product_name']}</span>{lang('package_name')}</div>
                    <div class="list-group-item" href=""> <span class="badge bg-info">{$DEFAULT_SYMBOL_LEFT}{number_format($current_package_details['price']*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</span>{lang('package_price')}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6" id="upgrade_pack_div" style="display: none;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="clearfix"> 
                        <div class="clear">
                            <small class="text-muted">{lang('upgrade_package_details')}</small> 
                        </div>
                    </div>
                </div>
                <div class="list-group no-radius alt">
                    <div class="list-group-item" href=""><span class="badge bg-info" id="package_id"></span>{lang('package_id')}</div>
                    <div class="list-group-item" href=""><span class="badge bg-info" id="package_name"></span>{lang('package_name')}</div>
                    <div class="list-group-item" href=""><span class="badge bg-info" id="package_price"></span>{lang('package_price')}</div>
                </div>
            </div>
        </div>
    </div>
    {if count($upgradable_package_list) > 0}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-sm-4 padding_both">
                    <label>{lang('upgrade_pack')}</label>
                    <div class="form-group">
                        <select name="product_id" id="product_id" class="form-control m-b">
                            <option value="">{lang('select_package')}</option>
                            {foreach from = $upgradable_package_list item = v}
                                <option value="{$v.product_id}">{$v.product_name} ({$DEFAULT_SYMBOL_LEFT}{round($v.price*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT})</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 padding_both_small">
                    <div class="form-group mark_paid">
                        <button class="btn btn-sm btn-primary" name="upgrade" id="upgrade"  type="submit" value="{lang('upgrade')}">{lang('upgrade')}</button>
                    </div>
                </div>
            </div>
        </div>
    {else}
        <div class="card pink-gradient">
            <div class="card-body">
                <div class="media">
                    <figure class=" avatar-50 "><i class="fa fa-times-circle"></i></figure>
                    <h6 class="my-0">{lang('no_higher_packages')}</h6>
                </div>
            </div>
        </div>
    {/if}
    {form_close()}
{/block}
{block name='script'}
<script type="text/javascript" src="{$PUBLIC_URL}javascript/currency.js"></script>
    <script>
        $(function(){
            ValidateSearchMember.init();
        });
    </script>
{/block}