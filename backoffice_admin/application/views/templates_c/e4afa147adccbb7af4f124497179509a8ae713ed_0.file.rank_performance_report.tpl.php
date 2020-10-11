<?php
/* Smarty version 3.1.30, created on 2020-09-15 15:36:42
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/rank_performance_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6052eaaf9a72_60622833',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e4afa147adccbb7af4f124497179509a8ae713ed' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/rank_performance_report.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f6052eaaf9a72_60622833 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18565285225f6052eaaf2ed0_03188470', 'script');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15311449125f6052eaaf9467_22825077', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'script'} */
class Block_18565285225f6052eaaf2ed0_03188470 extends Smarty_Internal_Block
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
    });
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_15311449125f6052eaaf9467_22825077 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="error_msg"><?php echo lang('You_must_enter_user_name');?>
</span>
    <span id="error_msg1"><?php echo lang('You_must_select_to_date');?>
</span>
    <span id="errmsg4"><?php echo lang('You_must_Select_From_To_Date_Correctly');?>
</span>
    <span id="error_msg7"><?php echo lang('invalid_user_name');?>
</span>
    <span id ="error_msg4"><?php echo lang('You_must_select_a_Todate_greaterThan_Fromdate');?>
</span>
    <span id ="error_msg5"><?php echo lang('digits_only');?>
</span>
</div>
 <div class="panel panel-default">
  <div class="panel-body">
    <?php echo form_open('admin/report/rank_performance_report','role="form" class="" method="post" name="user" id="searchform" target="__blank"');?>

      <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label class="required" for="user_name"><?php echo lang('user_name');?>
</label>
         <input type="text" class="form-control user_autolist" id="user_name" name="user_name" autocomplete="Off">
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group credit_debit_button">
        <button class="btn btn-primary" name="user_submit" type="submit" value="<?php echo lang('view');?>
"><?php echo lang('view');?>
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
