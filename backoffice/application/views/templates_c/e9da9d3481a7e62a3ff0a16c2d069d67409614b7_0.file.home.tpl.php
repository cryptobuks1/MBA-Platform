<?php
/* Smarty version 3.1.30, created on 2020-09-25 14:45:48
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d75fc9de2f8_37821126',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9da9d3481a7e62a3ff0a16c2d069d67409614b7' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/home.tpl',
      1 => 1583134236,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d75fc9de2f8_37821126 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5008153135f6d75fc9dd9f6_34639209', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_5008153135f6d75fc9dd9f6_34639209 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		
		 <section class="content_section bd-bottom">
		    <div class="container">
		        <div class="content_wrapper">
		            <div class="col-md-6">
                        <div class="content_info">
                            <h2><?php echo $_smarty_tpl->tpl_vars['subtitle']->value;?>
</h2>
                            <p><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
</p>
                             
                            <a href="#" class="zaara_btn_2 hidden">Learn More</a>
                        </div>
		            </div>
		            <div class="col-md-6 hidden-xs hidden-sm wow fadeInRight" data-wow-delay="200ms" data-wow-duration="800ms" style="visibility: visible; animation-duration: 800ms; animation-delay: 200ms; animation-name: fadeInRight;">
		                <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
/replica/theme/img/image1.png" alt="image">
		            </div>
		        </div>
		    </div>
		</section>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
