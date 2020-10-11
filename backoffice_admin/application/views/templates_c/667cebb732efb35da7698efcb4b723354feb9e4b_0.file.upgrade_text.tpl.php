<?php
/* Smarty version 3.1.30, created on 2020-08-17 13:18:18
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/upgrade_text.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f39f6fa8bfb13_31434321',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '667cebb732efb35da7698efcb4b723354feb9e4b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/upgrade_text.tpl',
      1 => 1577180165,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 2,
  ),
),false)) {
function content_5f39f6fa8bfb13_31434321 (Smarty_Internal_Template $_smarty_tpl) {
?>
 <div class="content">
            <?php echo form_open('','role="form" class="" name="reg_mail_settings" id="reg_mail_settings"');?>

                <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
                   
                  <?php echo form_open_multipart('admin/configuration/content_management','role="form" class="" name= "terms_form"  id="terms_form"');?>
                                             
               
                    <div class="panel-body">
                    <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea"><?php echo lang('main_matter');?>
</label>
                                <textarea class="ckeditor form-control"  id="content_terms"  name="content_terms" title="<?php echo lang('main_matter');?>
"  rows="6"><?php if (isset($_smarty_tpl->tpl_vars['content']->value['upgrade_note'])) {
echo $_smarty_tpl->tpl_vars['content']->value['upgrade_note'];
} else { ?>
                                All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more<?php }?></textarea>
                                <?php echo form_error('content_terms');?>

                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="submit_upgrade_text" id="submit_upgrade_text" type="submit" value="<?php echo lang('update');?>
" > <?php echo lang('update');?>
</button>
                        </div>
                    </div>   
              
            
                    
            <?php echo form_close();?>

        </div>    <?php }
}
