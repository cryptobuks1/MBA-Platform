{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('please_select_at_least_one_checkbox')}</span>
    <span id="errmsg1">{lang('You_must_select_a_date')}</span>
    <span id="errmsg2">{lang('You_must_select_from_date')}</span>
    <span id="errmsg3">{lang('You_must_select_to_date')}</span>
    <span id="errmsg4">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="msg"> {lang('from_date_greater_than_to_date')}</span>
</div>
 
  <div class="m-b pink-gradient">
  <div class="card-body ">
    <div class="media">
      <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
      <div class="media-body">
        <h6 class="my-0">{lang('note_payout_confirm_bank_transfer')}</h6>
      </div>
    </div>
  </div>
</div>
 

 
 

<div class="panel panel-default">
  <div class="panel-body">
    {form_open('', 'role="form" class="" name="date_submit" id="date_submit" method="post" ')}
      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label class="required">{lang('start_date')}</label>
        <input type="text"  autocomplete="off"  class="form-control date-picker" name="start_date" id="start_date" type="text"  size="70" maxlength="10" >
        <span>{form_error('start_date')}</span>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group">
        <label class="required">{lang('end_date')}</label>
        <input  autocomplete="off"  class="form-control date-picker" name="end_date" id="end_date" type="text"  size="70" maxlength="10">
        <span>{form_error('end_date')}</span>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group">
      <div class="form-group mark_paid">
        <button type="submit" class="btn btn-primary"  id="submit_date" value="submit_date" name="submit_date" >{lang('submit')}</button>
      </div>
      </div>
      </div>
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
  </div>
</div>
{form_open('admin/mark_paid', 'role="form" name="mark_payout" id="mark_payout" method="post"')}
<div class="panel panel-default ng-scope">
<div class="panel-body">
<div class="table-responsive">
  <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>{lang('sl_no')}</th>
        <th>{lang('user_name')}</th>
        <th>{lang('paid_amount')}</th>
        <th>{lang('paid_date')}</th>
        <th>
        {lang('mark_as_paid')}/<a class="cursor" type="submit" name="check_all" value="Check All" id="check_all" onclick="checkAll();">{lang('mark_all')}</a>
                                <a class="cursor" type="submit" name ="uncheck_all" value="Uncheck All" id="uncheck_all" onclick="uncheckAll();" style="display:none;">{lang('unmark_all')}</a></th>
        </th>
      </tr>
    </thead>
    <tbody>
    {$i = 0}
    {if $length>0}
        {foreach from=$payout_details item=v}
            {$i = $i+1}
                <input type='hidden' name='paid_id{$i}' value = '{$v.paid_id}'>
                    <input type='hidden' name='user_name{$i}' value = '{$v.user_name}'>
                    <input type='hidden' name='paid_amount{$i}' value = '{$v.paid_amount}'>
                    <input type='hidden' name='paid_date{$i}' value = '{$v.paid_date}'>
      <tr>
        <td>{$i+$page_id}</td>
        <td>{$v.user_name}</td>
        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
        <td>{$v.paid_date}</td>
        <td><div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" name="mark_paid{$i}" id="mark_paid{$i}" class="release"/>
              <i></i> </label>
          </div></td>
      </tr>
      {/foreach}
      {else}
        <tr>
        <tr>
        <td colspan="9" align="center"><h4>{lang('no_payout_found')} </h4></td></tr>
        </tr>
    {/if}
    </tbody>
  </table>
  </div>
   <button type="submit" class="btn btn-sm btn-primary" name="marksw" id="marksw" value="marked">{lang('Confirm')}</button>
  </dvi>
   {$result_per_page}
</div>
 
 
  {form_close()}

{/block}