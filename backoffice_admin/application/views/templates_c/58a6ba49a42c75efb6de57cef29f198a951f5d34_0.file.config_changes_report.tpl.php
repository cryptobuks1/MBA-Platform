<?php
/* Smarty version 3.1.30, created on 2020-08-06 13:34:12
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/config_changes_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2b7a34429435_71744688',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '58a6ba49a42c75efb6de57cef29f198a951f5d34' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/config_changes_report.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2b7a34429435_71744688 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9336295155f2b7a3441f6b7_12413970', 'script');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2559123315f2b7a34428c45_00637123', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'script'} */
class Block_9336295155f2b7a3441f6b7_12413970 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<?php echo '<script'; ?>
>
    jQuery(document).ready(function() {
        ValidateCommissionReport.init();
    });
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2559123315f2b7a34428c45_00637123 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

 <div id="span_js_messages" style="display:none;">
    <span id="error_msg"><?php echo lang('you_must_select_from_date');?>
</span>
    <span id="error_msg1"><?php echo lang('you_must_select_to_date');?>
</span>
    <span id="error_msg2"><?php echo lang('you_must_select_from_to_date_correctly');?>
</span>
    <span id="error_msg3"><?php echo lang('you_must_select_product');?>
</span>
    <span id ="error_msg4"><?php echo lang('from_date_greater_than_to_date');?>
</span>
    <span id ="error_msg5"><?php echo lang('digits_only');?>
</span>
    <span id ="error_msg6"><?php echo lang('digits_dot');?>
</span>
</div>
 <div class="panel panel-default">
  <div class="panel-body">
    <?php echo form_open('admin/config_changes_report_view','role="form" class="" method="post"    name="commision_form" id="commision_form" target="_blank" ');?>

      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label ><?php echo lang('start_date');?>
</label>
        <input class="form-control date-picker" name="from_date" id="from_date" type="text" size="20" maxlength="10" >
      <?php if (isset($_smarty_tpl->tpl_vars['error_array_date']->value['start_date'])) {
echo $_smarty_tpl->tpl_vars['error_array_date']->value['start_date'];
}?>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group">
        <label ><?php echo lang('end_date');?>
</label>
        <input class="form-control date-picker" name="to_date" id="to_date" type="text" size="20" maxlength="10" >
      <?php if (isset($_smarty_tpl->tpl_vars['error_array_date']->value['end_date'])) {
echo $_smarty_tpl->tpl_vars['error_array_date']->value['end_date'];
}?>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
            <div class="form-group">
        <label ><?php echo lang('ip_address');?>
</label>
        <input type="text" name="ip_address" id="ip_address" size="20" class="form-control">
                                <span id="ip_address_err"></span>
                                <?php if (isset($_smarty_tpl->tpl_vars['error_array_date']->value['ip_address'])) {
echo $_smarty_tpl->tpl_vars['error_array_date']->value['ip_address'];
}?>
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
      <div class="form-group credit_debit_button">
      <button class="btn btn-primary" type="submit" id="submit_date" value="submit_date" name="submit_date">
                                <?php echo lang('submit');?>

                            </button>

                    <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
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
