<?php
/* Smarty version 3.1.30, created on 2020-09-25 23:30:25
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/about_us.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6df0f18f5807_11308664',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c25cec4d71ad02bd5fba44b5719884c195a57ed8' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/about_us.tpl',
      1 => 1583409634,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6df0f18f5807_11308664 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10659115765f6df0f18f0db5_90536853', 'style');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4306529555f6df0f18f5196_16084065', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'style'} */
class Block_10659115765f6df0f18f0db5_90536853 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<style>
  .upper {
    text-transform: uppercase;
  }
</style>
<?php
}
}
/* {/block 'style'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_4306529555f6df0f18f5196_16084065 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<section class="content_section bd-bottom">
    <div class="container">
        <div class="content_wrapper">
            <div class="col-md-6">
                    <div class="content_info">
                        <h2 class="upper"><?php echo lang('About');?>
</h2>
                        <p><?php if (isset($_smarty_tpl->tpl_vars['content']->value['about_us'])) {?><p><?php echo $_smarty_tpl->tpl_vars['content']->value['about_us'];?>
</p>
                        <?php } else { ?><p>The Infinite MLM software is an entire solution for all type of business plan like Binary,Matrix,
                          Unilevel and many other compensation plans. This is developed by a leading MLM software development company
                          Infinite Open Source Solutions LLP™. More over these we are keen to construct MLM software as per the
                          business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,
                          Replicating Website, E-Pin, E-Commerce Shopping Cart,Web Design</p>
                        <?php }?></p>
                         
                        <a href="#" class="zaara_btn_2 hidden">Learn More</a>
                    </div>
            </div>
            <div class="col-md-6 hidden-xs hidden-sm wow fadeInRight" data-wow-delay="200ms" data-wow-duration="800ms" style="visibility: visible; animation-duration: 800ms; animation-delay: 200ms; animation-name: fadeInRight;">
                <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
replica/theme/img/pack.jpg" alt="image">
            </div>
        </div>
    </div>
</section>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
