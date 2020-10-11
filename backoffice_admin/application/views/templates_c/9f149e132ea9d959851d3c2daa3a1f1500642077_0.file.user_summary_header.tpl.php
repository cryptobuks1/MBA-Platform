<?php
/* Smarty version 3.1.30, created on 2020-08-05 18:55:36
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/user_account/user_summary_header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a74080b0677_30613092',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9f149e132ea9d959851d3c2daa3a1f1500642077' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/user_account/user_summary_header.tpl',
      1 => 1571805254,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2a74080b0677_30613092 (Smarty_Internal_Template $_smarty_tpl) {
?>
<legend>
	<span class="fieldset-legend"><?php echo lang('user_overview');?>
</span>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        <!-- <div class="app-header-fixed"></div> -->
        <div class="row">
            <div class="col-sm-12">
                <div class="user_account-user-details-container">
                    <div class="user_account-user-img b b-3x">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['file_name']->value;?>
" class="">
                    </div>
                    <div class="user_account-user-details">
                        <div class="user_account-user-details1">
                            <span><?php echo lang('user_name');?>
 </span> : &nbsp; 
                            <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>

                        </div>
                        <div class="user_account-user-details1">
                            <span><?php echo lang('first_name');?>
 </span> : &nbsp; 
                            <?php echo $_smarty_tpl->tpl_vars['user_detail']->value['name'];?>

                        </div>
                        <!-- <div class="user_account-user-details1">
                            <span><?php echo lang('last_name');?>
 </span> : &nbsp; 
                            <?php echo $_smarty_tpl->tpl_vars['user_detail']->value['second_name'];?>

                        </div> -->

                    </div>                            
                </div>
            </div>    

            <!-- <div class="col-sm-8 col-sm-offset-2">
                <div class="panel b-a">
                    <div class="text-center m-b clearfix">
                        <div class="thumb-lg avatar m-t-n-xxl">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['file_name']->value;?>
" class="b b-3x">
                    
                        </div>
                    </div>
                    <div class="panel panel-default table-responsive">
                        <table st-table="rowCollectionBasic" class="table table-bordered table-striped no-border">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="user_table_width"><?php echo lang('user_name');?>
</td>
                                    <td class="user_table_width"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width"><?php echo lang('first_name');?>
</td>
                                    <td class="user_table_width"><?php echo $_smarty_tpl->tpl_vars['user_detail']->value['name'];?>
</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width"><?php echo lang('last_name');?>
</td>
                                    <td class="user_table_width"><?php echo $_smarty_tpl->tpl_vars['user_detail']->value['second_name'];?>
</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width"><?php echo lang('date_of_birth');?>
</td>
                                    <td class="user_table_width"><?php echo $_smarty_tpl->tpl_vars['user_detail']->value['dob'];?>
</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width"><?php echo lang('gender');?>
</td>
                                    <td class="user_table_width"><?php if ($_smarty_tpl->tpl_vars['user_detail']->value['gender'] == "M") {
echo ucfirst(lang('male'));
} else {
echo ucfirst(lang('female'));
}?></td>
                                </tr>
                                <tr>
                                    <td class="user_table_width"><?php echo lang('mobile_no');?>
</td>
                                    <td class="user_table_width"><?php echo $_smarty_tpl->tpl_vars['user_detail']->value['mobile'];?>
</td>
                                </tr>
                                <tr>
                                    <td class="user_table_width"><?php echo lang('email');?>
</td>
                                    <td class="user_table_width">
                                        <a href="mailto:<?php echo $_smarty_tpl->tpl_vars['user_detail']->value['email'];?>
?%20again" target="_top"><?php echo $_smarty_tpl->tpl_vars['user_detail']->value['email'];?>
</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->

        </div>
        <br>
        <div class="row">
            <div class="button-container">
            <div class="col-sm-2 m-b-sm padding_both">
                <?php echo form_open('admin/profile_view','method="post"');?>

                    <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-address-book-o f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('profile');?>
</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                <?php echo form_close();?>

            </div>
            <div class="col-sm-2 m-b-sm padding_both_small">
                <?php echo form_open('admin/income','method="post"');?>

                    <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-money f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('income_details');?>
</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                <?php echo form_close();?>

            </div>
            <div class="col-sm-2 m-b-sm padding_both_small">
                <?php echo form_open('admin/my_referal','method="post"');?>

                    <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-user-circle-o f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('refferal_details');?>
</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                <?php echo form_close();?>

            </div>
            <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == "Binary") {?>
                <div class="col-sm-2 m-b-sm padding_both_small">
                    <?php echo form_open('admin/view_leg_count','method="post"');?>

                        <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                        <input type="hidden" name="from_page" id="from_page" value="user_account" />
                        <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                        <button class="btn-block btn-link user_button">
                            <div class="card_1 table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="fa fa-sitemap f-30"></i>
                                    </div>
                                    <div class="text-center text-center-width">
                                        <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('binary_details');?>
</h4>
                                    </div>
                                </div>
                            </div>
                        </button>
                    <?php echo form_close();?>

                </div>
            <?php }?>
            <div class="col-sm-2 m-b-sm padding_both_small">
                <?php echo form_open('admin/my_ewallet','method="post"');?>

                    <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-briefcase f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('ewallet_details');?>
</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                <?php echo form_close();?>

            </div>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['purchase_wallet'] == 'yes') {?>
                <div class="col-sm-2 m-b-sm padding_both_small">
                    <?php echo form_open('admin/purchase_wallet','method="post"');?>

                        <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                        <input type="hidden" name="from_page" id="from_pagez" value="user_account" />
                        <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                        <button class="btn-block btn-link user_button">
                            <div class="card_1 table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="fa fa-shopping-basket f-30"></i>
                                    </div>
                                    <div class="text-center text-center-width">
                                        <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('purchase_wallet');?>
</h4>
                                    </div>
                                </div>
                            </div>
                        </button>
                    <?php echo form_close();?>

                </div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['pin_status']->value == "yes") {?>
                <div class="col-sm-2 m-b-sm padding_both_small">
                    <?php echo form_open('admin/view_pin_user','method="post"');?>

                        <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                        <input type="hidden" name="from_page" id="from_page" value="user_account" />
                        <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                        <button class="btn-block btn-link user_button">
                            <div class="card_1 table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="fa fa-bookmark-o f-30"></i>
                                    </div>
                                    <div class="text-center text-center-width">
                                        <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('user_epin');?>
</h4>
                                    </div>
                                </div>
                            </div>
                        </button>
                    <?php echo form_close();?>

                </div>
            <?php }?>
            <div class="col-sm-2 m-b-sm padding_both_small">
                <?php echo form_open('admin/my_income','method="post"');?>

                    <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-money f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('income_statement');?>
</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                <?php echo form_close();?>

            </div>
            <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == "Binary") {?>
                <div class="col-sm-2 m-b-sm padding_both_small">
                    <?php echo form_open('admin/business_volume','method="post"');?>

                        <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                        <input type="hidden" name="from_page" id="from_page" value="user_account" />
                        <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                        <button class="btn-block btn-link user_button">
                            <div class="card_1 table-card">
                                <div class="row-table">
                                    <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                        <i class="fa fa-tint f-30"></i>
                                    </div>
                                    <div class="text-center text-center-width">
                                        <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('business_volume');?>
</h4>
                                    </div>
                                </div>
                            </div>
                        </button>
                    <?php echo form_close();?>

                </div>
            <?php }?>
            
            <!--reward code bgins here  --sahla  -->
            <div class="col-sm-2 m-b-sm padding_both_small">
                <?php echo form_open('admin/rank_rewards','method="post"');?>

                    <input type="hidden" name="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" />
                    <input type="hidden" name="from_page" id="from_page" value="user_account" />
                    <input type="hidden" name="overview_disp" id="overview_disp" value="yes" />
                    <button class="btn-block btn-link user_button">
                        <div class="card_1 table-card">
                            <div class="row-table">
                                <div class="col-auto theme-bg text-white p-t-50 p-b-50">
                                    <i class="fa fa-money f-30"></i>
                                </div>
                                <div class="text-center text-center-width">
                                    <h4 class="f-w-300 m-t-sm m-b-sm"><?php echo lang('rewards');?>
</h4>
                                </div>
                            </div>
                        </div>
                    </button>
                <?php echo form_close();?>

            </div>
            <!--end reward-->
            </div>
        </div>
    </div>
</div><?php }
}
