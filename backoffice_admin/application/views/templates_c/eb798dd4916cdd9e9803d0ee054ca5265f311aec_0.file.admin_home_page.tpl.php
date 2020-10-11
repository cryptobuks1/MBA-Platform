<?php
/* Smarty version 3.1.30, created on 2020-08-05 22:05:04
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/admin_home_page.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2aa070545018_94198182',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb798dd4916cdd9e9803d0ee054ca5265f311aec' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/admin_home_page.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2aa070545018_94198182 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11230287715f2aa070544440_18894965', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_11230287715f2aa070544440_18894965 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="row">
        <div class="col-sm-3">
            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/tickets/all" target="_blank">
                <div class="card mb-4 bg-primary">
                    <div class="card-body">
                        <div class="media d-flex align-items-center ">
                            <div class="mr-4 rounded-circle bg-white sr-icon-box text-purple"> <i class="fa fa-ticket"></i> </div>
                            <div class="text-light">
                                <h4 class="text-uppercase mb-0 weight500"><?php echo lang('total_tickets');?>
</h4>
                                <span><?php echo $_smarty_tpl->tpl_vars['total_ticket']->value;?>
</span> </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class=" col-sm-3">
            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/tickets/progress" target="_blank">
                <div class="card mb-4 bg-info">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-white  sr-icon-box text-primary"> <i class="fa fa-file-excel-o"></i> </div>
                            <div class=" text-white">
                                <h4 class="text-uppercase mb-0 weight500"><?php echo lang('in_progress');?>
</h4>
                                <span><?php echo $_smarty_tpl->tpl_vars['inprogress_ticket']->value;?>
</span> </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class=" col-sm-3">
            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/tickets/critical" target="_blank">
                <div class="card mb-4 bg-primary">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-white sr-icon-box text-danger"> <i class="fa fa-file-o"></i> </div>
                            <div class="text-white">
                                <h4 class="text-uppercase mb-0 weight500"><?php echo lang('critical');?>
</h4>
                                <span><?php echo $_smarty_tpl->tpl_vars['critical_ticket']->value;?>
</span> </div>
                        </div>
                    </div>
                </div>
           </a>
        </div>
        <div class="col-sm-3">
           <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/tickets/new" target="_blank">
                <div class="card mb-4 bg-info">
                    <div class="card-body">
                        <div class="media d-flex align-items-center">
                            <div class="mr-4 rounded-circle bg-white sr-icon-box text-success"> <i class="fa fa-file-text-o"></i> </div>
                            <div class="text-white">
                                <h4 class="text-uppercase mb-0 weight500"><?php echo lang('new_ticket');?>
</h4>
                                <span><?php echo $_smarty_tpl->tpl_vars['new_ticket']->value;?>
</span> </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
    <input type="hidden" id="path_root" name="path_root" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
">

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
                        <th><?php echo lang('status');?>
</th>
                        <th><?php echo lang('category');?>
</th>
                        <th><?php echo lang('last_replier');?>
</th>
                        <th><?php echo lang('priority');?>
</th>
                        <th><?php echo lang('timeline');?>
</th>
                    </tr>
                </thead>
                <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                <?php $_smarty_tpl->_assignInScope('class', '');
?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tickets']->value, 'v');
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
                    <tbody>
                        <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
"  >
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page']->value+1;?>
</td>

                            <td><a href="ticket/<?php echo $_smarty_tpl->tpl_vars['v']->value['ticket_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['read'] == '0') {?>style='color:#007AFF'<?php } else { ?>style='color:#C48189;'<?php }?>> <?php echo $_smarty_tpl->tpl_vars['v']->value['ticket_id'];?>
</a></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['updated'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['subject'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['category_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['last_replier'];?>
</td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['v']->value['priority_name'];?>
 
                            </td>
                            <td><a href="javascript:show_timeline('<?php echo $_smarty_tpl->tpl_vars['v']->value['ticket_id'];?>
')" onclick=""  class="btn-link text-primary" data-placement="top" title="<?php echo lang('timeline');?>
"><i class="glyphicon glyphicon-fullscreen"></i>
                                </a></td>
                        </tr>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <?php } else { ?> 
                <div style="text-align: center">  <h3><?php echo lang('no_ticket_found');?>
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
