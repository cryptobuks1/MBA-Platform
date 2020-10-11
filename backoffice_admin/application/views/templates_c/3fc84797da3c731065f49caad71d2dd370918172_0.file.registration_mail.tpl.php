<?php
/* Smarty version 3.1.30, created on 2020-09-10 09:22:41
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/registration_mail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f5963c16d1679_53669633',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3fc84797da3c731065f49caad71d2dd370918172' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/registration_mail.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f5963c16d1679_53669633 (Smarty_Internal_Template $_smarty_tpl) {
?>




        <div class="content">
            <?php echo form_open('','role="form" class="" name="reg_mail_settings" id="reg_mail_settings"');?>

                <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
                    
                    <input type="hidden" name="mail_status" value="yes">
                    <div class="form-group">
                        <label class="control-label required" ><?php echo lang('subject');?>
</label>
                            <input class="form-control"  type="text"  name ="subject" id ="subject" value="<?php echo $_smarty_tpl->tpl_vars['reg_mail']->value['subject'];?>
"  maxlength="" autocomplete="Off" >
                            <span><?php echo form_error('subject');?>
</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label required" for="mail_content"><?php echo lang('mail_content');?>
</label>
                            <textarea id="mail_content"  name="mail_content" class="ckeditor form-control" rows='10' >
                                <?php echo $_smarty_tpl->tpl_vars['reg_mail']->value['content'];?>

                            </textarea>
                            <span><?php echo form_error('mail_content');?>
</span>
                    </div>
                    <div class="form-group">
                        <label class="required"><?php echo lang('mail_msg');?>
</label> 
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label"></label>
                        <p class="m-b">
                            <label><?php echo lang('other_variables_that_you_can_use');?>
</label> <br>
                            <code>A</code> {fullname} <br>
                            <code>B</code> {username} <br>
                            <code>C</code> {company_name}<br>
                            <code>D</code> {company_address}<br>
                            <code>E</code> {sponsor_username} <br>
                            <code>F</code> {payment_type} </p>
                        </p>
                    </div>
                        
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" type="submit"  value="Update" name="reg_update" id="reg_update" ><?php echo lang('update');?>
</button>
                    </div>
                    
            <?php echo form_close();?>

        </div>    <?php }
}
