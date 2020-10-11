<?php
/* Smarty version 3.1.30, created on 2020-08-05 20:47:48
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/live_session_videos.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a8e54630188_75228146',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4e5d54cbd72f19df2bf85b004b2a68b0ee99c4be' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/live_session_videos.tpl',
      1 => 1583137367,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2a8e54630188_75228146 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19654113285f2a8e5462e387_87096618', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>



                
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17717040695f2a8e5462fc46_87512610', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_19654113285f2a8e5462e387_87096618 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<style>
/*.videos-grid */

.videos-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 20px;
}

/*.videos-grid-video */

/*.videos-grid-video > iframe */
.videos-grid-video {
    background: #eee;
    border: 1px solid #dadada;
}
</style>
<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1"><?php echo lang('you_must_enter_subject');?>
</span>
    <span id="validate_msg2"><?php echo lang('you_must_enter_message');?>
</span>   
</div>


<div class="panel panel-default">
    <div class="tab">
        <div class="content">
                            <?php if (count($_smarty_tpl->tpl_vars['videos']->value) > 0) {?>
            <div class="videos-grid">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['videos']->value, 'video');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['video']->value) {
?>

                <div class="videos-grid-video">
                     <h5><?php echo $_smarty_tpl->tpl_vars['video']->value['package_name'];?>
</h5>
                     <div>
                <iframe width="100%" height="70%" src="https://player.vimeo.com/video/<?php echo substr($_smarty_tpl->tpl_vars['video']->value['video_link'],8);?>
" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
               </div>
                <h5><?php echo $_smarty_tpl->tpl_vars['video']->value['video_description'];?>
</h5>
                </div>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </div>
                        <?php } else { ?>
            <h4 align="center">
                    <font><?php echo lang('no_data');?>
</font>
                </h4>
                <?php }?>
        </div>
    </div>
</div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_17717040695f2a8e5462fc46_87512610 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
/javascript/validate_invite_wallpost.js"><?php echo '</script'; ?>
>

  



  <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
/javascript/fullcalendar/fullcalendar.min.js" type="text/javascript"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/fullcalendar/lib/jquery.min.js" type="text/javascript"><?php echo '</script'; ?>
>


     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/fullcalendar/lib/moment.min.js" type="text/javascript"><?php echo '</script'; ?>
>



   
<?php
}
}
/* {/block 'script'} */
}
