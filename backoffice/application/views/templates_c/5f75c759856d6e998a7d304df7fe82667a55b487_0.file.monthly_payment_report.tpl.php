<?php
/* Smarty version 3.1.30, created on 2020-09-28 15:31:06
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/report/monthly_payment_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f71751adee751_20398718',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5f75c759856d6e998a7d304df7fe82667a55b487' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/report/monthly_payment_report.tpl',
      1 => 1574057840,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f71751adee751_20398718 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2513161485f71751adecdb4_18064859', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8752760165f71751adee422_02146826', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2513161485f71751adecdb4_18064859 extends Smarty_Internal_Block
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
        <?php ob_start();
echo $_smarty_tpl->tpl_vars['SHORT_URL']->value;
$_prefixVariable1=ob_get_clean();
echo form_open($_prefixVariable1,'role="form" class="" name="search_member" id="search_member"
        action="" method="post"');?>

        <input type="hidden" id="search_member_error" value="<?php echo lang('search_member_error');?>
" />
        <input type="hidden" id="search_member_error2" value="<?php echo lang('invalid_user_name');?>
" />
        

        
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required" for="week_date1"><?php echo lang('from_date');?>
</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required"><?php echo lang('to_date');?>
</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> 
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
</div>
        
   <?php if ($_smarty_tpl->tpl_vars['count']->value >= 1) {?>
           
            <div class="panel panel-default table-responsive">
            <div class="panel-body">
             <legend><span class="fieldset-legend"><?php echo lang('monthly_payment_report');?>
</span></legend>
                <?php $_smarty_tpl->_assignInScope('i', "1");
?> 
                 
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                    <th><?php echo lang('slno');?>
</th>
                    <th><?php echo lang('username');?>
</th>
                    <th><?php echo lang('fullname');?>
</th>
                    <th><?php echo lang('amount_paid');?>
</th>
                    <th><?php echo lang('paid_date');?>
</th>
                   <!-- <th><?php echo lang('previous_end_date');?>
</th>-->
                   
                    <th><?php echo lang('payment_method');?>
</th>
                     <th><?php echo lang('Subscription Mode');?>
</th>
                    </thead>
                    <tbody>
                        <?php $_smarty_tpl->_assignInScope('i', 1);
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
               <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['fullname'];?>
</td>
                <td> <?php echo $_smarty_tpl->tpl_vars['v']->value['amount_paid'];?>
</td>
                <td><?php echo date('Y-m-d',strtotime($_smarty_tpl->tpl_vars['v']->value['paid_date']));?>
</td>
                <!--<td><?php echo date('Y-m-d',strtotime($_smarty_tpl->tpl_vars['v']->value['previous_subscription_end_date']));?>
</td>-->
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paid_type'];?>
</td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['payment_method'] == "stripe") {?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['paid_type'] == 'Stripe Recurring') {?>
                        <?php echo lang('Automatic');
} else {
echo lang('Skipped');
}?>
                 <?php }?>
                </td>
                
                   </tr>
            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
   <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </tbody>
                </table>  
                </div>
            </div>
        
   <?php } else { ?>
         <div style="text-align: center">  <h3><?php echo lang('no_data');?>
</h3></div>
    <?php }?>
        
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_8752760165f71751adee422_02146826 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

     
     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['SHORT_URL']->value;?>
javascript/main.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
