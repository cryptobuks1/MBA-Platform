<?php
/* Smarty version 3.1.30, created on 2020-09-29 23:25:56
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/terms.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f7335e4129ff7_38805285',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e65bbf1774f60af90342fc86f8b2edc26503dd25' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/terms.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f7335e4129ff7_38805285 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15850064545f7335e4129784_85604947', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_15850064545f7335e4129784_85604947 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<section class="content_section bd-bottom">
  <div class="container">
    <div class="col-md-12">
      <div class="content_wrapper_1">
        <h2><?php echo lang('terms_and_conditions');?>
</h2>
        <?php if (isset($_smarty_tpl->tpl_vars['content']->value['terms'])) {?>
        <p><?php echo $_smarty_tpl->tpl_vars['content']->value['terms'];?>
</p>
        <?php } else { ?>
        <p>All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM
          software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other
          compensation plans. This is developed by a leading MLM software development company Infinite Open Source
          Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by
          the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating
          Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more.</p>
        <?php }?>
      </div>
    </div>
  </div>
</section>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
