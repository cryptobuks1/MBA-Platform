<?php
/* Smarty version 3.1.30, created on 2020-09-26 17:06:17
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/strip_payment.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6ee869388f59_01741737',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '007012828ab68726ae85b5990dbdf0d19ab4dbc2' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/strip_payment.tpl',
      1 => 1576667826,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6ee869388f59_01741737 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19930812525f6ee869388430_16950868', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_19930812525f6ee869388430_16950868 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 
    <div id="span_js_messages" style="display:none;">
     
        <span id="error_msg1"><?php echo lang('NO_BALANCE');?>
</span>
        <span id="trans_pass_req"><?php echo lang('Please_type_transaction_password');?>
</span>
                  
        <span id="error_msg3"><?php echo lang('Please_type_Amount');?>
</span>
        <span id="msg4"><?php echo lang('Amount_is_required');?>
</span>     
        <span id="validate_msg1"><?php echo lang('digits_only');?>
</span>
        <span id="error_msg5"><?php echo lang('you_dont_have_enough_balance');?>
</span>
        <span id="error_msg12"><?php echo lang('digits_only');?>
</span>
        <span id="error_msg11"><?php echo lang('you_dont_have_enough_balance');?>
</span>
        <span id="greater_than_0"><?php echo lang('greater_than_0');?>
</span>
        <span id="invalid_amount"><?php echo lang('Amount_should_be_multiple');?>
</span>
        
    
</div>
  <div class="col-md-7 col-md-offset-2" style="min-height: 600px" >  
  
      <?php echo form_open_multipart('user/ewallet/strip_pay_post','role="form"  method="post" name="form" id="msform"');?>

      
     
      <style>
       .stripe-button-el{
           display: block;
  max-width: 300px;
  margin: auto;
  top: 50%;
        }
    </style>
    <?php echo '<script'; ?>

        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"
        data-amount=""
        data-name="Register"
        data-description="Payment through Stripe"
        data-image="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value["logo"];?>
"
        data-locale="auto"
        data-zip-code="true">
    <?php echo '</script'; ?>
>
   
   
       <?php echo form_close();?>

       

  </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
