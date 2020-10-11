{extends file=$BASE_TEMPLATE}
{block name=script}
  {$smarty.block.parent}
  <script src="{$PUBLIC_URL}javascript/validate_epin_transfer.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function () {
        ValidateUser.init();
    });
</script>
{/block}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_from_user_name')}</span>
    <span id="error_msg3">{lang('you_must_enter_to_user_name')}</span>
    <span id ="error_msg2">{lang('you_must_select_epin')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="select_epin">{lang('you_must_select_epin')}</span>
</div>
 <div class="panel panel-default">
   <div class="panel-body">
     {form_open('','role="form" method="post"  name="epin_transfer_form" id="epin_transfer_form"')}
     {include file="layout/error_box.tpl"}
      <div class="form-group">
        <label class="required">{lang('from')} {lang('user_name')}</label>
        <input type="text" name="from_user_name" id="from_user_name" value="" title="" class="form-control user_autolist"/>
        {form_error('from_user_name')}
      </div>
      <div class="form-group">
        <label class="required">{lang('to')} {lang('user_name')}</label>
        <input type="text" name="user_name" id="user_name" value="" title="" class="form-control user_autolist"/>
        {form_error('user_name')}
      </div>
      <div class="form-group">
        <label class="required">{lang('epin')}</label>
        <select name="epin" id="epin" class="form-control m-b">
          <option value="default">{lang('select_epin')}</option>
         </select>
         {form_error('epin')}
      </div>
            <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary"  name="allocate" id="allocate" value="{lang('allocate')}">{lang('transfer')}</button>
      </div>
      {form_close()}
      </div>
      </div>


{/block}