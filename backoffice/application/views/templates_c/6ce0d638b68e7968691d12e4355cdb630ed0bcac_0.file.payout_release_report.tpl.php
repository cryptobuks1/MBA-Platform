<?php
/* Smarty version 3.1.30, created on 2020-09-29 11:39:58
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/select_report/payout_release_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f72906e73d853_59297563',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ce0d638b68e7968691d12e4355cdb630ed0bcac' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/select_report/payout_release_report.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f72906e73d853_59297563 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18570272185f72906e72d380_66843077', 'script');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6998808155f72906e73cef8_10787855', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'script'} */
class Block_18570272185f72906e72d380_66843077 extends Smarty_Internal_Block
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
class Block_6998808155f72906e73cef8_10787855 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="error_msg"><?php echo lang('You_must_select_from_date');?>
</span>
    <span id="error_msg1"><?php echo lang('You_must_select_a_date');?>
</span>
    <span id="error_msg2"><?php echo lang('You_must_select_a_date');?>
</span>
    <span id="error_msg4"><?php echo lang('to_date_greater_than_from_date');?>
</span>
    <span id ="error_msg5"><?php echo lang('digits_only');?>
</span>
</div>

<div class="panel panel-default">
  <div class="panel-body">
  <legend><span class="fieldset-legend"><?php echo lang('payout_release_reports');?>
</span></legend>
    <?php echo form_open('user/payout_released_report_daily','role="form" class="" method="post" name="searchform" id="searchform"  target="_blank"');?>

      <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label class="required" for="week_date1"><?php echo lang('released_date');?>
</label>
        <input class="form-control date-picker" name="week_date1" id="week_date1" onchange="myFunction()" type="text" value="">
        <?php if ($_smarty_tpl->tpl_vars['error_count']->value && isset($_smarty_tpl->tpl_vars['error_array']->value['week_date1'])) {
echo $_smarty_tpl->tpl_vars['error_array']->value['week_date1'];
}?>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group credit_debit_button">
      <button class="btn btn-primary" id="payout_released" name="payout_released" type="submit" value="<?php echo lang('view');?>
"><?php echo lang('view');?>
</button>
      </div>
      </div>
    <?php echo form_close();?>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
  <legend><span class="fieldset-legend"><?php echo lang('payout_release_reports');?>
</span></legend>
    <?php echo form_open('user/payout_released_report_weekly','role="form" class="" method="post" name="searchform2" id="searchform2"  target="_blank"');?>

      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label ><?php echo lang('from_date');?>
</label>
         <input autocomplete="off" class="form-control date-picker" id="from_date_weekly" name="from_date_weekly" type="text" value="">
        <?php if ($_smarty_tpl->tpl_vars['error_count']->value && isset($_smarty_tpl->tpl_vars['error_array']->value['from_date_weekly'])) {
echo $_smarty_tpl->tpl_vars['error_array']->value['from_date_weekly'];
}?>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group">
        <label ><?php echo lang('to_date');?>
</label>
        <input autocomplete="off" class="form-control date-picker" id="to_date_weekly" name="to_date_weekly" type="text" value="">
        <?php if ($_smarty_tpl->tpl_vars['error_count']->value && isset($_smarty_tpl->tpl_vars['error_array']->value['to_date_weekly'])) {
echo $_smarty_tpl->tpl_vars['error_array']->value['to_date_weekly'];
}?>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group credit_debit_button">
        <button class="btn btn-primary" type="submit" name="payout_released" value="<?php echo lang('view');?>
"><?php echo lang('view');?>
</button>
        <input type="hidden" name="payout_type" value="from_to_released">
      </div>
      </div>
    <?php echo form_close();?>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
  <legend><span class="fieldset-legend"><?php echo lang('payout_pending_report');?>
</span></legend>
    <?php echo form_open('user/payout_pending_report_weekly','role="form" class="" method="post" name="searchform1" id="searchform1"  target="_blank"');?>

      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label for="from_date_pending">
                        <?php echo lang('from_date');?>

                    </label>
        <input autocomplete="off" class="form-control date-picker" id="from_date_pending" name="from_date_pending" type="text" value="">
        <?php if ($_smarty_tpl->tpl_vars['error_count']->value && isset($_smarty_tpl->tpl_vars['error_array']->value['from_date_pending'])) {
echo $_smarty_tpl->tpl_vars['error_array']->value['from_date_pending'];
}?>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group">
        <label ><?php echo lang('to_date');?>
</label>
        <input autocomplete="off" class="form-control date-picker" id="to_date_pending" name="to_date_pending" type="text"  size="20" maxlength="10"  value="" >
        <?php if ($_smarty_tpl->tpl_vars['error_count']->value && isset($_smarty_tpl->tpl_vars['error_array']->value['to_date_pending'])) {
echo $_smarty_tpl->tpl_vars['error_array']->value['to_date_pending'];
}?>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group credit_debit_button">
      <button class="btn btn-primary" name="payout_released" type="submit" value="<?php echo lang('view');?>
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
