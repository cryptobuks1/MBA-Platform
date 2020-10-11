<?php
/* Smarty version 3.1.30, created on 2020-09-25 15:53:45
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/member/leads.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d85e9bc4fb4_48670571',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c726cb20171956709146fcb3c9c5b4a60c4e68fe' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/member/leads.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d85e9bc4fb4_48670571 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8341987555f6d85e9bc4253_49296964', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_8341987555f6d85e9bc4253_49296964 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


   

    <div class="panel panel-default  ng-scope">
    <div class="panel-body">
     <div class="your_lead_capture_link">
        <p>
            <?php echo lang('your_lead_capture_link');?>
:
            <?php if (DEMO_STATUS == 'yes') {?>
            <a class="text-primary" href="<?php echo SITE_URL;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['ADMIN_USER_NAME']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
" target="_blank">
                <?php echo SITE_URL;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['ADMIN_USER_NAME']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
 </a>
                <?php } else { ?>
                <a class="text-primary" href="<?php echo SITE_URL;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
" target="_blank">
                <?php echo SITE_URL;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
  </a>
                <?php }?>

        </p>
    </div>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><?php echo lang('sl_no');?>
</th>
                    <th><?php echo lang('name');?>
</th>
                    <th><?php echo lang('sponser_name');?>
</th>
                    <th><?php echo lang('email');?>
</th>
                    <th><?php echo lang('phone');?>
</th>
                    <th><?php echo lang('date');?>
</th>
                    <th><?php echo lang('status');?>
</th>
                    <th><?php echo lang('edit');?>
</th>
                </tr>
            </thead>
            <?php if (count($_smarty_tpl->tpl_vars['details']->value) > 0) {?>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['sponser_name']) {?> <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['sponser_name'] = 'NA';
$_smarty_tpl->_assignInScope('v', $_tmp_array);
}?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['email']) {?> <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['email'] = 'NA';
$_smarty_tpl->_assignInScope('v', $_tmp_array);
}?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['phone']) {?> <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['phone'] = 'NA';
$_smarty_tpl->_assignInScope('v', $_tmp_array);
}?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['date']) {?> <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['date'] = 'NA';
$_smarty_tpl->_assignInScope('v', $_tmp_array);
}?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['status']) {?> <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['status'] = 'NA';
$_smarty_tpl->_assignInScope('v', $_tmp_array);
}?>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>
                            <?php $_smarty_tpl->_assignInScope('tr_class', "tr1");
?>    
                        <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('tr_class', "tr2");
?>
                        <?php }?>
                        <tr class="<?php echo $_smarty_tpl->tpl_vars['tr_class']->value;?>
">
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['first_name'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['v']->value['last_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['sponser_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['phone'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['v']->value['date'] == 'NA') {
echo $_smarty_tpl->tpl_vars['v']->value['date'];
} else {
echo date('Y/m/d',strtotime($_smarty_tpl->tpl_vars['v']->value['date']));
}?></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
</td>
                            <td class="ipad_button_table">
                                <div class="field">
                                    <button class='has-tooltip btn btn_size btn-link text-info' onclick="getleadetails(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user');">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <span class='tooltip green'>
                                        <p><?php echo lang('edit');?>
</p>
                                    </span>
                                </div>
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
                        <td align="center" colspan="8"><b><?php echo lang('no_lead');?>
</b></td>
                    </tr>
                </tbody>
            <?php }?>
        </table>
        </div>
        </div>
    </div>

    <!------modal----->
    <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title" id="lineModalLabel">Lead details</h3>
                </div>
                <div class="modal-body panel-default table-responsive boder_none_modal" id="text_message" name="text_message">

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="base_url" id="baseURL" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/">
    <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
