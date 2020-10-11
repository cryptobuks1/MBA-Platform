<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:12:16
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/admin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f295eb0c3def4_93066921',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c0b5e56ee7a78d17b7d85c16f6b510fd9908a5dc' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/admin.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/app.tpl' => 1,
    'file:layout/admin_header.tpl' => 1,
    'file:layout/sidebar.tpl' => 1,
    'file:layout/alert_box.tpl' => 1,
    'file:layout/demo_footer.tpl' => 1,
    'file:layout/footer.tpl' => 1,
    'file:layout/theme_setting.tpl' => 1,
  ),
),false)) {
function content_5f295eb0c3def4_93066921 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7639333905f295eb0c312a5_73467747', 'script');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17579899295f295eb0c320a8_06927693', 'header');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7312179815f295eb0c32d92_00491029', 'sidebar');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8303338815f295eb0c3b221_25058534', 'content');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17902964695f295eb0c3c713_09205579', 'footer');
?>


<?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'home/index') {?>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3082810775f295eb0c3d938_38273445', 'theme_setting');
?>

<?php }
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:layout/app.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'script'} */
class Block_7639333905f295eb0c312a5_73467747 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/timer.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/auto_timeout.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/currency.js" type="text/javascript" ><?php echo '</script'; ?>
>
    
<?php
}
}
/* {/block 'script'} */
/* {block 'header'} */
class Block_17579899295f295eb0c320a8_06927693 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php $_smarty_tpl->_subTemplateRender("file:layout/admin_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
}
/* {/block 'header'} */
/* {block 'sidebar'} */
class Block_7312179815f295eb0c32d92_00491029 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php $_smarty_tpl->_subTemplateRender("file:layout/sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
}
/* {/block 'sidebar'} */
/* {block 'page_header'} */
class Block_11166873495f295eb0c351e7_33196640 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                    <!-- main header -->
                    <?php if ($_smarty_tpl->tpl_vars['HEADER_LANG']->value['page_top_header']) {?>
                        <div class="bg-light lter b-b wrapper-md">
                            <h1 class="m-n font-thin h3"><?php echo $_smarty_tpl->tpl_vars['HEADER_LANG']->value['page_top_header'];?>
</h1>
                            <?php if ($_smarty_tpl->tpl_vars['HEADER_LANG']->value['page_top_small_header']) {?>
                                <small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['HEADER_LANG']->value['page_top_small_header'];?>
</small>
                            <?php }?>
                        </div>
                    <?php }?>

                    <!-- / main header -->
                <?php
}
}
/* {/block 'page_header'} */
/* {block 'main'} */
class Block_8239023545f295eb0c36e81_03296944 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'main'} */
/* {block 'right_content'} */
class Block_15273450915f295eb0c37570_31598893 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'right_content'} */
/* {block 'content'} */
class Block_8303338815f295eb0c3b221_25058534 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <!-- content -->
    <div id="content" class="app-content" role="main">
        <div class="app-content-body ">
            <div class="hbox hbox-auto-xs hbox-auto-sm">

                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11166873495f295eb0c351e7_33196640', 'page_header', $this->tplIndex);
?>

                <div class="wrapper-md">
                <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/mail_management' && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'auto_responder/auto_responder_details' && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/mail_sent' && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/compose_mail') {?>
                    <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php }?>
                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8239023545f295eb0c36e81_03296944', 'main', $this->tplIndex);
?>


            </div>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15273450915f295eb0c37570_31598893', 'right_content', $this->tplIndex);
?>


    </div>
    <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value != "home/index" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/mail_management" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/compose_mail" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/read_mail" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/reply_mail" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "ewallet/fund_transfer" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "auto_responder/auto_responder_details" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "auto_responder/auto_responder_settings" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "auto_responder/read_mail" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/mail_sent") {?>
        <?php $_smarty_tpl->_subTemplateRender("file:layout/demo_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <?php }?>     
</div>

</div>
<!-- /content -->

<?php
}
}
/* {/block 'content'} */
/* {block 'home_wrapper_out'} */
class Block_11013687935f295eb0c3be37_45674947 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'home_wrapper_out'} */
/* {block 'footer'} */
class Block_17902964695f295eb0c3c713_09205579 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11013687935f295eb0c3be37_45674947', 'home_wrapper_out', $this->tplIndex);
?>

    <?php $_smarty_tpl->_subTemplateRender("file:layout/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
}
/* {/block 'footer'} */
/* {block 'theme_setting'} */
class Block_3082810775f295eb0c3d938_38273445 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php $_smarty_tpl->_subTemplateRender("file:layout/theme_setting.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <?php
}
}
/* {/block 'theme_setting'} */
}
