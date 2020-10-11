<?php
/* Smarty version 3.1.30, created on 2020-09-28 13:09:40
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/customer_upgrade.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f7153f46b4f29_30471313',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bf9a184716e7be526292adf30c6a07fd975e211b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/customer_upgrade.tpl',
      1 => 1580364593,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f7153f46b4f29_30471313 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19272933495f7153f46b3332_72172633', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_27274965f7153f46b4902_64567121', 'script');
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_19272933495f7153f46b3332_72172633 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" style="display:none;">
<span id="confirm_msg"><?php echo lang('sure_you_want_to_upgrade');?>
</span>
 <span id="terms_req"><?php echo lang('terms_req');?>
</span>
</div>

    

    <div class="panel panel-default">
        <div class="panel-body">
            <?php if ($_smarty_tpl->tpl_vars['join_type']->value == 'customer') {?>
        <legend><span class="fieldset-legend"><?php echo lang('customer_upgrade');?>
</span></legend>
            <div class="table-responsive">
            <?php echo form_open('user/ewallet/upgrade_customer','role="form" class="" name="rank_form" id="rank_form"');?>

                <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

               <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/");
?>
               
               
               <div class="form-group">
                   <label><?php echo lang('user_bal');?>
</label>
                   <input type="text" class="form-control" name="user_bal" id="user_bal"  value="<?php echo $_smarty_tpl->tpl_vars['user_bal']->value;?>
" autocomplete="off" readonly/>
                    <?php echo form_error('user_bal');?>

                </div>
                <div class="form-group">
                   <label><?php echo lang('upgrade_fee');?>
</label>
                   <input type="text" class="form-control" name="upgrade_fee" id="upgrade_fee" value="<?php echo $_smarty_tpl->tpl_vars['upgrade_details']->value['upgrade_amount'];?>
"  autocomplete="off" readonly />
                    <?php echo form_error('upgrade_fee');?>

                </div>
                 
                <div class="form-group">
                   <label><?php echo lang('transaction_fee');?>
</label>
                   <input type="text" class="form-control" name="transaction_fee" id="transaction_fee"  value="<?php echo $_smarty_tpl->tpl_vars['upgrade_details']->value['trans_fee'];?>
" autocomplete="off" readonly/>
                    <?php echo form_error('transaction_fee');?>

                </div>
                 <div class="form-group">
                   <label > </label>
                    <div class="checkbox" align="left">
                  <label class="i-checks">
                      <input name="agree" id="agree"  type="checkbox">
                       <i></i> <a class="" data-toggle="modal" href ="#panel-config"  style="text-decoration: none" >
                          <?php echo lang('I_ACCEPT_TERMS_AND_CONDITIONS');?>

                      </a>
                      <font color="#ff0000">*</font>
                      <?php if (isset($_smarty_tpl->tpl_vars['error']->value['agree'])) {?><span class='val-error' ><?php echo $_smarty_tpl->tpl_vars['error']->value['agree'];?>
 </span><?php }?>
                  </label>
              </div>
          </div>
        
                
               
                <div class="form-group">
             
              <button type="submit" class="btn btn-sm btn-primary" name="upgrade" id="upgrade" ><?php echo lang('upgrade_customer');?>
</button>
                </div>

            <?php echo form_close();?>

            </div>
            <?php } else { ?>
    <blockquote class="lavander">
                      
                            <h1>
                                <?php echo lang('Already_upgraded');?>

                            </h1>
                           
                    </blockquote>
    <?php }?>
        </div>
    </div>
<div class="modal terms" id="panel-config" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                  &times;
              </button>
              <h4 class="modal-title" style="font-size: 16px;"><?php echo lang('terms_conditions');?>
</h4>
          </div>
          <div class="modal-body">
              <table cellpadding="0" cellspacing="0" align="center">
                  <tr>
                      <td width="80%">
                          <?php echo $_smarty_tpl->tpl_vars['termsconditions']->value;?>

                      </td>
                  </tr>
              </table>
          </div>

      </div>
  </div>
</div> 

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_27274965f7153f46b4902_64567121 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/validate_rank.js" type="text/javascript" ><?php echo '</script'; ?>
>
     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/form-wizard.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
