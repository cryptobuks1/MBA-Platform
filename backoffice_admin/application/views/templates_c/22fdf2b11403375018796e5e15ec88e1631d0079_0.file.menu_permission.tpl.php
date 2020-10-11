<?php
/* Smarty version 3.1.30, created on 2020-09-02 08:09:36
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/menu_permission.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f4ec6a0b89f75_37006710',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '22fdf2b11403375018796e5e15ec88e1631d0079' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/menu_permission.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f4ec6a0b89f75_37006710 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_counter')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/function.counter.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16825197565f4ec6a0b88336_70201688', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>
 
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10355151515f4ec6a0b89c52_53834989', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_16825197565f4ec6a0b88336_70201688 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
     <span id="error"><?php echo lang('please_check_menu_status_yes_and_menu_allowed');?>
</span>
</div>
<div class="panel panel-default table-responsive">
<div class="panel-body">
   <?php echo form_open('','role="form" class="" method="post"  name="set_permission_form" id="set_permission_form"');?>

   <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
      <thead>
         <tr>
            <th><?php echo lang('sl_no');?>
</th>
            <th><?php echo lang('available_menus');?>
</th>
            <th><?php echo lang('status');?>
</th>
            <th><?php echo lang('perm_admin');?>
</th>
            <th><?php echo lang('perm_user');?>
</th>
            <th><?php echo lang('perm_emp');?>
</th>
         </tr>
      </thead>
      <tbody>
         <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['menus']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
         <tr class="menu" id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
            <td><?php echo smarty_function_counter(array(),$_smarty_tpl);?>
</td>
            <td <?php if ($_smarty_tpl->tpl_vars['v']->value['sub_menu'] == '#') {?>class="has_sub" id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];
if ($_smarty_tpl->tpl_vars['v']->value['sub_menu'] == '#') {?>
            &nbsp;&nbsp;<i class='clip-chevron-right'style="vertical-align: middle;"></i>
            <?php }?></td>    
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="status" <?php if ($_smarty_tpl->tpl_vars['v']->value['check']) {?> checked="checked" <?php }?> class="switch-input menu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="perm_admin" <?php if (!$_smarty_tpl->tpl_vars['v']->value['check'] || $_smarty_tpl->tpl_vars['v']->value['type'] == "user") {?> Disabled<?php } else {
if ($_smarty_tpl->tpl_vars['v']->value['perm_admin']) {?> checked="checked"<?php }?> <?php }?> class="switch-input menu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="perm_dist" <?php if (!$_smarty_tpl->tpl_vars['v']->value['check'] || $_smarty_tpl->tpl_vars['v']->value['type'] == "admin") {?> Disabled<?php } else { ?> <?php if ($_smarty_tpl->tpl_vars['v']->value['perm_dist']) {?>checked="checked" <?php }
}?> class="switch-input menu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" name="perm_emp" <?php if (!$_smarty_tpl->tpl_vars['v']->value['check'] || $_smarty_tpl->tpl_vars['v']->value['type'] == "user") {?> Disabled <?php } else { ?> <?php if ($_smarty_tpl->tpl_vars['v']->value['perm_emp']) {?> checked="checked" <?php }
}?> class="switch-input menu_status">
               <i></i>
               </label>
            </td>
         </tr>
         <?php if ($_smarty_tpl->tpl_vars['v']->value['sub_menu'] == '#') {?>
         <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sub_menu']->value, 'w');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['w']->value) {
?>
         <?php if ($_smarty_tpl->tpl_vars['v']->value['id'] == $_smarty_tpl->tpl_vars['w']->value['menu_id']) {?>
         <tr class ="sub_<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  style="display:none;">
            <td></td>
            <td><?php echo $_smarty_tpl->tpl_vars['w']->value['sub_name'];?>
</td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="<?php echo $_smarty_tpl->tpl_vars['w']->value['sub_id'];?>
" name="sub_status" <?php if (!$_smarty_tpl->tpl_vars['v']->value['check']) {?> Disabled<?php } else { ?> <?php if ($_smarty_tpl->tpl_vars['w']->value['check']) {?>checked="checked" <?php }
}?> class="switch-input submenu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="<?php echo $_smarty_tpl->tpl_vars['w']->value['sub_id'];?>
" name="perm_admin" <?php if (!$_smarty_tpl->tpl_vars['v']->value['check'] || !$_smarty_tpl->tpl_vars['w']->value['check'] || $_smarty_tpl->tpl_vars['v']->value['type'] == "user" || !$_smarty_tpl->tpl_vars['v']->value['perm_admin'] || $_smarty_tpl->tpl_vars['w']->value['type'] == "user") {?> Disabled <?php } else { ?> <?php if ($_smarty_tpl->tpl_vars['w']->value['perm_admin']) {?>checked="checked" <?php }
}?> class="switch-input submenu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="<?php echo $_smarty_tpl->tpl_vars['w']->value['sub_id'];?>
" name="perm_dist" <?php if (!$_smarty_tpl->tpl_vars['v']->value['check'] || !$_smarty_tpl->tpl_vars['w']->value['check'] || $_smarty_tpl->tpl_vars['v']->value['type'] == "admin" || !$_smarty_tpl->tpl_vars['v']->value['perm_dist'] || $_smarty_tpl->tpl_vars['w']->value['type'] == "admin") {?> Disabled <?php } else { ?> <?php if ($_smarty_tpl->tpl_vars['w']->value['perm_dist']) {?>checked="checked" <?php }
}?> class="switch-input submenu_status">
               <i></i>
               </label>
            </td>
            <td class="text-left">
               <label class="i-switch i-switch_btn">
               <input type="checkbox" data-id="<?php echo $_smarty_tpl->tpl_vars['w']->value['sub_id'];?>
" name="perm_emp" <?php if (!$_smarty_tpl->tpl_vars['v']->value['check'] || !$_smarty_tpl->tpl_vars['w']->value['check'] || $_smarty_tpl->tpl_vars['v']->value['type'] == "user" || !$_smarty_tpl->tpl_vars['v']->value['perm_emp'] || $_smarty_tpl->tpl_vars['w']->value['type'] == "user") {?> Disabled <?php } else { ?> <?php if ($_smarty_tpl->tpl_vars['w']->value['perm_emp']) {?>checked="checked" <?php }
}?> class="switch-input submenu_status">
               <i></i>
               </label>
            </td>
         </tr>
         <?php }?>
         <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

         <?php }?>    
         <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

      </tbody>
   </table>
   </div>
</div>
<input type="hidden" id="base_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
">  
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_10355151515f4ec6a0b89c52_53834989 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/menu_permission.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
