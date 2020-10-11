<?php
/* Smarty version 3.1.30, created on 2020-08-05 10:00:09
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/total_joining_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f29f689151cf4_03722231',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2c85d983cf404f4e9f708e7e6a6f782d047ed75e' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/total_joining_report.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 2,
  ),
),false)) {
function content_5f29f689151cf4_03722231 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16477040035f29f689151241_27386731', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_16477040035f29f689151241_27386731 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="error_msg"><?php echo lang('You_must_select_from_date');?>
</span>
    <span id="error_msg1"><?php echo lang('You_must_select_to_date');?>
</span>
    <span id="error_msg2"><?php echo lang('You_must_Select_From_To_Date_Correctly');?>
</span>
    <span id="error_msg3"><?php echo lang('You_must_select_a_date');?>
</span>
    <span id="error_msg4"><?php echo lang('you_must_select_a_to_date_greater_than_from_date');?>
</span>
    <span id="error_msg5"><?php echo lang('digits_only');?>
</span>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend"><?php echo lang('daily_joining');?>
</span></legend>
        <?php echo form_open('admin/total_joining_daily','role="form" class="" method="post" name="daily" id="daily" target="__blank"');?>
 <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="date"><?php echo lang('date');?>
</label>
                <input autocomplete="off" class="form-control date-picker" name="date" id="date" type="text" value=""> <?php if ($_smarty_tpl->tpl_vars['error_count']->value && isset($_smarty_tpl->tpl_vars['error_array']->value['date'])) {
echo $_smarty_tpl->tpl_vars['error_array']->value['date'];
}?>
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="dailydate" type="submit" value="<?php echo lang('submit');?>
"> <?php echo lang('submit');?>
 </button>
            </div>
        </div>
        <?php echo form_close();?>

    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend"><?php echo lang('weekly_joining');?>
</span></legend>
        <?php echo form_open('admin/total_joining_weekly','role="form" class="" method="post" name="weekly_join" id="weekly_join" target="__blank" onsubmit= "return dateValidation()"');?>
 <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="week_date1"><?php echo lang('from_date');?>
</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value=""> <?php if ($_smarty_tpl->tpl_vars['error_count_weekly']->value && isset($_smarty_tpl->tpl_vars['error_array_weekly']->value['week_date1'])) {
echo $_smarty_tpl->tpl_vars['error_array_weekly']->value['week_date1'];
}?>
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required"><?php echo lang('to_date');?>
</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> <?php if ($_smarty_tpl->tpl_vars['error_count_weekly']->value && isset($_smarty_tpl->tpl_vars['error_array_weekly']->value['week_date2'])) {
echo $_smarty_tpl->tpl_vars['error_array_weekly']->value['week_date2'];
}?>
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="weekdate" type="submit" value="<?php echo lang('submit');?>
"> <?php echo lang('submit');?>
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
