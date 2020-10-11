<?php
/* Smarty version 3.1.30, created on 2020-08-16 22:58:40
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/payout/mark_paid.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f392d8035b2b0_95615286',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd0fae7cb459cc6069e25463834c24d30d6b479e2' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/payout/mark_paid.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f392d8035b2b0_95615286 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5813617695f392d8035a735_99885776', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_5813617695f392d8035a735_99885776 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display: none;">
    <span id="error_msg"><?php echo lang('please_select_at_least_one_checkbox');?>
</span>
    <span id="errmsg1"><?php echo lang('You_must_select_a_date');?>
</span>
    <span id="errmsg2"><?php echo lang('You_must_select_from_date');?>
</span>
    <span id="errmsg3"><?php echo lang('You_must_select_to_date');?>
</span>
    <span id="errmsg4"><?php echo lang('You_must_Select_From_To_Date_Correctly');?>
</span>
    <span id="row_msg"><?php echo lang('rows');?>
</span>
    <span id="show_msg"><?php echo lang('shows');?>
</span>
    <span id="msg"> <?php echo lang('from_date_greater_than_to_date');?>
</span>
</div>
 
  <div class="m-b pink-gradient">
  <div class="card-body ">
    <div class="media">
      <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
      <div class="media-body">
        <h6 class="my-0"><?php echo lang('note_payout_confirm_bank_transfer');?>
</h6>
      </div>
    </div>
  </div>
</div>
 

 
 

<div class="panel panel-default">
  <div class="panel-body">
    <?php echo form_open('','role="form" class="" name="date_submit" id="date_submit" method="post" ');?>

      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label class="required"><?php echo lang('start_date');?>
</label>
        <input type="text"  autocomplete="off"  class="form-control date-picker" name="start_date" id="start_date" type="text"  size="70" maxlength="10" >
        <span><?php echo form_error('start_date');?>
</span>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group">
        <label class="required"><?php echo lang('end_date');?>
</label>
        <input  autocomplete="off"  class="form-control date-picker" name="end_date" id="end_date" type="text"  size="70" maxlength="10">
        <span><?php echo form_error('end_date');?>
</span>
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group">
      <div class="form-group mark_paid">
        <button type="submit" class="btn btn-primary"  id="submit_date" value="submit_date" name="submit_date" ><?php echo lang('submit');?>
</button>
      </div>
      </div>
      </div>
    <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
                <?php echo form_close();?>

  </div>
</div>
<?php echo form_open('admin/mark_paid','role="form" name="mark_payout" id="mark_payout" method="post"');?>

<div class="panel panel-default ng-scope">
<div class="panel-body">
<div class="table-responsive">
  <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><?php echo lang('sl_no');?>
</th>
        <th><?php echo lang('user_name');?>
</th>
        <th><?php echo lang('paid_amount');?>
</th>
        <th><?php echo lang('paid_date');?>
</th>
        <th>
        <?php echo lang('mark_as_paid');?>
/<a class="cursor" type="submit" name="check_all" value="Check All" id="check_all" onclick="checkAll();"><?php echo lang('mark_all');?>
</a>
                                <a class="cursor" type="submit" name ="uncheck_all" value="Uncheck All" id="uncheck_all" onclick="uncheckAll();" style="display:none;"><?php echo lang('unmark_all');?>
</a></th>
        </th>
      </tr>
    </thead>
    <tbody>
    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
    <?php if ($_smarty_tpl->tpl_vars['length']->value > 0) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['payout_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                <input type='hidden' name='paid_id<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value = '<?php echo $_smarty_tpl->tpl_vars['v']->value['paid_id'];?>
'>
                    <input type='hidden' name='user_name<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value = '<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
'>
                    <input type='hidden' name='paid_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value = '<?php echo $_smarty_tpl->tpl_vars['v']->value['paid_amount'];?>
'>
                    <input type='hidden' name='paid_date<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value = '<?php echo $_smarty_tpl->tpl_vars['v']->value['paid_date'];?>
'>
      <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['paid_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paid_date'];?>
</td>
        <td><div class="checkbox">
            <label class="i-checks">
              <input type="checkbox" name="mark_paid<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" id="mark_paid<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="release"/>
              <i></i> </label>
          </div></td>
      </tr>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

      <?php } else { ?>
        <tr>
        <tr>
        <td colspan="9" align="center"><h4><?php echo lang('no_payout_found');?>
 </h4></td></tr>
        </tr>
    <?php }?>
    </tbody>
  </table>
  </div>
   <button type="submit" class="btn btn-sm btn-primary" name="marksw" id="marksw" value="marked"><?php echo lang('Confirm');?>
</button>
  </dvi>
   <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

</div>
 
 
  <?php echo form_close();?>


<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
