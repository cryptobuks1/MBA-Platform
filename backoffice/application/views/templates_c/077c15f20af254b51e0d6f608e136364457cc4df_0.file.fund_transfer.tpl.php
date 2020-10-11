<?php
/* Smarty version 3.1.30, created on 2020-09-25 18:12:29
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/fund_transfer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6da66d02f3c3_38355435',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '077c15f20af254b51e0d6f608e136364457cc4df' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/fund_transfer.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6da66d02f3c3_38355435 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17250823635f6da66d02d637_92184187', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8109975735f6da66d02f077_09407750', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_17250823635f6da66d02d637_92184187 extends Smarty_Internal_Block
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
        <span id="error_msg6"><?php echo lang('NO_BALANCE');?>
</span>     
        <span id="validate_msg1"><?php echo lang('digits_only');?>
</span>
        <span id="validate_msg17"><?php echo lang('please_enter_transaction_concept');?>
</span>
        <span id="error_name"><?php echo lang('invalid_user_name');?>
</span>
        <span id="error_msg11"><?php echo lang('you_dont_have_enough_balance');?>
</span>
        <span id="error_msg12"><?php echo lang('digits_only');?>
</span>
    </div> 

    <div class="col-md-7 col-md-offset-2" style="min-height: 600px" >

        <?php echo form_open_multipart('user/ewallet/post_fund_transfer','role="form"  method="post" name="form" id="msform"');?>


        <!-- progressbar -->
        <ul id="progressbar" class="progressbar_width">
            <li class="active"></li>
            <li></li>
        </ul>
        <!-- fieldsets -->
        <fieldset class="position_full" id="step-1">
            <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
            <input type="hidden" id="path_root" name="path_root" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
">
            <h2 class="fs-title"><?php echo lang('transfer_details');?>
</h2>
            <div class="form-group">
                <label> <?php echo lang('transfer_to');?>
<span class="symbol required"></span></label>
                <input class="form-control" type="text" id="to_user_name" name="to_user_name" autocomplete="Off" /><span id="errormsg1"></span>
                <?php echo form_error('to_user_name');?>

            </div>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == "no") {?> 
                <div class="form-group">
                    <label><?php echo lang('available_amount');?>
</label>
                    <input class="form-control" type="text" id="avb_amount" name="avb_amount" readonly="1" value="<?php echo round($_smarty_tpl->tpl_vars['balamount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
"  autocomplete="Off" />
                    <input type="hidden" id="bal" name="bal"   value="<?php echo $_smarty_tpl->tpl_vars['balamount']->value;?>
" />
                    <input type="hidden" id="blnc" name="blnc"   value="<?php echo round($_smarty_tpl->tpl_vars['balamount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" />
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label><?php echo lang('available_amount');?>
</label>
                    <div class="form-group">
                        <div class="input-group">
                            <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                            <input class="form-control" type="text" id="avb_amount" name="avb_amount" readonly="1" value="<?php echo round($_smarty_tpl->tpl_vars['balamount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
"  autocomplete="Off" />
                            
                            <input type="hidden" id="bal" name="bal"   value="<?php echo $_smarty_tpl->tpl_vars['balamount']->value;?>
" />
                            <input type="hidden" id="blnc" name="blnc"   value="<?php echo round($_smarty_tpl->tpl_vars['balamount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" />
                        </div>
                    </div>
                </div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == "no") {?> 
                <div class="form-group">
                    <label><?php echo lang('amount');?>
</label>
                    <input class="form-control" type="text" id="amount1" name="amount1" />
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label> <?php echo lang('amount');?>
<span class="symbol required"></span> </label>
                    <div class="form-group">
                        <div class="input-group">
                            <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                            <input class="form-control" type="text" id="amount1" name="amount1" />
                            
                            <?php echo form_error('amount1');?>

                        </div>
                    </div>
                </div>
            <?php }?>
            <div class="form-group">
                <label> <?php echo lang('transaction_note');?>
<span class="symbol required"></span></label>
                <textarea class="form-control" name="tran_concept" rows="" placeholder="" id="tran_concept" style="height: 45px; resize: none;"></textarea>
                <?php echo form_error('tran_concept');?>

            </div>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == "no") {?> 
                <div class="form-group">
                    <label><?php echo lang('transaction_fee');?>
</label>
                    <input class="form-control" type="text" id="trans_fee" name="trans_fee" readonly="1" value="<?php echo round($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
"  autocomplete="Off" />
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <label><?php echo lang('transaction_fee');?>
</label>
                    <div class="form-group">
                        <div class="input-group">
                            <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                            <input class="form-control" type="text" id="trans_fee" name="trans_fee" readonly="1" value="<?php echo round($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
"  autocomplete="Off" />
                            
                        </div>
                    </div>
                </div>
            <?php }?>
            <input type="hidden" name="transaction_note" id="transaction_note" value="">
            <input type="hidden" name="path" id="path" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin" >
            <input type="hidden" name="tran_fees" id="tran_fees" value="<?php echo $_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value;?>
" >
            <input type="hidden" value="1" name="dotransfer"> 
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <tr>
                        <td><?php echo lang('ewallet_balance');?>
</td>
                        <td class="ebal2"><?php echo round($_smarty_tpl->tpl_vars['balamount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
</td>
                    </tr>
                    <tr>
                        <td><?php echo lang('ewallet_amount already_payout_process');?>
</td>
                        <td class="ebal2"><?php echo round($_smarty_tpl->tpl_vars['request_amount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
</td>
                    </tr>
             </table>
            <input type="button" name="next" id="next" class="next action-button" value="Next"/>
        </fieldset>

        <fieldset class="position_full">
            <h2 class="fs-title"><?php echo lang('confirm');?>
</h2>
            <input type="hidden" value="0" name="dotransfer">
            <div class="form-group">
                <label><?php echo lang('ewallet_balance');?>
</label>
                <p class="border_class" id="balnc_amt" name="balnc_amt"></p>
            </div>
            <input type="hidden" name="tot_req_amount" value="" id="tot_req_amount"/>
            <div class="form-group">
                <label><?php echo lang('receiver');?>
</label>
                <input name="to_username" id="to_username" type="hidden" class="form-control" value=""/>
                <p class="border_class" id="receiver" name="to_username"><?php echo $_smarty_tpl->tpl_vars['to_user']->value;?>
</p>
            </div>
            <div class="form-group">
                <label><?php echo lang('amount_to_transfer');?>
</label>
                <input name="amount" id ="amount" class="form-control" type="hidden" value="<?php echo round($_smarty_tpl->tpl_vars['amount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
"/>
                <p class="border_class" id="disp_amount" name="disp_amount"></p>
            </div> 
            <div class="form-group">
                <label > <?php echo lang('transaction_fee');?>
</label>
                <input class="form-control textfixed" type= "hidden" id="transaction_fee" name="transaction_fee" value="<?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
" /><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round($_smarty_tpl->tpl_vars['trans_fee']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

            </div>
            <div class="form-group">
                <label ><?php echo lang('transaction_password');?>
</label>
                <input class="form-control" type="password" id="pswd" name="pswd" />
                <?php echo form_error('pswd');?>

            </div>    
             <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <tr>
                        <td><?php echo lang('ewallet_balance');?>
</td>
                        <td class="ebal2"><?php echo round($_smarty_tpl->tpl_vars['balamount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
</td>
                    </tr>
                    <tr>
                        <td><?php echo lang('ewallet_amount already_payout_process');?>
</td>
                        <td class="ebal2"><?php echo round($_smarty_tpl->tpl_vars['request_amount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
</td>
                    </tr>
             </table>
            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
            <input type="submit" class="submit action-button" id="transfer" name="transfer" value="Finish"/>
        </fieldset>


        <?php echo form_close();?>

        <!-- link to designify.me code snippets -->
    </div>
      <div class="col-md-7 col-md-offset-2 min_height" style="margin-top: 10px; margin-bottom: 120px">      
      </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_8109975735f6da66d02f077_09407750 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>
 
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
/javascript/fund_transfer_user.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
