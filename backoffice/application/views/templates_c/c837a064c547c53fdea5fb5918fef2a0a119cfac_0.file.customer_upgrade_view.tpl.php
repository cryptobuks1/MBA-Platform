<?php
/* Smarty version 3.1.30, created on 2020-09-26 17:06:14
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/customer_upgrade_view.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6ee866148d56_59042547',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c837a064c547c53fdea5fb5918fef2a0a119cfac' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/customer_upgrade_view.tpl',
      1 => 1577357372,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6ee866148d56_59042547 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3733192145f6ee8661472f0_71993059', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18267845955f6ee866148751_10251086', 'script');
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_3733192145f6ee8661472f0_71993059 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" style="display:none;">
<span id="confirm_msg"><?php echo lang('sure_you_want_to_upgrade');?>
</span>
 <span id="terms_req"><?php echo lang('terms_req');?>
</span>
</div>
<?php if ($_smarty_tpl->tpl_vars['upgrade_note']->value) {?>
    <blockquote class="lavander">
                      
                            <p>
                                <?php echo $_smarty_tpl->tpl_vars['upgrade_note']->value;?>

                    
                            </p>
                            
     </blockquote>
   <?php }?> 



    <div class="panel panel-default">
        <div class="panel-body">
            <?php if ($_smarty_tpl->tpl_vars['join_type']->value == 'customer') {?>
        <legend><span class="fieldset-legend"><?php echo lang('customer_upgrade');?>
</span></legend>
            <div class="table-responsive">
            <div class="col-sm-12 bhoechie-tab-container">
  <div class=" col-sm-3 bhoechie-tab-menu">
    <div class="list-group">
            <a href="<?php echo BASE_URL;?>
/user/customer_upgrade" class="list-group-item text-center active" onclick="changeActiveTab('ewallet_tab');">
                <h4 class="tabs_h4"><i class="icon-wallet"></i></h4>
                    E-wallet 
            </a> 
    </div>
    
  </div> 
  <div class=" col-sm-3 bhoechie-tab-menu">
    <div class="list-group">
             <a href="<?php echo BASE_URL;?>
/user/strip_payment" class="list-group-item text-center" onclick="changeActiveTab('bank_transfer');">
                <h4 class="tabs_h4"> <i class="fa fa-cc-stripe" aria-hidden="true"></i></h4>
                    Stripe
            </a> 
    </div>
  </div>

<div class="col-sm-9 bhoechie-tab">
    <input type="hidden" name="active_tab" id="active_tab" value="ewallet_tab">
    <input type="hidden" name="free_join_status" id="free_join_status" value="yes">
    <div class="bhoechie-tab-content active">
    </div>
</div>
</div>
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
class Block_18267845955f6ee866148751_10251086 extends Smarty_Internal_Block
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
