<?php
/* Smarty version 3.1.30, created on 2020-08-23 08:32:16
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/my_referal.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f419cf012a0b8_97034039',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3094a9a5f6674ac6e2fbe6e19486dd7e252b0f69' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/my_referal.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/search_member.tpl' => 1,
  ),
),false)) {
function content_5f419cf012a0b8_97034039 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16268338235f419cf01296b2_56702173', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_16268338235f419cf01296b2_56702173 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" class="no-display">
    <span id="errmsg1"><?php echo lang('you_must_enter_user_name');?>
</span>
    <span id="row_msg"><?php echo lang('rows');?>
</span>
    <span id="show_msg"><?php echo lang('shows');?>
</span>
    <span id="error_msg"><?php echo lang('you_must_enter_user_name');?>
</span>
</div>

<div id="page_path" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/</div>

<?php $_smarty_tpl->_subTemplateRender("file:layout/search_member.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php if (isset($_smarty_tpl->tpl_vars['user_name']->value) && $_smarty_tpl->tpl_vars['is_valid_username']->value) {?>
    <div id="user_account"></div>
    <div id="username_val" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</div>

 

    <div class="panel panel-default">
 
    <div class="panel-body">
       <legend>
        <span class="fieldset-legend"><?php echo lang('referal_details');?>
: <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th><?php echo lang('sl_no');?>
</th>
                    <th><?php echo lang('user_name');?>
</th>
                    <th><?php echo lang('full_name');?>
</th>
                    <th><?php echo lang('joinig_date');?>
</th>
                    <th><?php echo lang('email');?>
</th>
                    <th><?php echo lang('country');?>
</th>
                </tr>
            </thead>
            <?php if (count($_smarty_tpl->tpl_vars['arr']->value) > 0) {?>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['join_date'];?>
</td>
                            <td> <?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['country'];?>
</td>
                        </tr>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4><?php echo lang('no_referels');?>
</h4>
                        </td>
                    </tr>
                </tbody>
            <?php }?>
        </table>
        </div>
        </div>
    </div>
    <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php }?>


<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
