<?php
/* Smarty version 3.1.30, created on 2020-09-28 16:33:52
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/contact.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f7183d0bfb546_77649041',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6675a92262d926a85589b937c012d82c2c022fe9' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/contact.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:replica/error_box.tpl' => 1,
  ),
),false)) {
function content_5f7183d0bfb546_77649041 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_766874625f7183d0be5df8_46532068', 'style');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15461829225f7183d0bfaa86_84505406', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'style'} */
class Block_766874625f7183d0be5df8_46532068 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<style>
    .upper{
        text-transform: uppercase;
    }
    .no-display {
        display: none;
    }
</style>
<?php
}
}
/* {/block 'style'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_15461829225f7183d0bfaa86_84505406 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php $_smarty_tpl->_subTemplateRender("file:replica/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'','name'=>''), 0, false);
?>

<section id="contact" class="contact_section bd-bottom padding" data-scroll-id="contact" tabindex="-1" style="outline: none;">
    <div id="span_js_messages" style="display: none;">
        <span id="validate_contact_msg11"><font><?php echo lang('you_must_enter_a_name');?>
</font></span>
        <span id="validate_contact_msg12"><font><?php echo lang('only_characters_are_allowed');?>
</font></span>
        <span id="validate_contact_msg21"><font><?php echo lang('you_must_enter_an_email');?>
</font></span>
        <span id="validate_contact_msg22"><font><?php echo lang('you_must_enter_a_valid_email');?>
</font></span>
        <span id="validate_contact_msg31"><font><?php echo lang('you_must_enter_a_phone_number');?>
</font></span>
        <span id="validate_contact_msg32"><font><?php echo lang('only_digits');?>
</font></span>
        <span id="validate_contact_msg41"><font><?php echo lang('you_must_enter_an_address');?>
</font></span>
        <span id="validate_msg1"><font><?php echo lang('maxlength_n_allowed');?>
</font></span>
        <span id="validate_msg2"><font><?php echo lang('minlength_n_allowed');?>
</font></span>
        <span id="validate_msg3"><font><?php echo lang('maxlength_characte_allowedr_n');?>
</font></span>
    </div>

    <div class="container">
        <div class="contact_wrapper">
            <div class="col-md-6 sm-padding">
                <div class="section_heading mb-30">
                    <h2 class="upper"><?php echo lang('contact');?>
 <span><?php echo lang('Us');?>
</span></h2>
                    <p><?php echo $_smarty_tpl->tpl_vars['site_info']->value['company_name'];?>
</p>
                    <p><?php if (isset($_smarty_tpl->tpl_vars['content']->value['address'])) {
echo $_smarty_tpl->tpl_vars['content']->value['address'];?>

                        <?php } else {
echo $_smarty_tpl->tpl_vars['site_info']->value['company_address'];?>

                        <?php }?></p>
                </div>
            </div>
            <div class="col-md-6 sm-padding">
                <div class="contact_box">
                    <div class="section_heading mb-30">
                        <h2 class="upper"><?php echo lang('get_in');?>
 <span><?php echo lang('touch');?>
</h2>

                    </div><!-- /.section_heading -->
                    <div class="contact_form">
                        <?php echo form_open('replica/contact',' role="form" id="contact_form" method="post"
                        name="contact_form" class="form-horizontal footer_form"');?>

                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> <?php echo lang('errors_check');?>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo lang('Name');?>
"
                                    value="<?php if (isset($_smarty_tpl->tpl_vars['contact_post_array']->value['name'])) {
echo $_smarty_tpl->tpl_vars['contact_post_array']->value['name'];
}?>" />
                                <span class="help-block"></span><?php if (isset($_smarty_tpl->tpl_vars['contact_error']->value['name'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['contact_error']->value['name'];?>

                                </span><?php }?>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="email" id="email" class="form-control" placeholder="<?php echo lang('Email');?>
"
                                    value="<?php if (isset($_smarty_tpl->tpl_vars['contact_post_array']->value['email'])) {
echo $_smarty_tpl->tpl_vars['contact_post_array']->value['email'];
}?>">
                                <span class="help-block"></span><?php if (isset($_smarty_tpl->tpl_vars['contact_error']->value['email'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['contact_error']->value['email'];?>

                                </span><?php }?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="<?php echo lang('Phone_Number');?>
"
                                    value="<?php if (isset($_smarty_tpl->tpl_vars['contact_post_array']->value['phone'])) {
echo $_smarty_tpl->tpl_vars['contact_post_array']->value['phone'];
}?>">
                                <span class="help-block"></span><?php if (isset($_smarty_tpl->tpl_vars['contact_error']->value['phone'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['contact_error']->value['phone'];?>

                                </span><?php }?>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="address" id="address" class="form-control" placeholder="<?php echo lang('address');?>
"
                                    value="<?php if (isset($_smarty_tpl->tpl_vars['contact_post_array']->value['address'])) {
echo $_smarty_tpl->tpl_vars['contact_post_array']->value['address'];
}?>">
                                <span class="help-block"></span><?php if (isset($_smarty_tpl->tpl_vars['contact_error']->value['address'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['contact_error']->value['address'];?>

                                </span><?php }?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea rows="4" name="describe" id="describe" class="form-control" placeholder="<?php echo lang('Describe-yourself');?>
"> <?php if (isset($_smarty_tpl->tpl_vars['contact_post_array']->value['describe'])) {
echo $_smarty_tpl->tpl_vars['contact_post_array']->value['describe'];
}?></textarea>
                                <?php if (isset($_smarty_tpl->tpl_vars['contact_error']->value['describe'])) {?><span class='val-error'><?php echo $_smarty_tpl->tpl_vars['contact_error']->value['describe'];?>

                                </span><?php }?>
                            </div>
                        </div>

                        <button class="zarra_btn" type="submit" value="submit" name="submit" id="submit">
                            <?php echo lang('Submit');?>
</button>
                        <?php echo form_close();?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
