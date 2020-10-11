<?php
/* Smarty version 3.1.30, created on 2020-09-10 09:22:41
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/payout_release_mail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f5963c16da075_49396061',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff9873b97f1aa3e46a10d7275ccdd141e89c6114' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/payout_release_mail.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f5963c16da075_49396061 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_mail_content"><?php echo lang('you_must_enter_mail_content');?>
</span>
    <span id="validate_subject"><?php echo lang('you_must_enter_subject');?>
</span>
</div>
            <div class="content">
                    <?php echo form_open('','role="form" class="" name="payout_mail_settings" id="payout_mail_settings"');?>

                    <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
                        <div class="form-group">
                            <label class="control-label required" ><?php echo lang('mail_status');?>
</label>
                                <select class="form-control" name="mail_status" id="mail_status">
                                    <option value="yes" <?php if ($_smarty_tpl->tpl_vars['payout_release']->value['mail_status'] == 'yes') {?>selected<?php }?>><?php echo lang('yes');?>
</option>
                                    <option value="no" <?php if ($_smarty_tpl->tpl_vars['payout_release']->value['mail_status'] == 'no') {?>selected<?php }?>><?php echo lang('no');?>
</option>
                                </select>
                        </div>
                            
                        <div class="form-group">
                            <label class=" control-label required" ><?php echo lang('subject');?>
</label>
                                <input class="form-control"  type="text"  name ="subject1" id ="subject1" value="<?php echo $_smarty_tpl->tpl_vars['payout_release']->value['subject'];?>
" autocomplete="Off">
                                <span><?php echo form_error('subject1');?>
</span>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label required" for="mail_content1">
                                <?php echo lang('mail_content');?>

                            </label>
                            <textarea id="mail_content1"  name="mail_content1" class="ckeditor form-control" rows='10'>
                                <?php echo $_smarty_tpl->tpl_vars['payout_release']->value['content'];?>

                            </textarea>
                            <span><?php echo form_error('mail_content1');?>
</span>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label"></label>
                            <label> <span class="symbol required"></span><?php echo lang('mail_msg');?>
</label> 
                        </div>
                        
                        <div class="form-group">
                            <label class=" control-label"></label>
                            <p class="m-b">
                                <label><?php echo lang('other_variables_that_you_can_use');?>
</label> <br>
                                    <code>A</code>{fullname}<br>
                                    <code>B</code>{company_name}<br>
                                    <code>C</code>{company_address}<br>
                            </p>
                        </div>

                        <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit"  value="Update" name="payout_release" id="payout_release" ><?php echo lang('update');?>
</button>
                        </div>  
                    <?php echo form_close();?>

            </div><?php }
}
