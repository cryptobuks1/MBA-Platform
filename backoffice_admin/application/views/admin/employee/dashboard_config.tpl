{extends file=$BASE_TEMPLATE} 
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>
</div>

<div class="button_back">
    {form_open('admin/set_employee_permission', 'role="form" class=""')}
        <input type="hidden" value="{$user_name}" name="user_name" >
        <button type="submit" class="btn m-b-xs btn-sm btn-info btn-addon" name="user_name_submit" id="user_name_submit" value="{lang('view')}"><i class="fa fa-backward"></i>{lang('back')}</button>
    {form_close()}
</div>
    <div class="panel panel-default">
        <div class="panel-body"> 
          <legend><span class="fieldset-legend">{lang('set_permission_of')} {$user_name}</span></legend>
            {form_open('','role="form" method="post"  name="set_permission_form" id="set_permission_form"')}
               <input type="hidden" name="user" id="user" value="{$user_name}"> 
               <input type="hidden" name="user_name_submit" id="user_name_submit" value="{$user_name}"> 
                <div class="content">
                        {foreach from=$menus item=w}
                                    <div class="checkbox">
                                        <label class="i-checks">
                                        <input type="checkbox" data-checkbox="icheckbox_square-blue" name="{$w.name}" id="{$w.id}" {if $w.check == 1}checked="yes"{/if} data-on-color="success" data-off-color="danger" value="{$w.name}">
                                        <i></i> {if $w.name == 'ewallet' && $MODULE_STATUS['roi_status'] == "yes"}{if $MODULE_STATUS['hyip_status'] == "yes"}{lang('total_deposit')}{else}{lang('hyip')}{/if} {else} {lang($w.name)}{/if}</label>
                                    </div>
                                   <div class="m-t-sm"></div>
                        {/foreach}
                </div>
                <div class="form-group">
                    <button class='btn btn-sm btn-primary' type='submit' align='center' name='permission' id='permission' value='Set Permission'>
                      {lang('set_permission')}
                    </button>
                </div>
            {form_close()}        
        </div>
    </div>
{/block}

{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/validate_employee.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            ValidateUser.init();
        });
    </script>
{/block}