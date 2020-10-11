<?php
/* Smarty version 3.1.30, created on 2020-08-06 10:54:28
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/read_mail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2b54c4873aa6_60794872',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2bdc5898f594cfd8dfd946973ee4a9eaeef93d17' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/read_mail.tpl',
      1 => 1587963469,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/mail/mail_header.tpl' => 1,
  ),
),false)) {
function content_5f2b54c4873aa6_60794872 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/modifier.truncate.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2406620095f2b54c4872093_75104157', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16662393635f2b54c4873787_19544287', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2406620095f2b54c4872093_75104157 extends Smarty_Internal_Block
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
/admin/mail/mail_management"><i class="fa fa-long-arrow-left"></i></a>
            </div>
          <!-- / header -->
          <?php if ($_smarty_tpl->tpl_vars['mail_type']->value == 'admin') {?>
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

            <div class="wrapper b-b ng-binding">
                <img class="thumb-xs m-r-sm" src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                <?php echo lang('from');?>
 <a class="ng-binding"><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</a> <?php echo lang('on');?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['date'];?>

            </div>
        <div class="wrapper ng-binding">
           <!-- <div ><?php if (preg_match('/(<img[^>]+>)/i',$_smarty_tpl->tpl_vars['v']->value['msg'])) {
echo $_smarty_tpl->tpl_vars['v']->value['msg'];
} elseif (preg_match('/(<a[^>]+>)/i',$_smarty_tpl->tpl_vars['v']->value['msg'])) {
echo $_smarty_tpl->tpl_vars['v']->value['msg'];
} else {
echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['v']->value['msg'],50);?>
 &nbsp; <?php if (strlen($_smarty_tpl->tpl_vars['v']->value['msg']) > 50) {?><a href="javascript:void(0);"><u><?php echo lang('more');?>
</u></a><?php }
}?></div>
            -->
             <div ><?php if (preg_match('/(<img[^>]+>)/i',$_smarty_tpl->tpl_vars['v']->value['msg'])) {
echo $_smarty_tpl->tpl_vars['v']->value['msg'];
} elseif (preg_match('/(<a[^>]+>)/i',$_smarty_tpl->tpl_vars['v']->value['msg'])) {
} else {
echo $_smarty_tpl->tpl_vars['v']->value['msg'];
}?></div>
           <div class="less" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['v']->value['msg'];?>
&nbsp; <a href="javascript:void(0);"><u><?php echo lang('less');?>
</u></a></div>
        </div>
        <div class="wrapper">
          <!-- ngRepeat: attach in mail.attach -->
        </div>
        <?php ob_start();
echo $_smarty_tpl->tpl_vars['LOG_USER_ID']->value;
$_prefixVariable1=ob_get_clean();
if ($_smarty_tpl->tpl_vars['v']->value['from'] != $_prefixVariable1) {?>
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

                  <span class="mailbox-read-time pull-right"><?php echo $_smarty_tpl->tpl_vars['mail_details']->value['mailadiddate'];?>
</span></h5>
                  <h5><?php echo lang('Address');?>
: <?php echo $_smarty_tpl->tpl_vars['mail_details']->value['contact_address'];?>
</h5>
                  <h5><?php echo lang('Phone');?>
: <?php echo $_smarty_tpl->tpl_vars['mail_details']->value['contact_phone'];?>
</h5><div class="mailbox-read-message" style="word-wrap: break-word;">
                <?php echo $_smarty_tpl->tpl_vars['mail_details']->value['contact_info'];?>

              </div>
                  
        </div>
        
        <?php }?>
       
       <?php if ($_smarty_tpl->tpl_vars['mail_type']->value == 'admin') {?>
           
        <div class="wrapper">
            <div class="panel b-a">
                <div class="panel-heading ng-show" ng-hide="reply" aria-hidden="false">
                  <div class="m-b-lg">
                      Click here to<a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/mail/reply_mail/<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" class="text-u-l" ng-click="reply=!reply"><span onclick="getUsername('<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['subject']->value;?>
');"> Reply</span></a> 
                  </div>
                </div>
            </div>
        </div>
        <?php }?>
        
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
class Block_16662393635f2b54c4873787_19544287 extends Smarty_Internal_Block
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
