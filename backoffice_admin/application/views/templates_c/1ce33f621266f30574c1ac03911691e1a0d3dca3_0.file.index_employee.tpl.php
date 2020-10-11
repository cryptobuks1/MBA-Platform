<?php
/* Smarty version 3.1.30, created on 2020-08-05 20:45:21
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/home/index_employee.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a8dc19dedc6_63497903',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ce33f621266f30574c1ac03911691e1a0d3dca3' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/home/index_employee.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/home/index.tpl' => 1,
  ),
),false)) {
function content_5f2a8dc19dedc6_63497903 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['block_name']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
        <?php if (!in_array($_smarty_tpl->tpl_vars['v']->value,$_smarty_tpl->tpl_vars['dashboard_menu']->value)) {?>   
           <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18925605605f2a8dc19ddee7_53065557', $_smarty_tpl->tpl_vars['v']->value);
?>

       <?php }?>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:admin/home/index.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block $_smarty_tpl->tpl_vars['v']->value} */
class Block_18925605605f2a8dc19ddee7_53065557 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


          <?php
}
}
/* {/block $_smarty_tpl->tpl_vars['v']->value} */
}
