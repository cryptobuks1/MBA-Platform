<?php
/* Smarty version 3.1.30, created on 2020-09-25 18:51:04
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/home/rank_popup.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6daf78990f86_78009115',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '26b3d7e29e1c5aa3895afff060ce2ca6dbac34a4' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/home/rank_popup.tpl',
      1 => 1572413125,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6daf78990f86_78009115 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php if ($_smarty_tpl->tpl_vars['current_date']->value >= $_smarty_tpl->tpl_vars['subscription_end_date']->value) {?>

<!--USER POPUP-->
<div class="modal fade text-center py-5" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md index" role="document">
        <div class="modal-content_1 b-white">
            <div class="modal-body backgound_modal">
                <div class="p-3">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon-close"></i></button>
                     <div class="clearfix">
                       
                        
                    </div>
                  
                    <blockquote class="lavander">
                       
                            <h1>
                                <span class="Clavander"></span> 
                                
                                <?php echo lang('you_have_to_pay_a_monthly_subscription');?>

                                <?php echo lang('of');?>

                                <?php echo $_smarty_tpl->tpl_vars['monthly_fee']->value;?>

                            </h1>
                            <p class="text-info">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/monthly_payment">click here!</a>
                            </p>
                        
                        
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>
<!--USER POPUP-->
<?php }
}
}
