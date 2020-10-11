<?php
/* Smarty version 3.1.30, created on 2020-09-30 14:44:32
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/payout/my_withdrawal_request.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f740d304838a9_20810898',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '96ff429d61fcbd72df9c2799db4782ce06bb239f' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/payout/my_withdrawal_request.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f740d304838a9_20810898 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20313403365f740d304823c8_39540221', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_20313403365f740d304823c8_39540221 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<main>
   <div class="tabsy">
      <input type="radio" id="tab1" name="tab" <?php echo $_smarty_tpl->tpl_vars['tab1']->value;?>
>
      <label class="tabButton" for="tab1"><?php echo lang('active_requests');?>
</label>
      <div class="tab">
         <div class="content">
            <div class="panel panel-default ng-scope">
               <?php if (count($_smarty_tpl->tpl_vars['active_requests']->value) > 0) {?>
               <input type="hidden" name="current_tab" id="current_tab" value="tab1" >
               <div class="table-responsive ">
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <thead class="table-bordered">
                     <tr class="th">
                        <th><?php echo lang('sl_no');?>
</th>
                        <th><?php echo lang('requested_date');?>
</th>
                        <th><?php echo lang('requested_amount');?>
</th>
                        <th><?php echo lang('payout_method');?>
</th>
                        <th><?php echo lang('balance_amount');?>
</th>
                     </tr>
                  </thead>
                  <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                  <?php $_smarty_tpl->_assignInScope('class', '');
?>
                  <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/");
?>
                  <tbody>
                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['active_requests']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                     <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>
                     <?php $_smarty_tpl->_assignInScope('class', 'tr1');
?>
                     <?php } else { ?>
                     <?php $_smarty_tpl->_assignInScope('class', 'tr2');
?>
                     <?php }?>
                     <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                        <td>
                           <?php echo $_smarty_tpl->tpl_vars['page1']->value+$_smarty_tpl->tpl_vars['i']->value+1;?>

                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['requested_date'];?>
</td>
                        <td>
                           <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['payout_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

                        </td>
                        <td><?php if ($_smarty_tpl->tpl_vars['v']->value['payout_type'] == 'bank') {?>
                           Bank
                           <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['payout_type'] == 'Bitcoin') {?>
                           Blocktrail
                           <?php } else { ?>      
                           <?php echo $_smarty_tpl->tpl_vars['v']->value['payout_type'];?>

                           <?php }?>
                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['balance_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

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
               <?php echo $_smarty_tpl->tpl_vars['result_per_page1']->value;?>

               <?php } else { ?>
               <h4 align="center"><?php echo lang('no_payout_found');?>
</h4>
               <?php }?>
            </div>
         </div>
      </div>
      <input type="radio" id="tab2" name="tab" <?php echo $_smarty_tpl->tpl_vars['tab2']->value;?>
>
      <label class="tabButton" for="tab2"><?php echo lang('approved_waiting_for_transfer');?>
</label>
      <div class="tab">
         <div class="content">
            <div class="panel panel-default ng-scope">
               <?php if (count($_smarty_tpl->tpl_vars['waiting_requests']->value) > 0) {?>
               <input type="hidden" name="current_tab" id="current_tab" value="tab2" >
               <div class="table-responsive ">
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <thead class="table-bordered">
                     <tr class="th">
                        <th><?php echo lang('sl_no');?>
</th>
                        <th><?php echo lang('approved_date');?>
</th>
                        <th><?php echo lang('Payout_Amount');?>
</th>
                        <th><?php echo lang('payout_method');?>
</th>
                     </tr>
                  </thead>
                  <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                  <?php $_smarty_tpl->_assignInScope('class', '');
?>
                  <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/");
?>
                  <tbody>
                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['waiting_requests']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                     <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>
                     <?php $_smarty_tpl->_assignInScope('class', 'tr1');
?>
                     <?php } else { ?>
                     <?php $_smarty_tpl->_assignInScope('class', 'tr2');
?>
                     <?php }?>
                     <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                        <td><?php echo $_smarty_tpl->tpl_vars['page2']->value+$_smarty_tpl->tpl_vars['i']->value+1;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paid_date'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['paid_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        <td>
                           <?php if ($_smarty_tpl->tpl_vars['v']->value['payment_method'] == 'bank') {?>
                           Bank
                           <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['payment_method'] == 'Bitcoin') {?>
                           Blocktrail
                           <?php } else { ?>      
                           <?php echo $_smarty_tpl->tpl_vars['v']->value['payment_method'];?>

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
               <?php echo $_smarty_tpl->tpl_vars['result_per_page2']->value;?>

               <?php } else { ?>
               <h4 align="center"><?php echo lang('no_payout_found');?>
</h4>
               <?php }?>
            </div>
         </div>
      </div>
      <input type="radio" id="tab3" name="tab" <?php echo $_smarty_tpl->tpl_vars['tab3']->value;?>
>
      <label class="tabButton" for="tab3"><?php echo lang('approved_paid');?>
</label>
      <div class="tab">
         <div class="content">
            <div class="panel panel-default ng-scope">
               <?php if (count($_smarty_tpl->tpl_vars['paid_requests']->value) > 0) {?>
               <input type="hidden" name="current_tab" id="current_tab" value="tab3" >
               <div class="table-responsive">
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <thead class="table-bordered">
                     <tr class="th">
                        <th><?php echo lang('sl_no');?>
</th>
                        <th><?php echo lang('paid_date');?>
</th>
                        <th><?php echo lang('Payout_Amount');?>
</th>
                        <th><?php echo lang('payout_method');?>
</th>
                     </tr>
                  </thead>
                  <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                  <?php $_smarty_tpl->_assignInScope('class', '');
?>
                  <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/");
?>
                  <tbody>
                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['paid_requests']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                     <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>
                     <?php $_smarty_tpl->_assignInScope('class', 'tr1');
?>
                     <?php } else { ?>
                     <?php $_smarty_tpl->_assignInScope('class', 'tr2');
?>
                     <?php }?>
                     <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                        <td><?php echo $_smarty_tpl->tpl_vars['page3']->value+$_smarty_tpl->tpl_vars['i']->value+1;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paid_date'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['paid_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

                        </td>
                        <td>
                           <?php if ($_smarty_tpl->tpl_vars['v']->value['payment_method'] == 'bank') {?>
                           Bank
                           <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['payment_method'] == 'Bitcoin') {?>
                           Blocktrail
                           <?php } else { ?>      
                           <?php echo $_smarty_tpl->tpl_vars['v']->value['payment_method'];?>

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
               <?php echo $_smarty_tpl->tpl_vars['result_per_page3']->value;?>

               <?php } else { ?>
               <h4 align="center"><?php echo lang('no_payout_found');?>
</h4>
               <?php }?>
            </div>
         </div>
      </div>
      <input type="radio" id="tab4" name="tab" <?php echo $_smarty_tpl->tpl_vars['tab4']->value;?>
>
      <label class="tabButton" for="tab4"><?php echo lang('rejected_requests');?>
</label>
      <div class="tab">
         <div class="content">
            <div class="panel panel-default  ng-scope">
               <?php if (count($_smarty_tpl->tpl_vars['rejected_requests']->value) > 0) {?>
               <input type="hidden" name="current_tab" id="current_tab" value="tab1" >
               <div class="table-responsive">
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                  <thead class="table-bordered">
                     <tr class="th">
                        <th><?php echo lang('sl_no');?>
</th>
                        <th><?php echo lang('requested_date');?>
</th>
                        <th><?php echo lang('rejected_date');?>
</th>
                        <th><?php echo lang('requested_amount');?>
</th>
                        <th><?php echo lang('payout_method');?>
</th>
                     </tr>
                  </thead>
                  <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                  <?php $_smarty_tpl->_assignInScope('class', '');
?>
                  <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/");
?>
                  <tbody>
                     <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rejected_requests']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                     <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>
                     <?php $_smarty_tpl->_assignInScope('class', 'tr1');
?>
                     <?php } else { ?>
                     <?php $_smarty_tpl->_assignInScope('class', 'tr2');
?>
                     <?php }?>
                     <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                        <td>
                           <?php echo $_smarty_tpl->tpl_vars['page4']->value+$_smarty_tpl->tpl_vars['i']->value+1;?>

                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['requested_date'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['updated_date'];?>
</td>
                        <td>
                           <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['payout_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

                        </td>
                        <td>
                           <?php if ($_smarty_tpl->tpl_vars['v']->value['payout_type'] == 'bank') {?>
                           Bank
                           <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['payout_type'] == 'Bitcoin') {?>
                           Blocktrail
                           <?php } else { ?>      
                           <?php echo $_smarty_tpl->tpl_vars['v']->value['payout_type'];?>

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
               <?php echo $_smarty_tpl->tpl_vars['result_per_page4']->value;?>

               <?php } else { ?>
               <h4 align="center"><?php echo lang('no_payout_found');?>
</h4>
               <?php }?>
            </div>
         </div>
      </div>
   </div>
</main>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
