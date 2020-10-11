<?php
/* Smarty version 3.1.30, created on 2020-08-05 22:05:38
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/tickets.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2aa092a67877_75385924',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4876ff753ddda2cc0b268a352113daa5aa3a135c' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/tickets.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2aa092a67877_75385924 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1313686285f2aa092a66dd0_28295384', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>
 <?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_1313686285f2aa092a66dd0_28295384 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="panel">
       <div class="panel-body">
       
       <legend><span class="fieldset-legend"><?php echo $_smarty_tpl->tpl_vars['ticket_type']->value;?>
</span></legend>
    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped" id="sample_1">
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
                        <th><?php echo lang('status');?>
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
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['open_tickets']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page']->value+1;?>
</td>
                            <td><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/ticket_system/ticket/<?php echo $_smarty_tpl->tpl_vars['v']->value['ticket_id'];?>
" ><span class="btn-light-gray w-xs btn-light-grey m-b-xs"><?php echo $_smarty_tpl->tpl_vars['v']->value['ticket_id'];?>
</span></a></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['updated'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                            <td> <?php echo $_smarty_tpl->tpl_vars['v']->value['subject'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
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
    </div>
    <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>
    
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
