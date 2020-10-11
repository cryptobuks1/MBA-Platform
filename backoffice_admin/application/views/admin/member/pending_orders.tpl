{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
    <span id="msg1">{lang('pending_repurchase_order_confirm')}</span>
    <span id="error_msg">{lang('please_select_at_least_one_checkbox')}</span>
</div>

    <div class="panel panel-default">
    <div class="panel-body">
        {form_open('admin/approve_order', 'name="pending_order" class="" id="pending_order" method="post"')}
    {if count($pending_order_list)}
    <div class="panel panel-default table-responsive ng-scope">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th">
                    <th>{lang('slno')}</th>
                    <th>{lang('invoice_no')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('full_name')}</th>
                    <th>{lang('date_submission')}</th>
                    <th>{lang("payment_method")}</th>
                    <th>{lang('total_amount')}</th>
                    <th>{lang('view_reciept')}</th>
                    <th>{lang('check')}/<a class="cursor" type="submit" name="check_all" value="Check All" id="check_all" >{lang('check_all')}</a></th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="i" value=1}
            {assign var="total_quantity" value=0}
                {foreach from = $pending_order_list key = k item = v}
                    <tr>
                        <td>{$page_id + $i}</td>
                        <td>{$v['invoice_no']}</td>
                        <td>{$v['user_name']}</td>
                        <td>{$v['full_name']}</td>
                        <td>{$v['order_date']}</td>
                <td>{lang($v['payment_method'])}</td>
                <td style="text-align: center;">{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td><a class="btn btn-default"  style="background-color: #e7e7e7;" href="javascript:mym('{SITE_URL}/uploads/images/reciepts/{$v['reciept']}')"><img class="img-responsive"  src="{SITE_URL}/uploads/images/reciepts/{$v['reciept']}"alt=""/><i class="clip-target"></i></a></td>
                       
                <td>
                    <div class="checkbox">
                        <label class="i-checks">
                            <input type="checkbox" name="approval[]" id="approval{$i}" class="approval" value="{$v['encrypt_order_id']}"/><i> </i>
                        </label>
                    </div>
                </td>
                 <td>
                    <a href="../repurchase/repurchase_invoice/{$v['encrypt_order_id']}" target="_blank" class="btn-link btn-sm btn-icon text-primary" title="More Details">
                        <i class="fa fa-eye"></i>
                    </a>    
                 </td>
                    </tr>
                    {$i = $i + 1}
                {/foreach}
            </tbody>
        </table>
        </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary approve" name="confirm_order" id="confirm_registr" type="submit" value="confirm_order"> {lang('approve')} </button>
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

 {block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/javascript/pending_repurchase.js"></script>
 {/block}