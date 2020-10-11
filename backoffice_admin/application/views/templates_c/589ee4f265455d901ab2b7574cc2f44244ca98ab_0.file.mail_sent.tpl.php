<?php
/* Smarty version 3.1.30, created on 2020-08-22 08:01:07
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/mail_sent.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f4044230a3177_66084079',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '589ee4f265455d901ab2b7574cc2f44244ca98ab' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/mail_sent.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/mail/mail_header.tpl' => 1,
    'file:layout/alert_box.tpl' => 1,
  ),
),false)) {
function content_5f4044230a3177_66084079 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6426203415f4044230a2534_23397272', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_6426203415f4044230a2534_23397272 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg"><?php echo lang('Sure_you_want_to_Delete_There_is_NO_undo');?>
</span>
</div>

	<div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
            <?php $_smarty_tpl->_subTemplateRender("file:admin/mail/mail_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

            <div class="col">
            <div class="m-l-sm">
                <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                </div>
                <div>
                <!-- header -->
                    <div class="wrapper bg-light lter b-b">
                      <div class="btn-group pull-left">
                            <a href="" class="btn btn-sm btn-bg btn-default panel-refresh" data-toggle="tooltip" data-placement="bottom" data-title="Refresh" data-original-title="" title=""><i class="fa fa-refresh"></i></a>
                      </div>
                      <div class="btn-toolbar">

                      </div>
                    </div>  
                <!-- / header -->

	      <!-- list -->
	      <ul class="list-group list-group-lg no-radius   m-t-n-xxs">
                 
                <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                <?php $_smarty_tpl->_assignInScope('clr', '');
?>
                <?php $_smarty_tpl->_assignInScope('id', '');
?>
                <?php $_smarty_tpl->_assignInScope('msg_id', '');
?>
                <?php $_smarty_tpl->_assignInScope('user_name', '');
?>
                <?php $_smarty_tpl->_assignInScope('msg_tid', '');
?>
                <?php if ($_smarty_tpl->tpl_vars['cnt_adminmsgs']->value > 0) {?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['adminmsgs']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <?php $_smarty_tpl->_assignInScope('id', $_smarty_tpl->tpl_vars['v']->value['id']);
?>     
                    <?php $_smarty_tpl->_assignInScope('user_name', $_smarty_tpl->tpl_vars['v']->value['user_name']);
?>  
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == 'contact') {?>
                        <?php $_smarty_tpl->_assignInScope('msg_tid', $_smarty_tpl->tpl_vars['v']->value['id']);
?>
                    <?php } else { ?>
                        <?php $_smarty_tpl->_assignInScope('msg_tid', $_smarty_tpl->tpl_vars['v']->value['thread']);
?>
                    <?php }?> 
                    <?php $_smarty_tpl->_assignInScope('msg_id', $_smarty_tpl->tpl_vars['v']->value['id']);
?>
                        <li class="list-group-item clearfix b-l-3x b-l-info">
                            <span class="avatar thumb pull-left m-r"> 
                            <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                            </span>
                            <div class="pull-right text-sm text-muted">
                                  <span class="hidden-xs "><?php echo $_smarty_tpl->tpl_vars['v']->value['mailtousdate'];?>
</span>
                                  <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteSentMessage(<?php echo $_smarty_tpl->tpl_vars['msg_tid']->value;?>
, this.parentNode.parentNode.rowIndex, '<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin')" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                            </div>
                            <div class="clear">
                                <div><span  class="text-md "><?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == 'team') {?>ALL<?php } else {
echo $_smarty_tpl->tpl_vars['user_name']->value;
}?></span></div>
                                <div class="text-ellipsis m-t-xs ">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/mail/read_sent_mail/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_type'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['mailtoussub'];?>
</a>
                                </div> 
                            </div>
                        </li>              
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> 
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <?php } else { ?>
                    <li class="list-group-item clearfix b-l-3x b-l-info">
                      <center>
                        <?php echo lang('You_have_no_mails_in_sent');?>

                      </center>
                    </li> 
                    <?php }?>
                </ul>
                <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

                <!-- / list -->
                </div>
            </div>
	</div>
	 <style>
 ul.pagination {
    margin-top: 0px;
    float: right !important;
    margin-bottom: 51px;
}
</style>
     
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
