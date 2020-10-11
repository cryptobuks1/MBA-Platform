<?php
/* Smarty version 3.1.30, created on 2020-09-10 09:22:41
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/mail_content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f5963c16bedd8_88486613',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '099f907ed7594fba71e1b2264f9da6337c58a638' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/mail_content.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/configuration/system_setting_common.tpl' => 1,
    'file:admin/configuration/registration_mail.tpl' => 1,
    'file:admin/configuration/payout_release_mail.tpl' => 1,
  ),
),false)) {
function content_5f5963c16bedd8_88486613 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2689741235f5963c16be4d5_13638839', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2689741235f5963c16be4d5_13638839 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/system_setting_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div id="span_js_messages" style="display: none;"> 
    <span id="error_language"><?php echo lang('you_must_select_a language');?>
</span> 
    <span id="error_main_matter1"><?php echo lang('you_must_enter_main_matter');?>
</span> 
    <span id="error_terms_and_condition"><?php echo lang('you_must_enter_terms_and_conditions');?>
</span>
    <span id="validate_mail_content"><?php echo lang('you_must_enter_mail_content');?>
</span>
    <span id="validate_subject"><?php echo lang('you_must_enter_subject');?>
</span>
</div>

<main>
    <div class="tabsy">
        <input type="radio" id="tab3" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab3']->value) {?> checked <?php }?>>
          <label class="tabButton" for="tab3"><?php echo lang('registration_email');?>
</label>
            <div class="tab"><?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/registration_mail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>
</div>

        <input type="radio" id="tab4" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab4']->value) {?> checked <?php }?>>
          <label class="tabButton" for="tab4"><?php echo lang('payout_release_mail');?>
</label>
            <div class="tab"><?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/payout_release_mail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>
</div>
    </div>
</main>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
