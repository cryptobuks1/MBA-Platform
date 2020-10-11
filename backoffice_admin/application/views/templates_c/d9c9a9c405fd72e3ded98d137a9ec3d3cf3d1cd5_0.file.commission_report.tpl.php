<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:23:17
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/commission_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f296145e51bb9_06286428',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd9c9a9c405fd72e3ded98d137a9ec3d3cf3d1cd5' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/commission_report.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f296145e51bb9_06286428 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7816878975f296145e511e2_98721377', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_7816878975f296145e511e2_98721377 extends Smarty_Internal_Block
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
    <span id="error_msg4"><?php echo lang('you_must_select_a_to_date_greater_than_from_date');?>
</span>
    <span id="error_msg5"><?php echo lang('digits_only');?>
</span>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <?php echo form_open('admin/commission_report_view','role="form" class="" method="post" name="commision_form" id="commision_form" target="_blank" onsubmit="return validation()"');?>

        <div class="col-sm-3 padding_both">
        <div class="form-group">
            <label><?php echo lang('user_name');?>
</label>
            <input type="text" class="form-control user_autolist" id="user_name" name="user_name" autocomplete="Off">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label><?php echo lang('from_date');?>
</label>
            <input dautocomplete="off" class="form-control date-picker" name="from_date" id="from_date" type="text" size="20" maxlength="10" value=""> <?php if ($_smarty_tpl->tpl_vars['error_count']->value && isset($_smarty_tpl->tpl_vars['error_array']->value['from_date'])) {
echo $_smarty_tpl->tpl_vars['error_array']->value['from_date'];
}?>
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label><?php echo lang('to_date');?>
</label>
            <input autocomplete="off" class="form-control date-picker" name="to_date" id="to_date" type="text" size="20" maxlength="10" value=""> <?php if ($_smarty_tpl->tpl_vars['error_count']->value && isset($_smarty_tpl->tpl_vars['error_array']->value['to_date'])) {
echo $_smarty_tpl->tpl_vars['error_array']->value['to_date'];
}?>
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label class="required"><?php echo lang('amount_type');?>
</label>
            <select multiple name="amount_type[]" id="amount_type" class="form-control">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['commission_types']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo lang($_smarty_tpl->tpl_vars['v']->value);?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </select>
        </div>
        </div>
        <div class="form-group credit_debit_button">
            <button class="btn btn-primary" name="commision" type="submit" value="<?php echo lang('submit');?>
">
                <?php echo lang('submit');?>
</button>
        </div>
        <?php echo form_close();?>

    </div>
</div>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
