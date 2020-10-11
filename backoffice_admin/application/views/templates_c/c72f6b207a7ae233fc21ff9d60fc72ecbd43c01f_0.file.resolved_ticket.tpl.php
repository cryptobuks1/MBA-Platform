<?php
/* Smarty version 3.1.30, created on 2020-08-26 15:01:18
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/resolved_ticket.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f45ec9e580c60_74044483',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c72f6b207a7ae233fc21ff9d60fc72ecbd43c01f' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/resolved_ticket.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f45ec9e580c60_74044483 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15375701745f45ec9e580148_46303005', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>
 <?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_15375701745f45ec9e580148_46303005 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display:none;">
        <span id="confirm_msg1"><?php echo lang('sure_you_want_to_assign_ticket_to_another_person');?>
</span>
        <input type="hidden" id="path_root" name="path_root" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
">
    </div>
    <div class="panel panel-default table-responsive">
    <div class="panel-body">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
                <thead>
                    <tr>
                        <th><?php echo lang('sl_no');?>
</th>
                        <th><?php echo lang('ticket_id');?>
</th>
                        <th><?php echo lang('updated');?>
</th>
                        <th><?php echo lang('user_id');?>
</th>
                        <th><?php echo lang('subject');?>
</th>
                        <th><?php echo lang('category');?>
</th>
                        <th><?php echo lang('last_replier');?>
</th>
                        <th><?php echo lang('assigned_to');?>
</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                    <?php $_smarty_tpl->_assignInScope('class', '');
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['open_tickets']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>
                            <?php $_smarty_tpl->_assignInScope('class', 'tr1');
?>
                        <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('class', 'tr2');
?>
                        <?php }?>
                        <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+1+$_smarty_tpl->tpl_vars['page']->value;?>
</td>
                            <td><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/ticket/<?php echo $_smarty_tpl->tpl_vars['v']->value['ticket_id'];?>
" ><span class="m-b-xs w-xs btn-warning"><?php echo $_smarty_tpl->tpl_vars['v']->value['ticket_id'];?>
</span></a></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['updated'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                            <td> <?php echo $_smarty_tpl->tpl_vars['v']->value['subject'];?>
</td>                                   
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['category_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['last_replier'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['assignee_name'];?>
</td>
                        </tr>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <?php } else { ?> 
                <div style="text-align: center"><h3><?php echo lang('no_open_tickets_found');?>
</h3></div>
                    <?php }?>
            </tbody>
        </table>
        </div>
    </div>
<?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
