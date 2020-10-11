<?php
/* Smarty version 3.1.30, created on 2020-08-06 10:54:40
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/reply_mail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2b54d0f005d5_84692344',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '59e2dc10181772ba682fd644804766546a373b57' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/reply_mail.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/mail/mail_header.tpl' => 1,
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f2b54d0f005d5_84692344 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8892514865f2b54d0efec68_61707467', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11791193205f2b54d0efffa5_00822905', 'script');
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_8892514865f2b54d0efec68_61707467 extends Smarty_Internal_Block
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
                    <ul class="list-group list-group-lg no-radius m-b-none m-t-n-xxs">
                      <li class="list-group-item clearfix b-l-3x b-l-info">
                          <div class="tab">
                              <div class="content">
                                  <?php echo form_open('','name="compose_reply" id="compose_reply" class="smart-wizard" method="post"');?>

                                    <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
                                  <div class="form-group">
                                      <input type="text" class="form-control" id="user_id1" name="user_id1" readonly value="<?php echo $_smarty_tpl->tpl_vars['reply_user']->value;?>
"/>  
                                  </div>

                                  <div class="form-group">
                                      <input type="text" class="form-control" name="subject" id="subject" value=" Rep:<?php echo $_smarty_tpl->tpl_vars['reply_msg']->value;?>
" /><?php echo form_error('subject');?>

                                  </div>
                                                                    
                                  <div class="form-group">
                                    <label class="required"><?php echo lang('mail_content');?>
</label>
                                        <div class="form-group">
                                            <textarea class="textarea text  fixed" name='message' id='message' placeholder="<?php echo lang('message_to_send');?>
" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                        </div>  
                                        <span class='val-error' id="err_mail_content"><?php echo form_error('message');?>
</span>
                                  </div>

                                  <div class="form-group">
                                      <button type="submit" class="btn btn-sm btn-primary" id="send" value="<?php echo lang('send_message');?>
" name="send"><?php echo lang('send_message');?>
</button>
                                  </div>
                                  <?php echo form_close();?>

                              </div>
                          </div>     
                      </li>
                    </ul>
                </div>
            </div>
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_11791193205f2b54d0efffa5_00822905 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
>
        jQuery(document).ready(function() {
            ValidateUser.init();
            $(".textarea").wysihtml5();
        });
    <?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/validate_mail_management.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
