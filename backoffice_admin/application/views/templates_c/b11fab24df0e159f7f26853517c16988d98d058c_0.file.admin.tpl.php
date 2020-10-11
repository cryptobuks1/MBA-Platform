<?php
/* Smarty version 3.1.30, created on 2020-09-16 22:22:13
  from "/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/admin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f620375960567_26562238',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b11fab24df0e159f7f26853517c16988d98d058c' => 
    array (
      0 => '/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/admin.tpl',
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
function content_5f620375960567_26562238 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16858281455f620375891571_90295679', 'script');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11414591495f6203758a0996_54573070', 'header');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13148699425f6203758aeea3_68836831', 'sidebar');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1415356385f62037592f0b3_89596356', 'content');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17410896195f620375942489_89064228', 'footer');
?>


<?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'home/index') {?>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13917560825f620375959c72_91132659', 'theme_setting');
?>

<?php }
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:layout/app.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'script'} */
class Block_16858281455f620375891571_90295679 extends Smarty_Internal_Block
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
class Block_11414591495f6203758a0996_54573070 extends Smarty_Internal_Block
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
class Block_13148699425f6203758aeea3_68836831 extends Smarty_Internal_Block
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
class Block_19390784535f6203758d3e88_64253280 extends Smarty_Internal_Block
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
class Block_21346830085f6203758ed512_17072680 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'main'} */
/* {block 'right_content'} */
class Block_6317485005f6203758f2b27_33161484 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'right_content'} */
/* {block 'content'} */
class Block_1415356385f62037592f0b3_89596356 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <!-- content -->
    <div id="content" class="app-content" role="main">
        <div class="app-content-body ">
            <div class="hbox hbox-auto-xs hbox-auto-sm">

                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19390784535f6203758d3e88_64253280', 'page_header', $this->tplIndex);
?>

                <div class="wrapper-md">
                <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/mail_management' && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'auto_responder/auto_responder_details' && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/mail_sent' && $_smarty_tpl->tpl_vars['CURRENT_URL']->value != 'mail/compose_mail') {?>
                    <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <?php }?>
                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21346830085f6203758ed512_17072680', 'main', $this->tplIndex);
?>


            </div>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6317485005f6203758f2b27_33161484', 'right_content', $this->tplIndex);
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
class Block_21204430555f620375939021_84115402 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'home_wrapper_out'} */
/* {block 'footer'} */
class Block_17410896195f620375942489_89064228 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21204430555f620375939021_84115402', 'home_wrapper_out', $this->tplIndex);
?>

    <?php $_smarty_tpl->_subTemplateRender("file:layout/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php
}
}
/* {/block 'footer'} */
/* {block 'theme_setting'} */
class Block_13917560825f620375959c72_91132659 extends Smarty_Internal_Block
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
