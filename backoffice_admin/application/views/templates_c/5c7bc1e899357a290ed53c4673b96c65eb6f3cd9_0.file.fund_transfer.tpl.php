<?php
/* Smarty version 3.1.30, created on 2020-08-17 12:28:29
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ewallet/fund_transfer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f39eb4d17c432_94593543',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c7bc1e899357a290ed53c4673b96c65eb6f3cd9' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ewallet/fund_transfer.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
    'file:layout/otp_modal.tpl' => 1,
  ),
),false)) {
function content_5f39eb4d17c432_94593543 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20014343605f39eb4d15eab5_86608457', 'script');
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11830234785f39eb4d17b8b0_04013209', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'script'} */
class Block_20014343605f39eb4d15eab5_86608457 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/fund_transfer_admin.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_11830234785f39eb4d17b8b0_04013209 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1"><?php echo lang('You_must_enter_user_name');?>
</span>
        <span id="error_msg2"><?php echo lang('NO_BALANCE');?>
</span>
        <span id="error_msg3"><?php echo lang('Please_type_transaction_password');?>
</span>
        <span id="error_msg4"><?php echo lang('Please_type_To_User_name');?>
</span>
        <span id="error_msg5"><?php echo lang('Please_type_Amount');?>
</span>
        <span id="error_msg11"><?php echo lang('you_dont_have_enough_balance');?>
</span>
        <span id="validate_msg1"><?php echo lang('digits_only');?>
</span>
        <span id="validate_msg17"><?php echo lang('please_enter_transaction_concept');?>
</span>
        <span id="error_name"><?php echo lang('invalid_user_name');?>
</span>
        <span id="error_msg12"><?php echo lang('digits_only');?>
</span>
        <span id="next"><?php echo lang('next');?>
</span>
        <span id="previous"><?php echo lang('back');?>
</span>
        <span id="finish"><?php echo lang('finish');?>
</span>
        <span id="otp_err1"><?php echo lang('you_must_enter_otp');?>
 </span>
        <span id="otp_err2"><?php echo lang('otp_is_numeric');?>
 </span>
    </div>
    <div class="col-md-7 col-md-offset-2 min_height">
        <?php echo form_open('/admin/post_fund_transfer','role="form" method="post" name="fund_form" id="msform"');?>
 <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <!-- progressbar -->
        <ul id="progressbar" class="progressbar_width">
            <li class="active"></li>
            <li></li>

        </ul>
        <!-- fieldsets -->
        <fieldset id="step-1" class="position_full">
            <input type="password" autocomplete="off" style="display: none;" />
            <h2 class="fs-title"> <?php echo lang('transfer_details');?>
</h2>
            <div class="form-group">
                <label class="required"> <?php echo lang('user_name');?>
 </label>
                <input class="form-control user_autolist" type="text" id="user_name" name="user_name" onblur="getAmountLeg();" autocomplete="Off" /> <?php echo form_error('user_name');?>
 <?php echo form_error('user_name');?>

            </div>
            <div class="form-group">
                <label class="required"><?php echo lang('transfer_to');?>
</label>
                <input class="form-control user_autolist" type="text" id="to_user_name" name="to_user_name" onkeypress="getAmountLeg();" autocomplete="Off" /> <?php echo form_error('to_user_name');?>

                <input id="to_user_name1" name="to_user_name1" type="hidden">
            </div>
            <div class="form-group">
                <div id="user_amount_div"> </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == "no") {?> 
            <div class="form-group">
                <label><?php echo lang('amount');?>
</label>
                <input type="text" class="form-control" id="amount1" name="amount1"/> 
            </div> 
            <?php } else { ?>
            <div class="form-group">
                <label class="required"> <?php echo lang('amount');?>
 </label>
                <div class="form-group">
                    <div class="input-group">
                        <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                        <input class="form-control" type="text" id="amount1" name="amount1" /> <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</span><?php }?> <?php echo form_error('amount1');?>

                    </div>
                </div>
                <span id="errmsg1"></span>
            </div>
            <?php }?>
            <div class="form-group">
                <label class="required"><?php echo lang('transaction_note');?>
</label>
                <input type="text" class="form-control" id="tran_concept" name="tran_concept" /> <?php echo form_error('tran_concept');?>

            </div>

            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == "no") {?> 
                <div class="form-group">
                    <label><?php echo lang('transaction_fee');?>
</label>
                    <input class="form-control" type="text" id="tran_fee" name="tran_fee" disabled value="<?php echo round($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" autocomplete="Off" />
                </div> 
            <?php } else { ?>
                <div class="form-group">
                    <label><?php echo lang('transaction_fee');?>
</label>
                    <div class="form-group">
                        <div class="input-group">
                            <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                            <input class="form-control" type="text" id="tran_fee" name="tran_fee" readonly="1" value="<?php echo round($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" autocomplete="Off" /> <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</span><?php }?>
                        </div>
                    </div>
                </div>
            <?php }?>
            <input type="hidden" name="path" id="path" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin">
            <input type="hidden" name="tran_fees" id="tran_fees" value="<?php echo $_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value;?>
">
            <input type="hidden" value="1" name="dotransfer">
            <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['PRECISION']->value;?>
" id="precision">
            <input type="button" name="" id="product" class="next action-button" value="<?php echo lang('next');?>
" />
        </fieldset>

        <fieldset>
            <input type="hidden" value="0" name="dotransfer">
            <input type="hidden" value="f627cf15b4adbe7e689b7db8a5d09fc9" name="token">
            <h2 class="fs-title"><?php echo lang('confirm');?>
</h2>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == "no") {?> 
            <div class="form-group">
                <label><?php echo lang('ewallet_balance');?>
</label>
                <input type="text" class="form-control" disabled="disabled" id="bal_amount" value="<?php echo number_format($_smarty_tpl->tpl_vars['bal_amount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" />
            </div>
            <?php } else { ?>
            <div class="form-group">
                <label><?php echo lang('ewallet_balance');?>
</label>
                <div class="form-group">
                    <div class="input-group">
                        <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                        <input type="text" class="form-control" disabled="disabled" id="bal_amount" value="<?php echo number_format($_smarty_tpl->tpl_vars['bal_amount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" /> <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</span><?php }?>
                    </div>
                </div>
            </div>
            <?php }?>
            <input name="from_user" type="hidden" id="from_user" class="form-control" />
            <div class="form-group">
                <label><?php echo lang('receiver');?>
</label>
                <input type="text" class="form-control" id="receiver" disabled="disabled" />
                <input name="to_username" id="to_username" type="hidden" class="form-control" />
            </div>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == "no") {?> 
            <div class="form-group">
                <label><?php echo lang('amount_to_transfer');?>
</label>
                <input type="text" class="form-control" id="disp_amount" name="disp_amount" disabled="disabled" />
            </div>        
            <?php } else { ?>
            <div class="form-group">
                <label><?php echo lang('amount_to_transfer');?>
</label>
                <div class="form-group">
                    <div class="input-group">
                        <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                        <input type="text" class="form-control" id="disp_amount" name="disp_amount" disabled="disabled" /><?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value) {?>
                        <span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</span><?php }?>
                    </div>
                    <input name="amount" id="amount" class="form-control" type="hidden" value="" />
                </div>
            </div>
            <?php }?>
            <div class="form-group">
                <label><?php echo lang('transaction_note');?>
</label>
                <input type="text" class="form-control" id="transaction_not" disabled="disabled" \/>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == "no") {?> 
            <div class="form-group">
                <label><?php echo lang('transaction_fee');?>
</label>
                <input type="number" class="form-control" id="trans_fee" value="<?php echo number_format($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" disabled="disabled" />
            </div>
            <?php } else { ?>
            <div class="form-group">
                <label><?php echo lang('transaction_fee');?>
</label>
                <div class="form-group">
                    <div class="input-group">
                        <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                        <input type="number" class="form-control" id="trans_fee" value="<?php echo number_format($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" disabled="disabled" /><?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</span><?php }?>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="form-group">
                <label class="required"><?php echo lang('transaction_password');?>
</label>
                <input type="password" id="pswd" class="form-control" name="pswd" data-bv-field="pswd" /> <?php echo form_error('pswd');?>

                <input type="hidden" name="transaction_note" id="transaction_note" value="<?php echo $_smarty_tpl->tpl_vars['transaction_note']->value;?>
">
            </div>
            <input type="button" name="previous" class="previous action-button-previous" value="<?php echo lang('back');?>
" />
            <input type="button" id="transfer" name="transfer" class="submit action-button" value="<?php echo lang('finish');?>
" />
        </fieldset>
        <?php echo form_close();?>

        <!-- link to designify.me code snippets -->
    </div>
    <?php $_smarty_tpl->_subTemplateRender("file:layout/otp_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 <?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
