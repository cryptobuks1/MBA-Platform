<?php
/* Smarty version 3.1.30, created on 2020-09-26 16:51:22
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/lcp/home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6ee4eaf368b4_11679947',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '28bb866c6c541762f0a8433522b2925af08b8b60' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/lcp/home.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:lcp/error_box.tpl' => 1,
  ),
),false)) {
function content_5f6ee4eaf368b4_11679947 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3080970275f6ee4eaf34d56_46084446', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17544835945f6ee4eaf365a9_78903755', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_3080970275f6ee4eaf34d56_46084446 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="container">
    <div class="padding_top"></div>
    <div class="row">
        <div id="span_js_messages" style="display:none;">
            <span id="error_msg1"> <?php echo lang('you_must_enter_your_name');?>
</span>
            <span id="error_msg2"><?php echo lang('you_must_enter_your_email_id');?>
</span>
            <span id="error_msg3"><?php echo lang('please_enter_a_valid_number');?>
</span>
            <span id="error_msg4"><?php echo lang('invalid_email_format');?>
</span>
            <span id="error_msg5"><?php echo lang('you_must_enter_your_last_name');?>
</span>
            <span id="error_msg6"><?php echo lang('you_must_enter_your_phone_number');?>
</span>
            <span id="error_msg7"><?php echo lang('atleast_3_char');?>
</span>
            <span id="error_msg8"><?php echo lang('no_more_than_32_char');?>
</span>
            <span id="error_msg9"><?php echo lang('alpha_space');?>
</span>
            <span id="error_msg10"><?php echo lang('no_more_than_200_char');?>
</span>
        </div>
        <div class="col-md-6 col-md-offset-3">
            <div class="text-center lcp_logo">
                <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value['logo'];?>
">
            </div>

            <?php $_smarty_tpl->_subTemplateRender("file:lcp/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

            <div class="panel panel-default">
                <div class="panel-tools">
                        <?php if ($_smarty_tpl->tpl_vars['LANG_STATUS']->value == 'yes') {?>
                        <div class="header_lang">
                            <div class="dropdown">						 
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LANG_ARR']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                    <?php if ($_smarty_tpl->tpl_vars['LANG_ID']->value == $_smarty_tpl->tpl_vars['v']->value['lang_id']) {?> 
                                        <button class="dropbtn">
                                            <img src='<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/flags/<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_code'];?>
.png' title="<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_name'];?>
"/>
                                        </button>
                                    <?php }?>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


                                <div class="dropdown-content">   
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['LANG_ARR']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                         
                                        <a href="javascript:getSwitchLanguage('<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_code'];?>
');">

                                            <img src='<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/flags/<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_code'];?>
.png'/>&nbsp;<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_name'];?>

                                        </a>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                </div>
                            </div>                
                        </div>
                    <?php }?>
                </div>
                <div class="panel-body">
                    <h4 class="text-center"><?php echo lang('fill_out_the_form_below');?>
</h4>
                    
                    <?php echo form_open('lcp/home','role = "form" name="lcp_form" id="lcp_form" method="post"');?>

                        <input type="hidden" id="path_root" name="path_root" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
"/>  
                    <div class="form-group">
                            <label><?php echo lang('first_name');?>
 <font color="#ff0000">*</font></label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['lcp_post_array']->value['first_name'])) {
echo $_smarty_tpl->tpl_vars['lcp_post_array']->value['first_name'];
}?>">
                            <?php if (isset($_smarty_tpl->tpl_vars['lcp_error']->value['first_name'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['lcp_error']->value['first_name'];?>
</span><?php }?>
                        </div>
                        <div class="form-group">
                            <label><?php echo lang('last_name');?>
 <font color="#ff0000">*</font></label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['lcp_post_array']->value['last_name'])) {
echo $_smarty_tpl->tpl_vars['lcp_post_array']->value['last_name'];
}?>">
                            <?php if (isset($_smarty_tpl->tpl_vars['lcp_error']->value['last_name'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['lcp_error']->value['last_name'];?>
 </span><?php }?>
                        </div>
                        <div class="form-group">
                            <label><?php echo lang('Your_Best_Email_Address');?>
 <font color="#ff0000">*</font></label>
                            <input type="text" name="email" id="email_id" class="form-control" value="<?php if (isset($_smarty_tpl->tpl_vars['lcp_post_array']->value['email'])) {
echo $_smarty_tpl->tpl_vars['lcp_post_array']->value['email'];
}?>">
                            <?php if (isset($_smarty_tpl->tpl_vars['lcp_error']->value['email'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['lcp_error']->value['email'];?>
 </span><?php }?>
                        </div>
                        <div class="form-group">
                            <label><?php echo lang('skype_id');?>
</label>
                            <input type="text" name="skype_id" id="skype_id" class="form-control">
                            <?php if (isset($_smarty_tpl->tpl_vars['lcp_error']->value['skype_id'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['lcp_error']->value['skype_id'];?>
 </span><?php }?>
                        </div>
                        <div class="form-group">
                            <label><?php echo lang('Your_Telephone_Cell_Number');?>
 <font color="#ff0000">*</font></label>
                            <input type="tel" name="phone" id="phone" class="form-control">
                            <?php if (isset($_smarty_tpl->tpl_vars['lcp_error']->value['phone'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['lcp_error']->value['phone'];?>
 </span><?php }?>
                        </div>
                        <div class="form-group">
                            <label ><?php echo lang('select_country');?>
</label>
                            <select class="form-control" name="country" id="country">
                                <option value="" class="form-control"><?php echo lang('select');?>
 </option>
                                <?php echo $_smarty_tpl->tpl_vars['countries']->value;?>

                            </select>
                            <?php if (isset($_smarty_tpl->tpl_vars['lcp_error']->value['country'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['lcp_error']->value['country'];?>
 </span><?php }?>
                        </div>
                        <div class="form-group">
                            <label><?php echo lang('Your_Comments_Please');?>
</label>
                            <textarea type="text" name="comment" id="comment" class="form-control" coloum="4" maxlength="200"><?php if (isset($_smarty_tpl->tpl_vars['lcp_post_array']->value['comment'])) {
echo $_smarty_tpl->tpl_vars['lcp_post_array']->value['comment'];
}?> </textarea>
                        </div>
                        <button type="submit" id="add_lcp" name="add_lcp" value="add_lcp" class="btn btn-sm btn-primary"><?php echo lang('Submit');?>
</button>
                    <?php echo form_close();?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_17544835945f6ee4eaf365a9_78903755 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/validatecontact.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
