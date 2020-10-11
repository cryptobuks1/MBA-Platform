<?php
/* Smarty version 3.1.30, created on 2020-09-27 16:57:12
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/my_transfer_details.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f7037c84b7417_58794199',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dba1bb00be454fe0cb13abf55661cf8c195b199d' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/my_transfer_details.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f7037c84b7417_58794199 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12000502525f7037c84b53f1_27938284', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13735366135f7037c84b6ef1_40949485', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_12000502525f7037c84b53f1_27938284 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1"><?php echo lang('you_must_select_user');?>
</span>
    <span id="error_msg2"><?php echo lang('You_must_select_a_date');?>
</span>
    <span id="error_msg3"><?php echo lang('invalid_period');?>
</span>
    <span id="error_msg4"><?php echo lang('You_must_select_a_Todate_greaterThan_Fromdate');?>
</span>
    <span id="error_msg5"><?php echo lang('digits_only');?>
</span>
</div>

<div class="panel panel-default">
    <?php echo form_open('user/my_transfer_details','role="form" class="" name="weekly_join" id="weekly_join" action="" method="post"');?>

    <div class="panel-body">
    <legend> <span class="fieldset-legend"> <?php echo lang('weekly_transfer');?>
 </span> </legend>
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="letter_width" for="fb_count"><?php echo lang('from_date');?>
</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="1" size="70">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="letter_width" for="fb_count"><?php echo lang('to_date');?>
</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="2" size="70">
            </div>
        </div>
        <div class="col-sm-4 padding_both_small ">
            <button class="btn btn-sm btn-primary mark_paid_1" type="submit" id="weekdate" value="profile_update" name="weekdate" tabindex="3"><?php echo lang('submit');?>
</button>
        </div>
    </div>
    <?php echo form_close();?>

</div>
<?php if ($_smarty_tpl->tpl_vars['weekdate']->value || $_smarty_tpl->tpl_vars['weekly_session']->value == 1) {?>

<div class=" panel-default">

        <?php $_smarty_tpl->_assignInScope('count', '');
?> <?php $_smarty_tpl->_assignInScope('i', "0");
?> <?php $_smarty_tpl->_assignInScope('amount', '');
?> <?php $_smarty_tpl->_assignInScope('date', '');
?> <?php $_smarty_tpl->_assignInScope('amount_type', '');
?> <?php $_smarty_tpl->_assignInScope('class', '');
?> <?php $_smarty_tpl->_assignInScope('count', $_smarty_tpl->tpl_vars['details_count']->value);
?> 
        </br>
        <div class="panel panel-default table-responsive">
        <div class="panel-body">
        <legend> <span class="fieldset-legend"><?php echo lang('weekly_transfer_details');?>
 </span> </legend>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="sample_1">
                <thead class="table-bordered">
                    <tr class="th">
                        <th><?php echo lang('slno');?>
</th>
                        
                        <th><?php echo lang('transaction_id');?>
</th>
                        <th><?php echo lang('amount');?>
</th>
                        <th><?php echo lang('transaction_fee');?>
</th>
                        <th><?php echo lang('transaction_note');?>
</th>
                        <th><?php echo lang('transfer_type');?>
</th>
                        <th><?php echo lang('date');?>
</th>

                    </tr>
                </thead>
                <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', 1);
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?> <?php $_smarty_tpl->_assignInScope('amount', $_smarty_tpl->tpl_vars['v']->value['total_amount']);
?> <?php $_smarty_tpl->_assignInScope('date', $_smarty_tpl->tpl_vars['v']->value['date']);
?> <?php $_smarty_tpl->_assignInScope('amount_type', $_smarty_tpl->tpl_vars['v']->value['amount_type']);
?> <?php $_smarty_tpl->_assignInScope('trans_fee', $_smarty_tpl->tpl_vars['v']->value['trans_fee']);
?> <?php $_smarty_tpl->_assignInScope('transaction_id', $_smarty_tpl->tpl_vars['v']->value['transaction_id']);
?> <?php $_smarty_tpl->_assignInScope('transaction_note', $_smarty_tpl->tpl_vars['v']->value['transaction_note']);
?> <?php if ($_smarty_tpl->tpl_vars['amount_type']->value == "user_credit") {?>
                    <?php $_smarty_tpl->_assignInScope('type', "User Credit");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "user_debit") {?> <?php $_smarty_tpl->_assignInScope('type', "User Debit");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "admin_debit") {?> <?php $_smarty_tpl->_assignInScope('type', "Admin Debit");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "admin_credit") {?> <?php $_smarty_tpl->_assignInScope('type', "Admin Credit");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "fsb") {?> <?php $_smarty_tpl->_assignInScope('type', "Fast Start Bonus");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "direct_commission") {?> <?php $_smarty_tpl->_assignInScope('type', "Direct Commission");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "binary_match") {?> <?php $_smarty_tpl->_assignInScope('type', "Binary Match Commission");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "leg") {?> <?php $_smarty_tpl->_assignInScope('type', "Binary Commission");
?> <?php } else { ?> <?php $_smarty_tpl->_assignInScope('type', $_smarty_tpl->tpl_vars['amount_type']->value);
?> <?php }?> <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?> <?php $_smarty_tpl->_assignInScope('class', "tr2");
?> <?php } else { ?> <?php $_smarty_tpl->_assignInScope('class', "tr1");
?> <?php }?>
                    <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                        <td><?php echo $_smarty_tpl->tpl_vars['page']->value+$_smarty_tpl->tpl_vars['i']->value;?>
</td>
                         <?php if ($_smarty_tpl->tpl_vars['transaction_id']->value == '' || $_smarty_tpl->tpl_vars['transaction_id']->value == 0) {?>
                        <th><?php echo lang('na');?>
</th>
                        <?php } else { ?>
                        <td><?php echo $_smarty_tpl->tpl_vars['transaction_id']->value;?>
</td>
                        <?php }?>

                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
 <?php echo number_format($_smarty_tpl->tpl_vars['amount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
 <?php echo number_format($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        <td><?php echo stripslashes($_smarty_tpl->tpl_vars['transaction_note']->value);?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['date']->value;?>
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
                <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan="12" align="center">
                            <h4><?php echo lang('no_transfer_details');?>
</h4>
                        </td>
                    </tr>
                </tbody>
                <?php }?>
            </table><?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

         </div>
        </div>
    </div>
</div>
<?php }?> <?php echo form_open('user/my_transfer_details','role="form" class="" name="daily_transfer" id="daily_transfer" action="" method="post"');?>


<div class="panel panel-default">
    <div class="panel-body">
    <legend> <span class="fieldset-legend"><?php echo lang('daily_transfer');?>
</span> </legend>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="letter_width required" for="fb_count"> <?php echo lang('date');?>
</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date3" id="week_date3" size="70" type="text" tabindex="4">
            </div>
        </div>
        <div class="col-sm-4 padding_both_small ">
            <button class="btn btn-sm btn-primary mark_paid_1 " type="submit" name="daily" id="daily" value="profile_update" name="weekdate" tabindex="5"><?php echo lang('submit');?>
</button>
        </div>
    </div>
</div>
<?php if ($_smarty_tpl->tpl_vars['daily']->value || $_smarty_tpl->tpl_vars['daily_session']->value == 1) {?>

<div class="panel-default">

        <?php $_smarty_tpl->_assignInScope('count', '');
?> <?php $_smarty_tpl->_assignInScope('i', "0");
?> <?php $_smarty_tpl->_assignInScope('amount', '');
?> <?php $_smarty_tpl->_assignInScope('date', '');
?> <?php $_smarty_tpl->_assignInScope('amount_type', '');
?> <?php $_smarty_tpl->_assignInScope('class', '');
?> <?php $_smarty_tpl->_assignInScope('count', $_smarty_tpl->tpl_vars['details_count']->value);
?> 
        </br>
        <div class="panel panel-default">
        <div class="panel-body">
        <legend> <span class="fieldset-legend"> <?php echo lang('daily_transfer_details');?>
</span> </legend>
    <div class="table-responsive">
            <table class="table table-bordered table-striped" id="">
                <thead class="table-bordered">
                    <tr class="th">
                        <th><?php echo lang('slno');?>
</th>
                        
                        <th><?php echo lang('date');?>
</th>
                        <th><?php echo lang('amount');?>
</th>
                        <th><?php echo lang('transaction_fee');?>
</th>
                        <th><?php echo lang('transaction_note');?>
</th>
                        <th><?php echo lang('transfer_type');?>
</th>
                    </tr>
                </thead>
                <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', 1);
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?> <?php $_smarty_tpl->_assignInScope('amount', $_smarty_tpl->tpl_vars['v']->value['total_amount']);
?> <?php $_smarty_tpl->_assignInScope('date', $_smarty_tpl->tpl_vars['v']->value['date']);
?> <?php $_smarty_tpl->_assignInScope('amount_type', $_smarty_tpl->tpl_vars['v']->value['amount_type']);
?> <?php $_smarty_tpl->_assignInScope('trans_fee', $_smarty_tpl->tpl_vars['v']->value['trans_fee']);
?> <?php $_smarty_tpl->_assignInScope('transaction_note', $_smarty_tpl->tpl_vars['v']->value['transaction_note']);
?> <?php if ($_smarty_tpl->tpl_vars['amount_type']->value == "user_credit") {?> <?php $_smarty_tpl->_assignInScope('type', "User Credit");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "user_debit") {?> <?php $_smarty_tpl->_assignInScope('type', "User Debit");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "admin_debit") {?> <?php $_smarty_tpl->_assignInScope('type', "Admin Debit");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "admin_credit") {?> <?php $_smarty_tpl->_assignInScope('type', "Admin Credit");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "fsb") {?> <?php $_smarty_tpl->_assignInScope('type', "Fast Start Bonus");
?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "direct_commission") {?> <?php $_smarty_tpl->_assignInScope('type', "Direct Commission");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "binary_match") {?> <?php $_smarty_tpl->_assignInScope('type', "Binary Match Commission");
?> <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "leg") {?> <?php $_smarty_tpl->_assignInScope('type', "Binary Commission");
?> <?php } else { ?> <?php $_smarty_tpl->_assignInScope('type', $_smarty_tpl->tpl_vars['amount_type']->value);
?> <?php }?> <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?> <?php $_smarty_tpl->_assignInScope('class', "tr2");
?> <?php } else { ?> <?php $_smarty_tpl->_assignInScope('class', "tr1");
?> <?php }?>
                    <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                        <td><?php echo $_smarty_tpl->tpl_vars['page']->value+$_smarty_tpl->tpl_vars['i']->value;?>
</td>
                        
                        <td><?php echo $_smarty_tpl->tpl_vars['date']->value;?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
 <?php echo number_format($_smarty_tpl->tpl_vars['amount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
 <?php echo number_format($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['transaction_note']->value;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
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
                <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan="12" align="center">
                            <h4><?php echo lang('no_transfer_details');?>
</h4>
                        </td>
                    </tr>
                </tbody>
                <?php }?>
            </table><?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

        </div>
        </div>
    </div>
</div>

<?php }?> <?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_13735366135f7037c84b6ef1_40949485 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
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
}
