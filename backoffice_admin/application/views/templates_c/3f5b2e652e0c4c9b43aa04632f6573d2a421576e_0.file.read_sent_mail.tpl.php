<?php
/* Smarty version 3.1.30, created on 2020-08-22 08:01:23
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/read_sent_mail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f4044338458a0_54455436',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f5b2e652e0c4c9b43aa04632f6573d2a421576e' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/read_sent_mail.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/mail/mail_header.tpl' => 1,
  ),
),false)) {
function content_5f4044338458a0_54455436 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/modifier.truncate.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14774721645f4044338440d5_42675603', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7450916255f4044338455a7_55495333', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_14774721645f4044338440d5_42675603 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1"><?php echo lang('you_must_enter_message_here');?>
   </span>        
    <span id="error_msg3"><?php echo lang('you_must_select_user');?>
</span>        
    <span id="error_msg2"><?php echo lang('you_must_enter_subject_here');?>
</span>                  

</div>

    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
        <?php $_smarty_tpl->_subTemplateRender("file:admin/mail/mail_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

        <div class="col">
            <div>
            <!-- list -->
            <div ui-view="" class="ng-scope" style="">
            <div ng-controller="MailDetailCtrl" class="ng-scope">
            <!-- header -->
            <div class="wrapper bg-light lter b-b"> 
                <a ui-sref="app.mail.list" class="btn btn-sm btn-default w-xxs m-r-sm" tooltip="Back to Inbox" href="<?php echo BASE_URL;?>
/admin/mail/mail_sent"><i class="fa fa-long-arrow-left"></i></a>
            </div>
 
          <!-- / header -->
        <div class="wrapper b-b">
            <h2 class="font-thin m-n ng-binding"><?php echo $_smarty_tpl->tpl_vars['mail_details']->value[0]['mailtoussub'];?>
</h2>
        </div>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mail_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                <div class="wrapper b-b ng-binding">
                    <img class="thumb-xs m-r-sm" src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                    <?php echo lang('to');?>
 <span class="ng-binding"><?php echo $_smarty_tpl->tpl_vars['mail_details']->value[0]['to'];?>
</span> <?php echo lang('on');?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['mailtousdate'];?>

                </div>

                <div class="wrapper ng-binding">
                    <div class="more"><?php if (preg_match('/(<img[^>]+>)/i',$_smarty_tpl->tpl_vars['v']->value['msg'])) {
echo $_smarty_tpl->tpl_vars['v']->value['msg'];
} elseif (preg_match('/(<a[^>]+>)/i',$_smarty_tpl->tpl_vars['v']->value['msg'])) {
echo $_smarty_tpl->tpl_vars['v']->value['msg'];
} else {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['v']->value['msg'],50);?>
 &nbsp; <?php if (strlen($_smarty_tpl->tpl_vars['v']->value['msg']) > 50) {?><a href="javascript:void(0);"><?php echo lang('more');?>
</a><?php }
}?></div>
                        <div class="less" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['v']->value['msg'];?>
&nbsp; <a href="javascript:void(0);"><?php echo lang('less');?>
</a></div>
                </div>

                <div class="wrapper">
                  <!-- ngRepeat: attach in mail.attach -->
                </div>
           <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 
        </div>
    </div>
      <!-- / list --> 
    </div>
  </div>
</div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_7450916255f4044338455a7_55495333 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/MailBox.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
