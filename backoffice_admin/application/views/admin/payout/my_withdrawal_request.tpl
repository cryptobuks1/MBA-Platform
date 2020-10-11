{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div class="panel panel-default">
        <div class="panel-body">
            {form_open({$SHORT_URL},'role="form" class="" name="search_member" id="search_member" action="" method="post"')}
            <input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
            <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />
            {include file="layout/error_box.tpl"}
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="required" for="user_name">{lang('user_name')}</label>
                    <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off" size="100">
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit" name="search_member_submit">
                        {lang('search')}
                    </button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
    <div class="tabsy">
        <input type="radio" id="tab1" name="tab" {$tab1}>
        <label class="tabButton" for="tab1">{lang('active_requests')}</label>
        <div class="tab">
            <div class="content">
                <div class="panel-default table-responsive">
                    {if count($active_requests)>0}
                        <input type="hidden" name="current_tab" id="current_tab" value="tab1" >
                        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{lang('sl_no')}</th>
                                    <th>{lang('user_name')}</th>
                                    <th>{lang('user_full_name')}</th>
                                    <th>{lang('requested_date')}</th>
                                    <th>{lang('requested_amount')}</th>
                                    <th>{lang('payout_method')}</th>
                                    <th>{lang('balance_amount')}</th>
                                </tr>
                            </thead>
                            {assign var="i" value=0}
                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            <tbody>
                                {foreach from=$active_requests item="v"}
                                    {if $i%2==0}
                                        {$class='tr1'}
                                    {else}
                                        {$class='tr2'}
                                    {/if}
                                    <tr class="{$class}">
                                        <td>
                                            {$page1 + $i + 1}
                                        </td>
                                        <td>{$v.user_name}</td>
                                        <td>{$v.user_detail_name}</td>
                                        <td>{$v.requested_date}</td>
                                        <td>
                                            {$DEFAULT_SYMBOL_LEFT}{number_format($v.payout_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                                        </td>
                                        <td>{if $v.payout_type eq 'bank'}
                                            Bank
                                            {elseif $v.payout_type eq 'Bitcoin'}
                                                Blocktrail
                                                {else}      
                                                    {$v.payout_type}
                                                    {/if}
                                                    </td>
                                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                                                    </td>
                                                </tr>
                                                {$i=$i+1}
                                                {/foreach}                
                                                </tbody>
                                            </table>
                                            {$result_per_page1}
                                            {else}
                                                <h4 align="center">{lang('no_payout_found')}</h4>
                                                {/if}
                                                </div>
                                            </div>
                                        </div>
                                        <input type="radio" id="tab2" name="tab" {$tab2}>
                                        <label class="tabButton" for="tab2">{lang('approved_waiting_for_transfer')}</label>
                                        <div class="tab">
                                            <div class="content">
                                                <div class="panel-default table-responsive">
                                                    {if count($waiting_requests)>0}
                                                        <input type="hidden" name="current_tab" id="current_tab" value="tab2" >
                                                        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                                                            <thead class="table-bordered">
                                                                <tr>
                                                                    <th>{lang('sl_no')}</th>
                                                                    <th>{lang('user_name')}</th>
                                                                    <th>{lang('user_full_name')}</th>
                                                                    <th>{lang('approved_date')}</th>
                                                                    <th>{lang('Payout_Amount')}</th>
                                                                    <th>{lang('payout_method')}</th>
                                                                </tr>
                                                            </thead>
                                                            {assign var="i" value=0}
                                                            {assign var="class" value=""}
                                                            {assign var="path" value="{$BASE_URL}admin/"}
                                                            <tbody>
                                                                {foreach from=$waiting_requests item="v"}
                                                                    {if $i%2==0}
                                                                        {$class='tr1'}
                                                                    {else}
                                                                        {$class='tr2'}
                                                                    {/if}
                                                                    <tr class="{$class}">
                                                                        <td>{$page2 + $i +1}</td>
                                                                        <td>{$v.user_name}</td>
                                                                        <td>{$v.user_detail_name}</td>
                                                                        <td>{$v.paid_date}</td>
                                                                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                                        <td>
                                                                            {if $v.payment_method eq 'bank'}
                                                                                Bank
                                                                            {elseif $v.payment_method eq 'Bitcoin'}
                                                                                Blocktrail
                                                                            {else}      
                                                                                {$v.payment_method}
                                                                            {/if}
                                                                        </td>
                                                                    </tr>
                                                                    {$i=$i+1}
                                                                {/foreach}                
                                                            </tbody>
                                                        </table>
                                                        {$result_per_page2}
                                                    {else}
                                                        <h4 align="center">{lang('no_payout_found')}</h4>
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>
                                        <input type="radio" id="tab3" name="tab" {$tab3}>
                                        <label class="tabButton" for="tab3">{lang('approved_paid')}</label>
                                        <div class="tab">
                                            <div class="content">
                                                  <div class="panel-default table-responsive">
                                                    {if count($paid_requests)>0}
                                                        <input type="hidden" name="current_tab" id="current_tab" value="tab3" >
                                                        <table class="table table-bordered table-striped" id="">
                                                            <thead class="table-bordered">
                                                                <tr>
                                                                    <th>{lang('sl_no')}</th>
                                                                    <th>{lang('user_name')}</th>
                                                                    <th>{lang('user_full_name')}</th>
                                                                    <th>{lang('paid_date')}</th>
                                                                    <th>{lang('Payout_Amount')}</th>
                                                                    <th>{lang('payout_method')}</th>
                                                                </tr>
                                                            </thead>
                                                            {assign var="i" value=0}
                                                            {assign var="class" value=""}
                                                            {assign var="path" value="{$BASE_URL}admin/"}
                                                            <tbody>
                                                                {foreach from=$paid_requests item="v"}
                                                                    {if $i%2==0}
                                                                        {$class='tr1'}
                                                                    {else}
                                                                        {$class='tr2'}
                                                                    {/if}
                                                                    <tr class="{$class}">
                                                                        <td>{$page3 + $i + 1}</td>
                                                                        <td>{$v.user_name}</td>
                                                                        <td>{$v.user_detail_name}</td>
                                                                        <td>{$v.paid_date}</td>
                                                                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                                                                        </td>
                                                                        <td>
                                                                            {if $v.payment_method eq 'bank'}
                                                                                Bank
                                                                            {elseif $v.payment_method eq 'Bitcoin'}
                                                                                Blocktrail
                                                                            {else}      
                                                                                {$v.payment_method}
                                                                            {/if}
                                                                        </td>
                                                                    </tr>
                                                                    {$i=$i+1}
                                                                {/foreach}                
                                                            </tbody>
                                                        </table>
                                                        {$result_per_page3}
                                                    {else}
                                                        <h4 align="center">{lang('no_payout_found')}</h4>
                                                    {/if}        
                                                 </div>
                                            </div>
                                        </div>
                                        <input type="radio" id="tab4" name="tab" {$tab4}>
                                        <label class="tabButton" for="tab4">{lang('rejected_requests')}</label>
                                        <div class="tab">
                                            <div class="content">
                                                  <div class="panel-default table-responsive">
                                                    {if count($rejected_requests)>0}
                                                        <input type="hidden" name="current_tab" id="current_tab" value="tab1" >
                                                        <table class="table table-bordered table-striped" id="">
                                                            <thead class="table-bordered">
                                                                <tr>
                                                                    <th>{lang('sl_no')}</th>
                                                                    <th>{lang('user_name')}</th>
                                                                    <th>{lang('user_full_name')}</th>
                                                                    <th>{lang('requested_date')}</th>
                                                                    <th>{lang('rejected_date')}</th>
                                                                    <th>{lang('requested_amount')}</th>
                                                                    <th>{lang('payout_method')}</th>
                                                                </tr>
                                                            </thead>
                                                            {assign var="i" value=0}
                                                            {assign var="class" value=""}
                                                            {assign var="path" value="{$BASE_URL}admin/"}
                                                            <tbody>
                                                                {foreach from=$rejected_requests item="v"}
                                                                    {if $i%2==0}
                                                                        {$class='tr1'}
                                                                    {else}
                                                                        {$class='tr2'}
                                                                    {/if}
                                                                    <tr class="{$class}">
                                                                        <td>
                                                                            {$page4 +$i +1}
                                                                        </td>
                                                                        <td>{$v.user_name}</td>
                                                                        <td>{$v.user_detail_name}</td>
                                                                        <td>{$v.requested_date}</td>
                                                                        <td>{$v.updated_date}</td>
                                                                        <td>
                                                                            {$DEFAULT_SYMBOL_LEFT}{number_format($v.payout_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                                                                        </td>
                                                                        <td>
                                                                            {if $v.payout_type eq 'bank'}
                                                                                Bank
                                                                            {elseif $v.payout_type eq 'Bitcoin'}
                                                                                Blocktrail
                                                                            {else}      
                                                                                {$v.payout_type}
                                                                            {/if}
                                                                        </td>
                                                                    </tr>
                                                                    {$i=$i+1}
                                                                {/foreach}                
                                                            </tbody>
                                                        </table>
                                                        {$result_per_page4}
                                                    {else}
                                                        <h4 align="center">{lang('no_payout_found')}</h4>
                                                    {/if}       
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {/block}

                                        {block name=script} {$smarty.block.parent}
                                            <script>
                                                jQuery(document).ready(function () {
                                                    ValidateSearchMember.init();
                                                });
                                            </script>
                                            <script type="text/javascript">
                                                $('#search_member').attr('action', $('#base_url').val() + 'admin/payout/search_member_withdrawal');
                                            </script>
                                        {/block}