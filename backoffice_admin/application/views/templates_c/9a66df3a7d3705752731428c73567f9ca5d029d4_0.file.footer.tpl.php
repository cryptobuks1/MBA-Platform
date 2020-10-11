<?php
/* Smarty version 3.1.30, created on 2020-09-16 22:22:14
  from "/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f620376137327_96762362',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9a66df3a7d3705752731428c73567f9ca5d029d4' => 
    array (
      0 => '/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/footer.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/chat.tpl' => 1,
  ),
),false)) {
function content_5f620376137327_96762362 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!-- footer -->
<footer id="footer" class="app-footer" role="footer">
    <div class="wrapper b-t bg-light">
        <span class="pull-right"><a href="javascript:scrollTop();" ui-scroll="app" class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span>
        <?php echo date('Y');?>
 &copy; <?php echo $_smarty_tpl->tpl_vars['site_info']->value['company_name'];?>

        <?php if ($_smarty_tpl->tpl_vars['DEMO_STATUS']->value == 'yes' && $_smarty_tpl->tpl_vars['is_app']->value) {?>
            - <a href="https://ioss.in" target="_blank" style="text-decoration: none; color: #169ac3;"><?php echo lang('developed_by_infinite_open_source_solution_llp');?>
</a>
        <?php }?>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['is_app']->value) {?>
    <?php $_smarty_tpl->_subTemplateRender("file:common/chat.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'','name'=>''), 0, false);
?>

    <?php }?>
</footer>
<!-- / footer -->
<?php }
}
