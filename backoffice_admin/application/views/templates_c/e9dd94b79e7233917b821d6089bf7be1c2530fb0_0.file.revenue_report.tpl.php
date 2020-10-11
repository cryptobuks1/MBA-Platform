<?php
/* Smarty version 3.1.30, created on 2020-09-15 15:36:19
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/revenue_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6052d33c00b9_01490014',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9dd94b79e7233917b821d6089bf7be1c2530fb0' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/revenue_report.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6052d33c00b9_01490014 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2181643015f6052d33be5d9_72579548', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21381974235f6052d33bfc64_97949568', 'script');
?>



<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2181643015f6052d33be5d9_72579548 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1"><?php echo lang('You_must_enter_amount');?>
</span>
        <span id="error_msg2"><?php echo lang('You_must_enter_description');?>
</span>
        <span id="error_msg3"><?php echo lang('digits_only');?>
</span>
        <span id="error_msg4"><?php echo lang('Please_select_month');?>
</span> 
        <span id="error_msg5"><?php echo lang('Please enter no more than 10 digits');?>
</span> 
    </div> 
   
    <div class="panel panel-default">
        <div class="panel-body">
         <legend><span class="fieldset-legend"><?php echo lang('add_new_expense');?>
</span></legend>
            <?php echo form_open('','role="form" class="" name="form" id="form" action="" method="post"');?>

            
            <div class="form-group">
                <label class="required"><?php echo lang('amount');?>
</label>

                <input type="text" class="form-control" name='amount' id='amount'>
                <?php echo form_error('amount');?>

            </div>
            
            
            <div class="form-group">
                <label class="required" ><?php echo lang('description');?>
</label>

                <textarea class="form-control" name='description' id='description'> </textarea>

            </div>  
            
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name='new_expense' id='new_expense' value='submit'><?php echo lang('add');?>
</button>
            </div>
             
            <?php echo form_close();?>

        </div>
    </div>
   
    <div class="panel panel-default">
        <div class="panel-body">
         <legend><span class="fieldset-legend"><?php echo lang('select_month');?>
</span></legend>
            <?php echo form_open('','role="form" class="" name="dateform" id="dateform" method="post"');?>

            <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required"><?php echo lang('date');?>
</label>
                <input  autocomplete="off"  class="form-control date-picker" type="text"  size="70" maxlength="10" name='weekdate' id='weekdate' data-zdp_format='Y-m'>
                <span><?php echo form_error('weekdate');?>
</span>
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group m-t-t-t">
                <button type="submit" class="btn btn-primary"  id="submit" value="submit" name="submit" ><?php echo lang('submit');?>
</button>
            </div>
            
            </div>
            <?php echo form_close();?>

        </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['details']->value['nodata'] != "yes") {?>
        
        <div class="panel panel-default table-responsive">
        <div class="panel-body">
        <legend><span class="fieldset-legend"><?php echo lang('monthly_revenue_report');?>
</span></legend>
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                <th><?php echo lang('income');?>
</th>
                <th><?php echo lang('expense');?>
</th>
                <th><?php echo lang('other_expenses');?>
</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['details']->value["amount_credit"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['details']->value["amount_debit"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['details']->value["total_other_exp"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                    </tr>
                    <tr>
                        <td  class="text-right" colspan='2'><b><?php echo lang('total_profit');?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['details']->value["profit"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</b></td>
                    </tr>
                </tbody>
            </table>  
            </div>
        </div> 
        <?php if (count($_smarty_tpl->tpl_vars['details']->value['other_expenses']) > 0) {?>
           
            <div class="panel panel-default table-responsive">
            <div class="panel-body">
             <legend><span class="fieldset-legend"><?php echo lang('other_expense_details');?>
</span></legend>
                <?php $_smarty_tpl->_assignInScope('i', "1");
?> 
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                    <th><?php echo lang('slno');?>
</th>
                    <th><?php echo lang('amount');?>
</th>
                    <th><?php echo lang('description');?>
</th>
                    <th><?php echo lang('date_added');?>
</th>
                    </thead>
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value["other_expenses"], 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['description'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['date'];?>
</td>
                            </tr>
                            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        <tr>
                            <td colspan='3' class="text-right"><b><?php echo lang('total_expenses');?>
</b></td>
                            <td><b><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['details']->value["total_other_exp"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</b></td>
                        </tr>
                    </tbody>
                </table>  
                </div>
            </div>
        <?php }?>
        <?php } else { ?>
         <div style="text-align: center">  <h3><?php echo lang('no_data');?>
</h3></div>
    <?php }
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_21381974235f6052d33bfc64_97949568 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>
 
    <?php echo '<script'; ?>
>
        jQuery(document).ready(function () {
            ValidateExpense.init();
        });
    <?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
