{extends file=$BASE_TEMPLATE} {block name=script} {$smarty.block.parent}
<script>
    jQuery(document).ready(function() {
        ValidateUser.init();
    });
</script>
{/block} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>
    <span id="error_msg2">{lang('Please_type_Amount')}</span>
    <span id="error_msg3">{lang('invalid_amount')}</span>
    <span id="validate_msg1">{lang('digits_only')}</span>
    <span id="validate_msg17">{lang('please_enter_transaction_concept')}</span>
    <span id="error_name">{lang('invalid_user_name')}</span>
</div>


<div class="m-b pink-gradient">
          <div class="card-body ">
            <div class="media">
              <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
              <div class="media-body">
                <h6 class="my-0">{lang('note_fund_credit_debit')}</h6>
              </div>
            </div>
          </div>
        </div>

   <div class="panel panel-default">
     <div class="panel-body">
      {form_open('/admin/post_fund_management','role="form" class="form" method="post"  name="fund_form" id="fund_form"')}
        <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}admin">
        <input type="hidden" name="fund1" id="fund1" value=""> {include file="layout/error_box.tpl"}
        <div class="form-group">
            <label class="required">{lang('user_name')}</label>
            <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off" /> {form_error('user_name')}
        </div>
        <div class="form-group">
            <label class="required">{lang('amount')}</label>
            <div class="input-group {$input_group_hide}">
                {$left_symbol} {$right_symbol}
                <input type="text" class="form-control" id="amount" name="amount" maxlength="5">
            </div>
            <span id="errmsg1"></span> {form_error('amount')}
        </div>
        <div class="form-group">
            <label class="required">{lang('transaction_note')}</label>
            <textarea class="form-control textfixed" name="tran_concept" rows="" placeholder="" id="tran_concept"></textarea> {form_error('tran_concept')}
        </div>
        <div class="form-group ">
            <button class="btn btn-primary" name="add_amount" id="add_amount" type="submit" value="{lang('add_amount')}"> {lang('add_amount')}</button>

            <button class="btn btn-primary" name="deduct_amount" id="deduct_amount" type="submit" value="{lang('deduct_amount')}"> {lang('deduct_amount')}</button>
        </div>
        {form_close()}
    </div>
</div>
    {* </div>
</div> *}
{/block}