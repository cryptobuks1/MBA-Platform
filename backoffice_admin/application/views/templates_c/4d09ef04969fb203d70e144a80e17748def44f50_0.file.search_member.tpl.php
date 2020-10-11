<?php
/* Smarty version 3.1.30, created on 2020-08-05 18:55:33
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/search_member.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a7405e84461_47563174',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d09ef04969fb203d70e144a80e17748def44f50' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/search_member.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2a7405e84461_47563174 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php ob_start();
echo $_smarty_tpl->tpl_vars['SHORT_URL']->value;
$_prefixVariable1=ob_get_clean();
echo form_open($_prefixVariable1,'role="form" class="" name="search_member" id="search_member"
        action="" method="post"');?>

        <input type="hidden" id="search_member_error" value="<?php echo lang('search_member_error');?>
" />
        <input type="hidden" id="search_member_error2" value="<?php echo lang('invalid_user_name');?>
" />
        

        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="user_name"><?php echo lang('user_name');?>
</label>
                <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
                <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit"
                    name="search_member_submit">
                    <?php echo lang('search');?>

                </button>
            </div>
        </div>
        <?php echo form_close();?>

    </div>
</div><?php }
}
