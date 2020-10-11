{extends file=$BASE_TEMPLATE} 

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>
</div>

        <div class="panel panel-default">
            <div class="panel-body">
                {form_open('','role="form"  method="post"  name="permission_form" id="permission_form"')}
                    {include file="layout/error_box.tpl"}
                    <div class="col-sm-3 padding_both">
                        <div class="form-group">
                            <label class="required" for="user_name">{lang('select_employee')}</label>
                                <input type="text" class="form-control employee_autolist" name="user_name" id="user_name" autocomplete="Off">
                                <span id="username_box" style="display:none;"></span>
                                {form_error('user_name')}
                        </div>
                    </div>
                    <div class="col-sm-3 padding_both_small">
                        <div class="form-group mark_paid">
                            <button type="submit" class="btn btn-primary" name="user_name_submit" id="user_name_submit" value="{lang('view_module_permission')}">
                                {lang('view')}
                            </button>
                        </div>
                    </div>
                            
                {form_close()}
            </div> 
        </div>    

{if $user_name_submit}
    
        <div class="panel panel-default">
            <div class="panel-body"> 
                <a href="{BASE_URL}/admin/dashboard_config/{$user_enc_id}" class="btn btn-sm btn-primary btn-addon pull-right m-r-xs" name="user_name_submit" id="user_name_submit" value="{$user_name}" ><i class="fa fa-plus"></i>{lang('dashboard_config')}</a>
                <legend><span class="fieldset-legend">{lang('set_permission_of')} {$user_name}</span></legend>
                <div class="content">
                    {form_open('','role="form" method="post"  name="set_permission_form" id="set_permission_form"')}
                        {foreach from=$menus item=v}
                            <div class="panel panel-default">
                                <input type="hidden" name="user" id="user" value="{$user_name}">
                                <div class="panel-heading">
                                <a id="btn-{$v.id}" {if $v.sub_menu=='#'} data-toggle="collapse"{else} data-toggle=""{/if} data-target="#submenu{$v.id}" aria-expanded="false" data-parent="#accordion">
                                    <h4 class="panel-title"> 
                                         {$v.name} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         {if $v.sub_menu!='#'}<label class="i-checks"><input type="checkbox" data-checkbox="icheckbox_square-blue" name="m{$v.id}k"  id="inlineCheckbox1-{$v.id}" {if $v.check==1}checked="yes"{/if} {if $v.disable==1}disabled{/if} data-on-color="success" class="bs-switch" data-off-color="danger" value="m#{$v.id}" id="{$v.id}"><i></i> </label>{/if}
                                         {if $v.sub_menu=='#'}<span class="pull-right panel-collapse-clickable" data-target="#submenu{$v.id}" data-toggle="collapse" data-parent="#accordion" href="#filterPanel"> <i class="glyphicon glyphicon-chevron-down"></i> </span> {/if}
                                    </h4>
                                    </a>
                                </div>
                                <div id="submenu{$v.id}" class="panel-collapse panel-collapse collapse">  
                                <div class="panel-body">
                                    {if $v.sub_menu=='#'}
                                        {foreach from=$sub_menu item=w}
                                            {if $v.id == $w.menu_id}
                                                
                                                    <div class="checkbox">
                                                        <label class="i-checks">
                                                        <input type="checkbox" data-checkbox="icheckbox_square-blue" name="{$w.sub_id}" id="{$w.sub_id}" {if $w.check == 1}checked="yes"{/if} data-on-color="success" data-off-color="danger" value="{$v.id}#{$w.sub_id}">
                                                        <i></i> {$w.sub_name} </label>
                                                    </div>
                                                   <div class="m-t-sm"></div>
                                                       
                                           {/if}
                                        {/foreach}
                                    {/if}
                                </div>
                                </div>
                            </div>
                        {/foreach}

                        <div class="form-group">
                            <button class='btn btn-sm btn-primary' type='submit' align='center' name='permission' id='permission' value='Set Permission'>
                              {lang('set_permission')}
                            </button>
                        </div>
                    {form_close()}        
                </div>
            </div>
        </div>
{/if}

{/block}

{block name=script}
  {$smarty.block.parent}
    <script>
        jQuery(document).ready(function() {
            ValidateUser.init();
        });
    </script>
{/block}