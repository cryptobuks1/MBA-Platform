<?php
/* Smarty version 3.1.30, created on 2020-09-16 22:52:06
  from "/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/otp_modal.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f620a767fd9c2_59472178',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2cdc565efa5fd8ec8cdd4f4d6141acbd86b8645a' => 
    array (
      0 => '/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/otp_modal.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f620a767fd9c2_59472178 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="modal fade" id="otp-modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" modal-transclude="">
                <div class="ng-scope">
                    <div class="modal-body wrapper-lg ng-scope">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="m-t-none m-b font-thin"><?php echo lang('enter_otp');?>
</h3>
                                <?php echo form_open('','id="otp_form"  name="otp_form" class="form-login"');?>

                                <div class="errorHandler alert alert-danger" style="display: none">
                                    <i class="fa fa-remove-sign"></i> <?php echo lang('errors_check');?>
.
                                </div>
                                <input type="hidden" name="submit_form">
                                <div class="form-group">
                                    <label><?php echo lang('otp');?>
</label>
                                    <input type="password" id="one_time_password" name="one_time_password" autocomplete="off" class="form-control" placeholder="<?php echo lang('enter_otp');?>
 ">
                                </div>
                                <div class="m-t-lg">
                                    <input type="submit" class="btn btn-sm btn-success pull-right text-uc m-t-n-xs" id="verify" name="verify" value="<?php echo lang('verify');?>
" />
                                    <i class="fa fa-refresh"></i> Resend
                                </div>
                                <?php echo form_close();?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><?php }
}
