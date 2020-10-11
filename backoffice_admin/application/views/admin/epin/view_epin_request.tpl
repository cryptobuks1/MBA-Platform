{extends file=$BASE_TEMPLATE}
{block name=script}
  {$smarty.block.parent}
  <script src="{$PUBLIC_URL}javascript/Epinvalidation.js" type="text/javascript" ></script>
  <script>
  $(function(){
      ValidateUser.init();
  });
  </script>
{/block}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg6">{lang('please_select_at_least_one_checkbox')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="confirm_msg">{lang('are_you_sure_want_delete')}</span>
    <span id="err_msg1">{lang('non_zero_digits_only')}</span>
    <span id="err_msg2">{lang('count_field_is_required')}</span>
</div>
{form_open('','role="form" method="post"  name="view_request_form" id="view_request_form"')}
{assign var="arr_length" value=count($pin_detail_arr)}

<div class="panel panel-default ng-scope">
<div class="panel-body">
{if $arr_length >0}
  <div class="form-group">
  <input type="submit" class="btn  btn-primary" name="delete_req" id="delete_req" value="{lang('delete')}">
   <input type="submit" class="btn  btn-info" name="allocate" id="allocate"  value='{lang('allocate')}'>
 </div>
 {/if}
 <div class="table-responsive">
  <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>{lang('sl_no')}</th>
        <th>{lang('user_name')}</th>
        <th>{lang('full_name')}</th>
        <th>{lang('phone_number')}</th>
        <th>{lang('requested_pin_count')}</th>
        <th>{lang('amount')}</th>
        <th>{lang('date')}</th>
        <th>{lang('expiry_date')}</th>
        <th>{lang('count')}</th>
        <th>{lang('check')}/<a class="cursor" type="submit" name="check_all" value="Check All" id="check_all">{lang('mark_all')}</a></th>
      </tr>
    </thead>
    <tbody>
    {if $arr_length >0}
    {assign var="i" value="0"}
    {assign var="k" value="1"}
    {foreach from=$pin_detail_arr item=v}
      <tr>
        <td>{$k + $page_id}</td>
        <td><span class="m-b-xs w-xs btn-light-gray">{$v.user_name}</span></td>
        <td>{$v.full_name}</td>
        <td>{$v.phone_number}</td>
        <td>{$v.pin_count}<input type="hidden" name='rem_count{$k}' id='rem_count{$k}' value="{$v.pin_count}"/></td>
        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE, $PRECISION)}{$DEFAULT_SYMBOL_RIGHT}<input type="hidden" name='amount{$k}' id='amount{$k}' value="{$v.amount}"/></td>
        <td>{$v.req_date}</td>
        <td>{$v.expiry_date}<input type="hidden" name='expiry_date{$k}' id='expiry_date{$k}' value="{$v.expiry_date}"/></td>
        <td><input name='count{$k}' id='count{$k}' type='text' class="count"  size='4' maxlength='50'  value='{$v.rem_count}' style="text-align:  center;"/></td>
        <td><div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" class="active request_list" name='active{$k}' id='activate{$k}' value="yes">
              <i></i> </label>
          </div>
          </td>
          <input type='hidden' id="id{$k}" name='id{$k}' value='{$v.req_id}'/>
                            <input type='hidden' name='user_id{$k}' value='{$v.user_id}'/>
      </tr>
    {$k=$k+1}
    {/foreach}
        <input  type="hidden"  name="total_count" value="{$k}" >
    </tbody>
    {else}
        <tbody>
            <tr><td colspan="12" align="center"><h4>{lang('no_epin_request_found')}</h4></td></tr>
        </tbody>
    {/if}
  </table>
  </div>
  </div>
  {* {$result_per_page} *}
</div>
{form_close()}
{/block}