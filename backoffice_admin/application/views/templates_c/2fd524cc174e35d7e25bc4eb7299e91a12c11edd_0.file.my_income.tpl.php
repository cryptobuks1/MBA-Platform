<?php
/* Smarty version 3.1.30, created on 2020-08-16 20:48:03
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/payout/my_income.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f390ee34841e3_58118949',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2fd524cc174e35d7e25bc4eb7299e91a12c11edd' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/payout/my_income.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/search_member.tpl' => 1,
  ),
),false)) {
function content_5f390ee34841e3_58118949 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14822985445f390ee3483802_03685897', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_14822985445f390ee3483802_03685897 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" class="no-display">
    <span id="error_msg"><?php echo lang('you_must_enter_user_name');?>
</span>
    <span id="row_msg"><?php echo lang('rows');?>
</span>
    <span id="show_msg"><?php echo lang('shows');?>
</span>
    <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
    <input type="hidden" id="path_root" name="path_root" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
">
</div>

<div id="page_path" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/</div>

<?php $_smarty_tpl->_subTemplateRender("file:layout/search_member.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php if ($_smarty_tpl->tpl_vars['valid_user']->value) {?>
    <div id="user_account"></div>
    <div id="username_val" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</div>

   

    <div class="panel panel-default">
    <div class="panel-body">
     <legend>
        <span class="fieldset-legend"><?php echo lang('released_income');?>
: <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th><?php echo lang('sl_no');?>
</th>
                    <th><?php echo lang('paid_date');?>
</th>
                    <th><?php echo lang('paid_amount');?>
</th>
                    <th><?php echo lang('status');?>
</th>
                </tr>
            </thead>
            <?php if (count($_smarty_tpl->tpl_vars['income_statement']->value) > 0) {?>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['income_statement']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paid_date'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['paid_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                            <td><?php echo lang(ucfirst($_smarty_tpl->tpl_vars['v']->value['paid_type']));?>
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
                            <h4><?php echo lang('no_income_found');?>
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
