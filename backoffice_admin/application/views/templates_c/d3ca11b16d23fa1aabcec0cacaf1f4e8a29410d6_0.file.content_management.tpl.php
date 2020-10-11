<?php
/* Smarty version 3.1.30, created on 2020-08-17 13:18:18
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/content_management.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f39f6fa880016_90232034',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd3ca11b16d23fa1aabcec0cacaf1f4e8a29410d6' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/content_management.tpl',
      1 => 1577177453,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/configuration/letter_config.tpl' => 1,
    'file:admin/configuration/termsconditions_config.tpl' => 1,
    'file:admin/configuration/replica_configuration.tpl' => 1,
    'file:admin/configuration/upgarde_terms.tpl' => 1,
    'file:admin/configuration/upgrade_text.tpl' => 1,
  ),
),false)) {
function content_5f39f6fa880016_90232034 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11569346235f39f6fa87f5b4_10922042', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_11569346235f39f6fa87f5b4_10922042 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
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
        <input type="radio" id="tab1" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab1']->value) {?> checked <?php }?>>
          <label class="tabButton" for="tab1"><?php echo lang('welcome_letter');?>
</label>
            <div class="tab"><?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/letter_config.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>
 </div>
             
                
        <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['opencart_status_demo'] == "no" || $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['opencart_status'] == "no") {?>
        <input type="radio" id="tab2" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab2']->value) {?> checked <?php }?>>
          <label class="tabButton" for="tab2"><?php echo lang('terms_and_conditions');?>
</label>
            <div class="tab"><?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/termsconditions_config.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>
</div>
        <?php }?>
       
        
        <?php if (DEMO_STATUS == 'yes' && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['opencart_status'] == 'yes' && $_smarty_tpl->tpl_vars['is_preset_demo']->value) {?>
        <?php } else { ?>
        <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['replicated_site_status'] == 'yes') {?>  
        <input type="radio" id="tab5" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab5']->value) {?> checked <?php }?>>
          <label class="tabButton" for="tab5"><?php echo lang('replica_site');?>
</label>
            <div class="tab"><?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/replica_configuration.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>
</div>
        <?php }?>  
        <?php }?>
        <input type="radio" id="tab3" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab3']->value) {?> checked <?php }?>>
          <label class="tabButton" for="tab3"><?php echo lang('upgradeTerms');?>
</label>
            <div class="tab"><?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/upgarde_terms.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>
</div>
            
            <input type="radio" id="tab6" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab6']->value) {?> checked <?php }?>>
          <label class="tabButton" for="tab6"><?php echo lang('upgrade_text');?>
</label>
            <div class="tab"><?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/upgrade_text.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>
</div>
    </div>
</main>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
