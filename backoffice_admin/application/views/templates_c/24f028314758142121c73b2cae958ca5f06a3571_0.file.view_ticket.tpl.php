<?php
/* Smarty version 3.1.30, created on 2020-08-11 16:42:03
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/view_ticket.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f323dbbd28c31_83403712',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '24f028314758142121c73b2cae958ca5f06a3571' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/view_ticket.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f323dbbd28c31_83403712 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11802797875f323dbbd270c1_02128942', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14079903555f323dbbd288f4_15643814', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_11802797875f323dbbd270c1_02128942 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display:none;"> 
        <span id="error_msg1"><?php echo lang('you_must_enter_search_query');?>
</span>   
        <span id="error_msg2"><?php echo lang('please_provide_either_category_tags');?>
</span>   
    </div>
    <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
    <input type="hidden" id="path_root" name="path_root" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
">
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend"><?php echo lang('view_tickets');?>
</span></legend>
                <?php echo form_open_multipart('admin/view_ticket','role="form" class="" name="show_ticket" id="show_ticket" enctype="multipart/form-data"');?>

            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label><?php echo lang('category');?>
</label>
                    <select name="category_name" id="category_name" class="form-control">
                        <option value=""><?php echo lang('select_category');?>
</option>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>

                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['category_name'];?>
</option>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </select>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label><?php echo lang('tags');?>
</label>
                    <select name="tag-name" id="tag_name" class="form-control ">
                        <option value=""><?php echo lang('select_tag');?>
</option>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tags']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['tag'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['tag'];?>
</option>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </select>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <input name="submit_category" type="submit" id="submit_category" value="<?php echo lang('show');?>
" class="btn btn-sm btn-primary"  />
                </div>
            </div>
            <?php echo form_close();?>

        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend"><?php echo lang('find_ticket');?>
</span></legend>
                <?php echo form_open('admin/view_ticket','role="form" class="" method="post" name="search_ticket_form" id="search_ticket_form" enctype="multipart/form-data"');?>

            <div class="col-md-12">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i> <?php echo lang('errors_check');?>

                </div>
            </div>
            <div class="form-group">
                <label><?php echo lang('search_for');?>
</label>
                <input type="text" name="search_text" id="search_text" class="form-control">
            </div>
            <div class="form-group">
                <label><?php echo lang('search_in');?>
  </label>
                <select name="search_item" id="search_item" class="form-control">
                    <option value="ticket_id"><?php echo lang('ticket_id');?>
</option>
                    <option value="name"><?php echo lang('user_id');?>
</option>
                    <option value="assignee_name"><?php echo lang('assignee');?>
</option>
                    <option value="subject"><?php echo lang('subject');?>
</option>
                </select>
            </div>
            <div class="form-group">
            <a style="color:#1c486d;" role="menuitem" name="more_option" id="more_option" href="javascript:show_more()" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> More</a> 
            <a role="menuitem"  href="javascript:show_less()" name="less_option" id="less_option" style="display: none;" class="btn btn-sm btn-info"><i class="fa fa-minus"></i> Less </a>
            </div>
            <div id="more_search_type" style="display:none;">
                <div class="form-group">
                    <label><?php echo lang('category_name');?>
</label>
                    <select name="tckt_category" id="tckt_category" class="form-control">
                        <option value=""><?php echo lang('select_category');?>
</option>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>

                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['category_name'];?>
</option>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo lang('date');?>
</label>
                    <div class="input-group">
                        <input autocomplete="off" class="form-control date-picker"  name="week_date" id="week_date" type="text" size="20" maxlength="10"  value="" autocomplete="off"></div>
                </div>
                <div class="form-group">
                    <label class=" control-label"><?php echo lang('search_within');?>
 :</label>
                    <label class="checkbox-inline i-checks">
                        <div class="radio">
                            <label class="i-checks i-checks-sm">
                                <input type="checkbox"  value="1" name="s_my" id="s_my">
                                <i></i> <?php echo lang('assigned_to_me');?>
 </label>
                        </div>
                    </label>
                    <label class="checkbox-inline i-checks">
                        <div class="radio">
                            <label class="i-checks i-checks-sm">
                                <input type="checkbox"  value="1" name="s_ot" id="s_ot">
                                <i></i><?php echo lang('assigned_to_others');?>
</label>
                        </div>
                    </label>
                    <label class="checkbox-inline i-checks">
                        <div class="radio">
                            <label class="i-checks i-checks-sm">
                                <input type="checkbox"  value="1" name="s_un" id="s_un">
                                <i></i> <?php echo lang('unassingned_tickets');?>
  </label>
                        </div>
                    </label>
                    <label class="checkbox-inline i-checks">
                        <div class="radio">
                            <label class="i-checks i-checks-sm">
                                <input type="checkbox" value="1" name="archive" id="archive">
                                <i></i><?php echo lang('only_tagged_tickets');?>
</label>
                        </div>
                    </label>
                </div>
            </div>
            <div class="form-group mark_paid">
                <button type="submit" class="btn btn-sm btn-primary"  name="search_tickets" type="submit" id="search_tickets"  value="<?php echo lang('search');?>
" ><?php echo lang('search');?>
</button>
            </div>         
            <?php echo form_close();?>

        </div>
    </div>
    
    <div class="panel panel-default table-responsive">
    <div class="panel-body">
    <legend><span class="fieldset-legend"><?php if (isset($_smarty_tpl->tpl_vars['panel_title']->value)) {?> <?php echo $_smarty_tpl->tpl_vars['panel_title']->value;
} else {
echo lang('open_tickets');
}?></span></legend>
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <?php if (($_smarty_tpl->tpl_vars['count']->value > 0)) {?>
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
                <tbody>
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
')" onclick=""  class="btn-link text-primary tooltips" data-placement="top" title="<?php echo lang('timeline');?>
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
/* {block 'script'} */
class Block_14079903555f323dbbd288f4_15643814 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>
 
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
/javascript/misc.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
