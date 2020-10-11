<?php
/* Smarty version 3.1.30, created on 2020-08-17 13:18:18
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/letter_config.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f39f6fa896154_53746875',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6cacec9e1612d5113ffbd7370ecac571da496f1e' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/letter_config.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f39f6fa896154_53746875 (Smarty_Internal_Template $_smarty_tpl) {
?>

        <div class="content">
            <?php echo form_open_multipart('admin/configuration/content_management','role="form" class="" name= "letter_config"  id="letter_config"');?>

                <?php if ($_smarty_tpl->tpl_vars['LANG_STATUS']->value == 'yes') {?>
                    <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    
                    <div class="form-group">
                        <label class="control-label" for="lang_selector"><?php echo lang('Select_a_Language');?>
</label>
                            <select  class="form-control"  name="lang_selector" id='lang_selector' onchange="set_language_id(this.value, 'letter');" >
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['lang_arr']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                    <?php if ($_smarty_tpl->tpl_vars['lang_id']->value == $_smarty_tpl->tpl_vars['v']->value['lang_id']) {?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_id'];?>
" selected=""><?php echo $_smarty_tpl->tpl_vars['v']->value['lang_name'];?>
</option>
                                    <?php } else { ?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['lang_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['lang_name'];?>
</option>
                                    <?php }?>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </select>
                            <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_smarty_tpl->tpl_vars['lang_id']->value;?>
"/>
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
"/>
                    </div>
                <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['LANG_STATUS']->value == 'no') {?>
                    <input type="hidden" name="lang_id" id="lang_id" value="1"/>
                <?php }?>

                <div class="form-group">
                    <label class="control-label" for="txtDefaultHtmlArea"><?php echo lang('main_matter');?>
</label>
                        <textarea class="ckeditor form-control"  id="txtDefaultHtmlArea"  name="txtDefaultHtmlArea" title="<?php echo lang('main_matter');?>
" >
                            <?php echo $_smarty_tpl->tpl_vars['letter_arr']->value["main_matter"];?>

                        </textarea>
                        <?php echo form_error('txtDefaultHtmlArea');?>

                </div>
                    
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" name="setting" id="setting" type="submit" value="<?php echo lang('update');?>
" > <?php echo lang('update');?>
</button>
                </div>
            <?php echo form_close();?>

        </div><?php }
}
