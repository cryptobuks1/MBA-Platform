<?php
/* Smarty version 3.1.30, created on 2020-09-03 19:32:57
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/my_report/binary_history.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f50b8493953e9_16953806',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd4a2e3289fd9c520a4494795392e953c978e33f0' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/my_report/binary_history.tpl',
      1 => 1580447872,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f50b8493953e9_16953806 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11703091895f50b8493945e5_70958977', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_11703091895f50b8493945e5_70958977 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="button_back">
        <a href="<?php echo BASE_URL;?>
/admin/genology_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i><?php echo lang('back');?>
</button></a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open_multipart('','role="form" class="" name="searchform" id="searchform" method="post"');?>

            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i> <?php echo lang('errors_check');?>

            </div>
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label><?php echo lang('select_user_name');?>
</label>
                    <input class="form-control user_autolist" name="user_name" id="user_name" type="text" autocomplete="off" <?php if (isset($_smarty_tpl->tpl_vars['username']->value)) {?> value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
" <?php }?> >
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label><?php echo lang('select_level');?>
</label>

                    <select name="level" id="level" class="form-control">
                        <option value="all"><?php echo lang('all');?>
</option>
                        <?php
$_smarty_tpl->tpl_vars['level'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['level']->step = 1;$_smarty_tpl->tpl_vars['level']->total = (int) ceil(($_smarty_tpl->tpl_vars['level']->step > 0 ? $_smarty_tpl->tpl_vars['level_arr']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['level_arr']->value)+1)/abs($_smarty_tpl->tpl_vars['level']->step));
if ($_smarty_tpl->tpl_vars['level']->total > 0) {
for ($_smarty_tpl->tpl_vars['level']->value = 1, $_smarty_tpl->tpl_vars['level']->iteration = 1;$_smarty_tpl->tpl_vars['level']->iteration <= $_smarty_tpl->tpl_vars['level']->total;$_smarty_tpl->tpl_vars['level']->value += $_smarty_tpl->tpl_vars['level']->step, $_smarty_tpl->tpl_vars['level']->iteration++) {
$_smarty_tpl->tpl_vars['level']->first = $_smarty_tpl->tpl_vars['level']->iteration == 1;$_smarty_tpl->tpl_vars['level']->last = $_smarty_tpl->tpl_vars['level']->iteration == $_smarty_tpl->tpl_vars['level']->total;?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['level']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['binary_level']->value == $_smarty_tpl->tpl_vars['level']->value) {?>selected=""<?php }?>><?php echo $_smarty_tpl->tpl_vars['level']->value;?>
</option>
                        <?php }
}
?>

                    </select>

                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label><?php echo lang('select_type');?>
</label>
                    <select name="type" id="type" class="form-control">
                        <option value="all"<?php if ($_smarty_tpl->tpl_vars['type']->value == 'all') {?>selected = ""<?php }?>><?php echo lang('all');?>
</option>
                        <option value="affiliate"<?php if ($_smarty_tpl->tpl_vars['type']->value == 'affiliate') {?>selected = ""<?php }?>><?php echo lang('affiliate');?>
</option>
                        <option value="customer"<?php if ($_smarty_tpl->tpl_vars['type']->value == 'customer') {?>selected = ""<?php }?>><?php echo lang('customer');?>
</option>
                    </select>

                </div>
            </div>
             <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label><?php echo lang('select_rank_name');?>
</label>
                    <input class="form-control rank_autolist" name="rank_name" id="rank_name" type="text" autocomplete="off"  >
                </div>
            </div>
            
            
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary m-t-t-t" id="user_details" value="<?php echo lang('search');?>
" name="user_details"><?php echo lang('search');?>
</button>
                </div>
            </div>
            <?php echo form_close();?>

        </div>
    </div>

    <div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">[<?php echo lang('downline_list');?>
: <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
]</span> 
    <?php if ($_smarty_tpl->tpl_vars['rank_name']->value) {?>
    <span class="fieldset-legend">[<?php echo lang('rank_name');?>
: <?php echo $_smarty_tpl->tpl_vars['rank_name']->value;?>
]</span>
    <?php }?>
    </legend>
    <div class=" table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th" align="center">
                    <th><?php echo lang('slno');?>
</th>
                    <th><?php echo lang('user_name');?>
</th>
                    <th><?php echo lang('name');?>
</th>
                    <th><?php echo lang('enrollment_date');?>
</th>
                    <th><?php echo lang('level');?>
</th>
                    <th><?php echo lang('state');?>
</th>
                    <th><?php echo lang('country');?>
</th>
                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes') {?>
                        <th><?php echo lang('Rank');?>
</th>
                    <?php }?>
                    <th><?php echo lang('genealogy');?>
</th>
                </tr>
            </thead>
            <?php if (count($_smarty_tpl->tpl_vars['binary']->value) > 0) {?>
                <?php $_smarty_tpl->_assignInScope('i', ((string)$_smarty_tpl->tpl_vars['start']->value));
?>
                <?php $_smarty_tpl->_assignInScope('class', '');
?>
                <tbody>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['binary']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
<b class="badge label-primary-1"><?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == 'yes') {
echo lang('active');
} else {
echo lang('inactive');
}?></b></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['date_of_joining'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['level'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['state'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['country'];?>
</td>
                            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes') {?>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['rank']) {?>
                                    <td><span class="rank_color_code" style="background-color:<?php echo $_smarty_tpl->tpl_vars['v']->value['rank_color'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['rank'];?>
</td>
                                <?php } else { ?>
                                    <td><span class="rank_color_code"><?php echo lang('na');?>
</td>
                                <?php }?>
                            <?php }?>
                            <td><a tabindex="<?php echo $_smarty_tpl->tpl_vars['i']->value+3;?>
" href=<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/tree/genology_tree?user_name=<?php echo $_smarty_tpl->tpl_vars['v']->value['username'];?>
 target="_blank" style="color: #20afa6;"><i class="clip-tree" ></i>&nbsp;<?php echo lang('view_genealogy');?>
</a></td>
                        </tr>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr><td colspan="9" align="center"><h4 align="center"><?php echo lang('no_details_found');?>
</h4></td></tr>
                </tbody>
            <?php }?>
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
