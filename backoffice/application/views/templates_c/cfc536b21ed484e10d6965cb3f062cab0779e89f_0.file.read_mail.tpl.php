<?php
/* Smarty version 3.1.30, created on 2020-09-25 19:23:34
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/mail/read_mail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6db716a03cf4_90788510',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cfc536b21ed484e10d6965cb3f062cab0779e89f' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/mail/read_mail.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:user/mail/mail_header.tpl' => 1,
  ),
),false)) {
function content_5f6db716a03cf4_90788510 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/home/mbatradingacadem/public_html/office/backoffice/application/third_party/Smarty/plugins/modifier.truncate.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8065676065f6db716a02227_75925967', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4500066495f6db716a03929_63157708', 'script');
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_8065676065f6db716a02227_75925967 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    
<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg"><?php echo lang('Sure_you_want_to_Delete_There_is_NO_undo');?>
</span>
    <span id="error_msg1"><?php echo lang('you_must_enter_message_here');?>
   </span>        
    <span id="error_msg3"><?php echo lang('you_must_select_user');?>
</span>        
    <span id="error_msg2"><?php echo lang('you_must_enter_subject_here');?>
</span>                  
</div> 
    
    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
      <?php $_smarty_tpl->_subTemplateRender("file:user/mail/mail_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

        <div class="col">
          <div>
            <div ui-view="" class="ng-scope" style="">
              <div ng-controller="MailDetailCtrl" class="ng-scope">
                <div class="wrapper bg-light lter b-b">
                  <a ui-sref="app.mail.list" class="btn btn-sm btn-default w-xxs m-r-sm" tooltip="Back to Inbox" href="<?php echo BASE_URL;?>
/user/mail/mail_management"><i class="fa fa-long-arrow-left"></i></a>
                </div>

                <?php if ($_smarty_tpl->tpl_vars['mail_type']->value == 'user') {?>
                    <div class="wrapper b-b">
                      <h2 class="font-thin m-n ng-binding"><?php echo $_smarty_tpl->tpl_vars['mail_details']->value[0]['subject'];?>
</h2>
                    </div>
                    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                    <?php $_smarty_tpl->_assignInScope('id', '');
?>
                    <?php $_smarty_tpl->_assignInScope('user_name', '');
?>
                    <?php $_smarty_tpl->_assignInScope('subject', '');
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mail_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                      <?php ob_start();
echo $_smarty_tpl->tpl_vars['LOG_USER_ID']->value;
$_prefixVariable1=ob_get_clean();
if ($_smarty_tpl->tpl_vars['v']->value['from'] != $_prefixVariable1) {?>
                        <div class="wrapper b-b ng-binding">
                          <img class="thumb-xs m-r-sm" src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                          <span class="ng-binding"><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</span> <?php echo lang('on');?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['date'];?>

                        </div>
                        <div class="wrapper ng-binding">
                            <div class="more"><?php if (preg_match('/(<img[^>]+>)/i',$_smarty_tpl->tpl_vars['v']->value['msg'])) {
echo $_smarty_tpl->tpl_vars['v']->value['msg'];
} elseif (preg_match('/(<a[^>]+>)/i',$_smarty_tpl->tpl_vars['v']->value['msg'])) {
echo $_smarty_tpl->tpl_vars['v']->value['msg'];
} else {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['v']->value['msg'],50);?>
 &nbsp; <?php if (strlen($_smarty_tpl->tpl_vars['v']->value['msg']) > 50) {?><a href="javascript:void(0);"><u><?php echo lang('more');?>
</u></a><?php }
}?></div>
                            <div class="less" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['v']->value['msg'];?>
&nbsp; <a href="javascript:void(0);"><u><?php echo lang('less');?>
</u></a></div>
                        </div>
                        <div class="wrapper">
                          <!-- ngRepeat: attach in mail.attach -->
                        </div>
                      <?php } else { ?>
                        <div class="wrapper b-b ng-binding">
                          <img class="thumb-xs m-r-sm" src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                          from <a href="" class="ng-binding"><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</a> on <?php echo $_smarty_tpl->tpl_vars['v']->value['date'];?>

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
                      <?php }?>

                    <?php ob_start();
echo $_smarty_tpl->tpl_vars['LOG_USER_ID']->value;
$_prefixVariable2=ob_get_clean();
if ($_smarty_tpl->tpl_vars['v']->value['from'] != $_prefixVariable2) {?>
                       <?php $_smarty_tpl->_assignInScope('id', $_smarty_tpl->tpl_vars['v']->value['id']);
?>
                       <?php $_smarty_tpl->_assignInScope('user_name', $_smarty_tpl->tpl_vars['v']->value['user_name']);
?>
                    <?php }?>
                    <?php $_smarty_tpl->_assignInScope('subject', $_smarty_tpl->tpl_vars['v']->value['message']);
?>
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <?php } else { ?>
                    <div class="wrapper b-b">
                       <h2 class="font-thin m-n ng-binding"><?php echo $_smarty_tpl->tpl_vars['mail_details']->value['contact_name'];?>
 Contacted You</h2>
                    </div>
                    <div class="wrapper ng-binding">
                        <h5><?php echo lang('from');?>
: <?php echo $_smarty_tpl->tpl_vars['mail_details']->value['contact_email'];?>

                            <span class="mailbox-read-time pull-right"><?php echo $_smarty_tpl->tpl_vars['mail_details']->value['date'];?>
</span></h5>
                        <h5><?php echo lang('Address');?>
: <?php echo $_smarty_tpl->tpl_vars['mail_details']->value['contact_address'];?>
</h5>
                        <h5><?php echo lang('Phone');?>
: <?php echo $_smarty_tpl->tpl_vars['mail_details']->value['contact_phone'];?>
</h5>
                        <div class="mailbox-read-message" style="word-wrap: break-word;">
                            <?php echo $_smarty_tpl->tpl_vars['mail_details']->value['contact_info'];?>

                        </div>
                    </div>
                <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['mail_type']->value == 'user') {?>
                    <div class="wrapper">
                      <div class="panel b-a">
                        <div class="panel-heading ng-show" ng-hide="reply" aria-hidden="false">
                          <div class="m-b-lg">
                          Click here to<a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/mail/reply_mail/<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" class="text-u-l" ng-click="reply=!reply"><span onclick="getUsername('<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['subject']->value;?>
');" > <?php echo lang('reply');?>
</span></a>
                          </div>
                        </div>
                      </div>
                    </div>
               <?php }?>
            </div>
        </div>
      </div>
    </div>
 </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_4500066495f6db716a03929_63157708 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/MailBox.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
