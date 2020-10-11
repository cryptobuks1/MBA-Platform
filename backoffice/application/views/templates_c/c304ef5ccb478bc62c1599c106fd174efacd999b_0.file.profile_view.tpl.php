<?php
/* Smarty version 3.1.30, created on 2020-09-25 15:01:53
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/profile/profile_view.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d79c10f7ec2_04355362',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c304ef5ccb478bc62c1599c106fd174efacd999b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/profile/profile_view.tpl',
      1 => 1576565086,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d79c10f7ec2_04355362 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3986489325f6d79c10f6505_14983020', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_3986489325f6d79c10f6505_14983020 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display: none;"> 
        <span id="validate_msg30"><?php echo lang('You_must_select_a_date');?>
</span>
        <span id="validate_msg31"><?php echo lang('You_must_select_a_month');?>
</span>
        <span id="validate_msg32"><?php echo lang('You_must_select_a_year');?>
</span>
        <span id="validate_msg33"><?php echo lang('You_must_select_gender');?>
</span>
        <span id="validate_msg34"><?php echo lang('You_must_select_country');?>
</span>
        <span id="validate_msg35"><?php echo lang('mail_id_format');?>
</span>
        <span id="validate_msg37"><?php echo lang('digits_only');?>
</span>
        <span id="validate_msg40"><?php echo lang('you_must_enter_email_id');?>
</span>
        <span id="validate_msg41"><?php echo lang('You_must_enter_your_address');?>
</span>
        <span id="validate_msg67"><?php echo lang('enter_city');?>
</span>
        <span id="validate_msg69"><?php echo lang('enter_atleast_3_chars');?>
</span>
        <span id="validate_msg70"><?php echo lang('mobile_number_must_10digits_long');?>
</span>
        <span id="validate_msg73"><?php echo lang('must_enter_first_name');?>
</span>
        <span id="validate_msg75"><?php echo lang('only_alphanumerals');?>
</span>
        <span id="validate_msg78"><?php echo lang('city_field_characters');?>
</span>
        <span id="validate_msg81"><?php echo lang('digits_only');?>
</span>
        <span id="validate_msg90"><?php echo lang('You_should_be_atleast_n_years_old');?>
</span>
        <span id="validate_msg91"><?php echo lang('only_alpha_space');?>
</span>
        <span id="validate_msg92"><?php echo lang('enter_min_digits');?>
</span>
        <span id="validate_msg93"><?php echo lang('enter_max_digits');?>
</span>
        <span id="validate_msg94"><?php echo lang('enter_mobile_no');?>
</span>
        <span id="validate_msg95"><?php echo lang('no_more_than_32_characters');?>
</span>
    </div>
    <?php echo form_open_multipart('','role="form" class="" name= "edit_user_profile"  id="edit_user_profile"');?>

    <legend><span class="fieldset-legend"><?php echo $_smarty_tpl->tpl_vars['u_name']->value;
echo lang('s_profile');?>
</span></legend>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="fb-profile"> <a href="" class="wall-img-edit-btn"></a> <img align="left" class="fb-image-lg" src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/banners/<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["banner_name"];?>
"/>
                <div class="edit_button"> <img align="left" class="fb-image-profile thumbnail" src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["profile_photo"];?>
" /> </div>
                <div class="col-sm-9">
                    <div class="fb-profile-text">
                        <h4><?php echo $_smarty_tpl->tpl_vars['u_name']->value;?>
</h4>
                        <p><?php echo $_smarty_tpl->tpl_vars['profile_details']->value['email'];?>
</p>
                    </div>
                    <div class="new_line"></div>
                </div>
                <div class="col-sm-12">
                    <div class="fb-profile-text_1">
                        <div class="pull-right">
                            <a href="<?php echo BASE_URL;?>
/user/edit_profile" type="submit" class="btn btn-sm btn-primary"><?php echo lang('edit_profile');?>
</a>
                        </div>
                        <h3><?php echo $_smarty_tpl->tpl_vars['profile_details']->value['rank_name'];?>
</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="views-table cols-7 table">
                <tbody>
                    <tr>
                        <td><?php echo lang('user_name');?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['u_name']->value;?>
</td>
                    </tr>
                     <tr>
                        <td><?php echo lang('join_type');?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['profile_details']->value['join_type'];?>
</td>
                    </tr>
                    <tr>
                        <td><?php echo lang('placement_user_name');?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['profile_details']->value['father_name'];?>
</td>
                    </tr>
                    <tr>
                        <td><?php echo lang('sponsor_name');?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['profile_details']->value['sponsor_name'];?>
</td>
                    </tr>
                    <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == "Binary") {?>
                    <tr>
                        <td><?php echo lang('position');?>
</td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['profile_details']->value["position"] == 'L') {?> 
                                <?php echo lang('left');?>
 
                            <?php } elseif ($_smarty_tpl->tpl_vars['profile_details']->value["position"] == 'R') {?> 
                                <?php echo lang('right');?>
 
                            <?php } else { ?>
                                NA
                            <?php }?>
                        </td>
                    </tr>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['product_status']->value == "yes") {?>
                        <tr>
                            <td><?php echo lang('package');?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['product_name']->value;?>
</td>
                        </tr>
                        <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['product_validity'] == 'yes') {?>
                            <tr>
                                <td><?php echo lang('package_validity');?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['product_validity']->value;?>
</td>
                            </tr>
                        <?php }?>
                    <?php }?>
                     <tr>
                        <td><?php echo lang('referalcount');?>
</td>
                         <td><?php echo $_smarty_tpl->tpl_vars['referal_count']->value;?>
</td>
                     </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tabsy">
        <input type="radio" id="tab1" name="tab" checked>
        <label class="tabButton" for="tab1"><?php echo lang('personal_info');?>
</label>
        <div class="tab" id="personal_info">
            <div class="content" id="personal_info_div">
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label><?php echo lang('first_name');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["name"];?>
</p>
                        <input type="text" name="first_name" id="first_name" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["name"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('last_name');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["user_detail_second_name"];?>
</p>
                        <input type="text" name="last_name" id="last_name" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["user_detail_second_name"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('gender');?>
</label>
                        <p class="form-control-static">
                            <?php if ($_smarty_tpl->tpl_vars['profile_details']->value["gender"] == "F") {?>
                                <?php echo lang('female');?>

                            <?php } elseif ($_smarty_tpl->tpl_vars['profile_details']->value["gender"] == "M") {?>
                                <?php echo lang('male');?>

                            <?php }?>
                        </p>
                        <select class="form-control" name="gender" id="gender">
                            <option value='M' <?php if ($_smarty_tpl->tpl_vars['profile_details']->value["gender"] == 'M') {?> selected <?php }?>><?php echo lang('male');?>
</option>
                            <option value='F' <?php if ($_smarty_tpl->tpl_vars['profile_details']->value["gender"] == 'F') {?> selected <?php }?>><?php echo lang('female');?>
</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('date_of_birth');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["dob"];?>
</p>
                        <input type="text" name="dob" id="dob" data-value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["dob"];?>
" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["dob"];?>
" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <input type="radio" id="tab2" name="tab">
        <label class="tabButton" for="tab2"><?php echo lang('contact_info');?>
</label>
        <div class="tab" id="contact_info">
            <div class="content" id="contact_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_contact_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label class="required"><?php echo lang('adress_line1');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["address"];?>
</p>
                        <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["address"];?>
" name="address" id="address">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('adress_line2');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["user_detail_address2"];?>
</p>
                        <input type="text" name="address2" id="address2" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["user_detail_address2"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="required"><?php echo lang('country');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["country"];?>
</p>
                        <select name="country" id="country" onChange="getAllStates(this.value, 'user');" class="form-control"><?php echo $_smarty_tpl->tpl_vars['countries']->value;?>
</select>
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('state');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["state"];?>
</p>
                        <span id="prof_state_div">
                            <select name="state" id="state" class="form-control"><?php echo $_smarty_tpl->tpl_vars['states']->value;?>
</select>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="required"><?php echo lang('city');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["user_detail_city"];?>
</p>
                        <input type="text" name="city" id="city" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["user_detail_city"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('zip_code');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["pincode"];?>
</p>
                        <input type="text" name="pincode" id="pincode" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["pincode"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="required"><?php echo lang('email');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value['email'];?>
</p>
                        <input type="text" name="email" id="email" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["email"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="required"><?php echo lang('mob_no_10_digit');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['mobile_code']->value;
echo $_smarty_tpl->tpl_vars['profile_details']->value["mobile"];?>
</p>
                        <input type="hidden" name="mobile_code" id="mobile_code" value="<?php echo $_smarty_tpl->tpl_vars['mobile_code']->value;?>
" readonly>
                        <div class="input-group" style="display:none">
                            <span class="input-group-addon"><span id="mcode"></span></span>
                            <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["mobile"];?>
" >
                        </div>
                    </div> 
                    <div class="form-group">
                        <label><?php echo lang('land_line_no');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["land"];?>
</p>
                        <input type="text" name="land_line" id="land_line" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["land"];?>
" class="form-control">
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="update_contact_info"><?php echo lang('update');?>
</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_contact_info"><?php echo lang('cancel');?>
</button>
                </div>
            </div>
        </div>
        <input type="radio" id="tab3" name="tab">
        <label class="tabButton" for="tab3"><?php echo lang('social_profiles');?>
</label>
        <div class="tab" id="social_profiles">
            <div class="content" id="social_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_social_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label><?php echo lang('facebook');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["facebook"];?>
</p>
                        <input type="text" name="facebook" id="facebook" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["facebook"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('twitter');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["twitter"];?>
</p>
                        <input type="text" name="twitter" id="twitter" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["twitter"];?>
" class="form-control">
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="update_social_info"><?php echo lang('update');?>
</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_social_info"><?php echo lang('cancel');?>
</button>
                </div>
            </div>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['bank_info_status']->value == 'yes') {?>
        <input type="radio" id="tab4" name="tab">
        <label class="tabButton" for="tab4"><?php echo lang('bank_info');?>
</label>
        <div class="tab" id="bank_info">
            <div class="content" id="bank_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_bank_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label><?php echo lang('bank_name');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["nbank"];?>
</p>
                        <input type="text" name="bank_name" id="bank_name" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["nbank"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('branch_name');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["nbranch"];?>
</p>
                        <input type="text" name="branch_name" id="branch_name" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["nbranch"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('account_holder');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["user_detail_nacct_holder"];?>
</p>
                        <input type="text" name="account_holder" id="account_holder" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["user_detail_nacct_holder"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('account_no');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["acnumber"];?>
</p>
                        <input type="text" name="account_no" id="account_no" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["acnumber"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('ifsc');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["ifsc"];?>
</p>
                        <input type="text" name="ifsc" id="ifsc" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["ifsc"];?>
" class="form-control">
                    </div>
                      <!-- <div class="form-group">
                        <label><?php echo lang('pan');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["pan"];?>
</p>
                        <input type="text" name="pan" id="pan" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["pan"];?>
" class="form-control">
                    </div>-->
                    
                    
                            IF YOU HAVE AN AUSTRALIAN BANK ACCOUNT ONLY
                            <div class="form-group">
                                <label><?php echo lang('account_holder');?>
</label>
                                <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["nacct_australian_holder"];?>
</p>
                                <input type="text" name="australian_account_holder" id="nacct_australian_holder" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["nacct_australian_holder"];?>
" class="form-control">
                            </div>
                            
                               <div class="form-group">
                                <label><?php echo lang('account_no');?>
</label>
                                <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["acnumber_australian"];?>
</p>
                                <input type="text" name="acnumber_australian" id="acnumber_australian" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["acnumber_australian"];?>
" class="form-control">
                            </div>
                                <div class="form-group">
                                <label><?php echo lang('bsb_number');?>
</label>
                                <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["bsb"];?>
</p>
                                <input type="text" name="bsb" id="bsb" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["bsb"];?>
" class="form-control">
                            </div>
                            
                    <button type="button" class="btn btn-sm btn-primary" id="update_bank_info"><?php echo lang('update');?>
</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_bank_info"><?php echo lang('cancel');?>
</button>
                </div>
            </div>
        </div>
        <?php }?>
        <?php if (count($_smarty_tpl->tpl_vars['payment_gateway']->value) > 0) {?>
        <input type="radio" id="tab5" name="tab">
        <label class="tabButton" for="tab5"><?php echo lang('payment_details');?>
</label>
        <div class="tab" id="payment_details">
            <div class="content" id="payment_details_div">
                <div class="wrapper-md" >
                    <i class="fa fa-edit"id="edit_payment_details" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <?php $_smarty_tpl->_assignInScope('gateway_addr', '');
?>
                    <?php $_smarty_tpl->_assignInScope('gateway_id', '');
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['payment_gateway']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <div class="form-group">
                        <label>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['gateway_name'] == "Paypal") {?>
                                <?php echo lang('paypal_account');?>

                                <?php $_smarty_tpl->_assignInScope('gateway_addr', $_smarty_tpl->tpl_vars['profile_details']->value["paypal_account"]);
?>
                                <?php $_smarty_tpl->_assignInScope('gateway_id', "paypal_account");
?>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['gateway_name'] == "Bitcoin") {?>
                                <?php echo lang('blocktrail');?>

                                <?php $_smarty_tpl->_assignInScope('gateway_addr', $_smarty_tpl->tpl_vars['profile_details']->value["blocktrail_account"]);
?>
                                <?php $_smarty_tpl->_assignInScope('gateway_id', "blocktrail_account");
?>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['gateway_name'] == "Blockchain") {?>
                                <?php echo lang('blockchain_wallet_address');?>

                                <?php $_smarty_tpl->_assignInScope('gateway_addr', $_smarty_tpl->tpl_vars['profile_details']->value["blockchain_account"]);
?>
                                <?php $_smarty_tpl->_assignInScope('gateway_id', "blockchain_account");
?>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['gateway_name'] == "Bitgo") {?>
                                <?php echo lang('bitgo');?>

                                <?php $_smarty_tpl->_assignInScope('gateway_addr', $_smarty_tpl->tpl_vars['profile_details']->value["bitgo_account"]);
?>
                                <?php $_smarty_tpl->_assignInScope('gateway_id', "bitgo_account");
?>
                            <?php }?>
                        </label>
                        <p id="span-paypal_account" class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['gateway_addr']->value;?>
</p>
                        <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['gateway_addr']->value;?>
" class="form-control" name="<?php echo $_smarty_tpl->tpl_vars['gateway_id']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['gateway_id']->value;?>
">
                    </div>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <div class="new_line"></div>
                    <legend><span class="fieldset-legend"><?php echo lang('payment_method');?>
</span></legend>
                    <div class="form-group">
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value['payout_type'];?>
</p>
                        <select class="form-control" name="payment_method" id="payment_method">
                            <option value="bank"><?php echo lang('bank');?>
</option>
                            <?php if (count($_smarty_tpl->tpl_vars['gateway_list']->value) > 0) {?>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['gateway_list']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['gateway_name'];?>
" <?php if ($_smarty_tpl->tpl_vars['profile_details']->value['payout_type'] == $_smarty_tpl->tpl_vars['v']->value['gateway_name']) {?>selected="selected"<?php }?>><?php if ($_smarty_tpl->tpl_vars['v']->value['gateway_name'] == "Bitcoin") {
echo lang('blocktrail');
} else {
echo $_smarty_tpl->tpl_vars['v']->value['gateway_name'];
}?></option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            <?php }?>
                        </select>
                    </div>
                    <button type="button" id="update_payment_details" class="btn btn-sm btn-primary"><?php echo lang('update');?>
</button>
                    <button type="button" id="cancel_payment_details" class="btn btn-sm btn-info"><?php echo lang('cancel');?>
</button>
                </div>
            </div>
        </div>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['lang_status'] == 'yes') {?>
        <input type="radio" id="tab6" name="tab">
        <label class="tabButton" for="tab6"><?php echo lang('language');?>
</label>
        <div class="tab" id="language_info">
            <div class="content" id="language_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_language_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label><?php echo lang('language');?>
</label>
                        <p class="form-control-static"><?php echo ucfirst($_smarty_tpl->tpl_vars['profile_details']->value['lang_name']);?>
</p>
                        <select class="form-control" name="language" id="language">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LANG_ARR']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['lang_id'] == $_smarty_tpl->tpl_vars['profile_details']->value['lang_id']) {?> selected <?php }?>><?php echo ucfirst($_smarty_tpl->tpl_vars['v']->value['lang_name_in_english']);?>
</option>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </select>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="update_language_info"><?php echo lang('update');?>
</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_language_info"><?php echo lang('cancel');?>
</button>
                </div>
            </div>
        </div>
        <?php }?>
        
        
        <input type="radio" id="tab7" name="tab">
        <label class="tabButton" for="tab7"><?php echo lang('wallet_address');?>
</label>
        <div class="tab" id="wallet_info">
            <div class="content" id="wallet_info_div">
                <div class="wrapper-md">
                    <i class="fa fa-edit"id="edit_wallet_info" style="font-size:20px;color:#23b7e5;float:right;"></i>
                </div>
                <div role="form" class="ng-pristine ng-valid">
                    <div class="form-group">
                        <label><?php echo lang('bitcoin_address');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["bitcoin_address"];?>
</p>
                        <input type="text" name="bitcoin_address" id="bitcoin_address" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["bitcoin_address"];?>
" class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo lang('payeer_address');?>
</label>
                        <p class="form-control-static"><?php echo $_smarty_tpl->tpl_vars['profile_details']->value["payeer_address"];?>
</p>
                        <input type="text" name="payeer_address" id="payeer_address" value="<?php echo $_smarty_tpl->tpl_vars['profile_details']->value["payeer_address"];?>
" class="form-control">
                    </div>
                    
                    <button type="button" class="btn btn-sm btn-primary" id="update_wallet_info"><?php echo lang('update');?>
</button>
                    <button type="button" class="btn btn-sm btn-info" id="cancel_wallet_info"><?php echo lang('cancel');?>
</button>
                </div>
            </div>
        </div>
       
    </div>
    <div id="alert_div">
        <div id="alert_box_err" class="alert alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
    </div>
    <?php echo form_close();?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
