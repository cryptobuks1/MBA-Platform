<?php
/* Smarty version 3.1.30, created on 2020-09-25 14:33:30
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/layout/user.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d731ac2d6c2_79166272',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4ad81222ecaaa12b4e8bd4ca10bd657bacf670c8' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/layout/user.tpl',
      1 => 1570096746,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/app.tpl' => 1,
    'file:layout/user_header.tpl' => 1,
    'file:layout/sidebar.tpl' => 1,
    'file:layout/alert_box.tpl' => 1,
    'file:layout/demo_footer.tpl' => 1,
    'file:layout/footer.tpl' => 1,
  ),
),false)) {
function content_5f6d731ac2d6c2_79166272 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13998300455f6d731ac23409_57394558', 'script');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17527660315f6d731ac241a4_58140349', 'header');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5914694035f6d731ac24e92_43850805', 'sidebar');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16461446485f6d731ac2be92_88870007', 'content');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2622030215f6d731ac2d320_38513041', 'footer');
?>


<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:layout/app.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'script'} */
class Block_13998300455f6d731ac23409_57394558 extends Smarty_Internal_Block
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
class Block_17527660315f6d731ac241a4_58140349 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php $_smarty_tpl->_subTemplateRender("file:layout/user_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
}
/* {/block 'header'} */
/* {block 'sidebar'} */
class Block_5914694035f6d731ac24e92_43850805 extends Smarty_Internal_Block
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
class Block_8507742445f6d731ac27303_31767303 extends Smarty_Internal_Block
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
class Block_16155106915f6d731ac28c44_69863228 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'main'} */
/* {block 'right_content'} */
class Block_14946846855f6d731ac29314_08468875 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'right_content'} */
/* {block 'content'} */
class Block_16461446485f6d731ac2be92_88870007 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <!-- content -->
    <div id="content" class="app-content" role="main">
        <div class="app-content-body ">
            <div class="hbox hbox-auto-xs hbox-auto-sm">
                
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8507742445f6d731ac27303_31767303', 'page_header', $this->tplIndex);
?>

                    <div class="wrapper-md">
                    <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/mail_management' && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/mail_sent' && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/compose_mail') {?>
                        <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                    <?php }?>
                    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16155106915f6d731ac28c44_69863228', 'main', $this->tplIndex);
?>

                
            </div>
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14946846855f6d731ac29314_08468875', 'right_content', $this->tplIndex);
?>

    </div>
    <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value != "home/index" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/mail_management" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/compose_mail" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/read_mail" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/reply_mail" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "ewallet/fund_transfer" && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != "mail/mail_sent") {?>
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
class Block_6594436825f6d731ac2ca57_02380661 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'home_wrapper_out'} */
/* {block 'footer'} */
class Block_2622030215f6d731ac2d320_38513041 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6594436825f6d731ac2ca57_02380661', 'home_wrapper_out', $this->tplIndex);
?>

    <?php $_smarty_tpl->_subTemplateRender("file:layout/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
}
/* {/block 'footer'} */
}
