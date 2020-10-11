<?php
/* Smarty version 3.1.30, created on 2020-09-25 15:23:26
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/profile/edit_profile.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d7ece686699_95076132',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f4c4fdcc7a7cc2f09c332f04609edcd52d665183' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/profile/edit_profile.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d7ece686699_95076132 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14290059375f6d7ece683274_91046838', "script");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1034079145f6d7ece6860e8_79892029', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "script"} */
class Block_14290059375f6d7ece683274_91046838 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/validate_edit_profile.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "script"} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_1034079145f6d7ece6860e8_79892029 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open_multipart('user/profile/update_profileimg_banner','role="form" class="" name= "edit_profile"  id="edit_profile"');?>

            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="control-label  pro-label"><?php echo lang('upload_banner');?>
</label>
                    <div data-provides="fileupload" class="bg_file_upload pro_file_upload">
                        <input name="file2" id="file2" type="file">
                        <label id="fileLabel1"><?php echo lang('select_file');?>
</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="control-label  pro-label"><?php echo lang('upload_profile_photo');?>
</label>
                    <div data-provides="fileupload" class="bg_file_upload pro_file_upload">
                        <input name="file1" id="file1" type="file">
                        <label id="fileLabel2"><?php echo lang('select_file');?>
</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button type="submit" class="btn btn-sm btn-primary"><?php echo lang('update_profile');?>
</button>
                </div>
            </div>
            <?php echo form_close();?>

        </div>
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
