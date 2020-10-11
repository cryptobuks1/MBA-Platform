{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
     <span id="error">{lang('please_check_menu_status_yes_and_menu_allowed')}</span>
</div>
<div class="panel panel-default table-responsive">
<div class="panel-body">
   {form_open('','role="form" class="" method="post"  name="set_permission_form" id="set_permission_form"')}
   <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
      <thead>
         <tr>
            <th>{lang('sl_no')}</th>
            <th>{lang('available_menus')}</th>
            <th>{lang('status')}</th>
            <th>{lang('perm_admin')}</th>
            <th>{lang('perm_user')}</th>
            <th>{lang('perm_emp')}</th>
         </tr>
      </thead>
      <tbody>
         {foreach from = $menus item = v}
         <tr class="menu" id="{$v.id}">
            <td>{counter}</td>
            <td {if $v.sub_menu=='#'}class="has_sub" id="{$v.id}" {/if}>{$v.name}{if $v.sub_menu=='#'}
            &nbsp;&nbsp;<i class='clip-chevron-right'style="vertical-align: middle;"></i>
            {/if}</td>    
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="{$v.id}" name="status" {if $v.check} checked="checked" {/if} class="switch-input menu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="{$v.id}" name="perm_admin" {if !$v.check  || $v.type == "user"} Disabled{else}{if $v.perm_admin} checked="checked"{/if} {/if} class="switch-input menu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="{$v.id}" name="perm_dist" {if !$v.check || $v.type == "admin"} Disabled{else} {if $v.perm_dist}checked="checked" {/if}{/if} class="switch-input menu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="{$v.id}" name="perm_emp" {if !$v.check || $v.type == "user"} Disabled {else} {if $v.perm_emp} checked="checked" {/if}{/if} class="switch-input menu_status">
               <i></i>
               </label>
            </td>
         </tr>
         {if $v.sub_menu=='#'}
         {foreach from=$sub_menu item=w}
         {if $v.id == $w.menu_id}
         <tr class ="sub_{$v.id}"  style="display:none;">
            <td></td>
            <td>{$w.sub_name}</td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="{$w.sub_id}" name="sub_status" {if !$v.check} Disabled{else} {if $w.check}checked="checked" {/if}{/if} class="switch-input submenu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="{$w.sub_id}" name="perm_admin" {if !$v.check || !$w.check || $v.type == "user" || !$v.perm_admin || $w.type == "user"} Disabled {else} {if $w.perm_admin}checked="checked" {/if}{/if} class="switch-input submenu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="{$w.sub_id}" name="perm_dist" {if !$v.check || !$w.check || $v.type == "admin" || !$v.perm_dist || $w.type == "admin"} Disabled {else} {if $w.perm_dist}checked="checked" {/if}{/if} class="switch-input submenu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="{$w.sub_id}" name="perm_emp" {if !$v.check || !$w.check || $v.type == "user" || !$v.perm_emp || $w.type == "user"} Disabled {else} {if $w.perm_emp}checked="checked" {/if}{/if} class="switch-input submenu_status">
               <i></i>
               </label>
            </td>
         </tr>
         {/if}
         {/foreach}
         {/if}    
         {/foreach}
      </tbody>
   </table>
   </div>
</div>
<input type="hidden" id="base_url" value="{$BASE_URL}">  
{/block} 
{block name=script} {$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/menu_permission.js" type="text/javascript" ></script>
{/block}