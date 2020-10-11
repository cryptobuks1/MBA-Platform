<?php
/* Smarty version 3.1.30, created on 2020-08-17 13:18:18
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/replica_configuration.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f39f6fa8b2732_59391008',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '916fb60940045b4b2b671f7a55a0c2be8cfecebb' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/replica_configuration.tpl',
      1 => 1576057489,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 5,
    'file:common/notes.tpl' => 1,
  ),
),false)) {
function content_5f39f6fa8b2732_59391008 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="msg1"><?php echo lang('facebook_url_is_required');?>
</span>
    <span id="msg2"><?php echo lang('twitter_url_is_required');?>
</span>
    <span id="msg3"><?php echo lang('youtube_url_is_required');?>
</span>
    <span id="msg4"><?php echo lang('instagram_url_is_required');?>
</span>
    <span id="msg5"><?php echo lang('linkedin_url_is_required');?>
</span>
    <span id="msg6"><?php echo lang('google_plus_url_is_required');?>
</span>
    <span id="msg7"><?php echo lang('youtube_url_is_not_valid');?>
</span>
    <span id="msg8"><?php echo lang('facebook_url_is_not_valid');?>
</span>
    <span id="msg9"><?php echo lang('google_plus_url_is_not_valid');?>
</span>
    <span id="msg10"><?php echo lang('linkedin_url_is_not_valid');?>
</span>
    <span id="msg11"><?php echo lang('twitter_url_is_not_valid');?>
</span>
    <span id="msg12"><?php echo lang('instagram_url_is_not_valid');?>
</span>
    <span id="msg13"><?php echo lang('you_must_enter_main_matter');?>
</span>
    <span id="msg14"><?php echo lang('title_url_is_required');?>
</span>
    <span id="msg15"><?php echo lang('address_url_is_required');?>
</span>

</div>    

    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab">
            <div class="panel-heading">
                <h4 class="panel-title"> <?php echo lang('top_banner');?>

                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            </a> 
            <div id="tab" class="panel-collapse panel-collapse collapse">
                <div class="panel-body">
                    <?php echo form_open_multipart('admin/configuration/content_management','role="form" class="" name="upload_materials" id="upload_materials1"');?>

                        <div class="form-group">
                            <label class="control-label required"><?php echo lang('upload_top_banner');?>
</label>
                                <div data-provides="fileupload" class="bg_file_upload"> 
                                    <input name="banner_image" id="banner_image" type="file" >                                           
                                </div>
                                <span class="help-block m-b-none"><?php echo lang('please_choose_a_png_file.');?>
</span>
                                <span class="help-block m-b-none"><?php echo lang('max_size_should_2MB');?>
</span>     
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="subtitle"><?php echo lang('current_top_banner');?>
</label>
                              <?php if (isset($_smarty_tpl->tpl_vars['content']->value['top_banner'])) {?>
                                  <input class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['content']->value['top_banner'];?>
" readonly='true' style="overflow: hidden;white-space: nowrap;">
                              <?php } else { ?>
                                  <input class="form-control" type="text" value="banner-tchnoly.jpg" readonly='true' style="overflow: hidden;white-space: nowrap;"> 
                              <?php }?>
                        </div>
                      <div class="form-group">
                          <button class="btn btn-sm btn-primary" name="submit_image" id="submit_image" type="submit" value="submit"><?php echo lang('upload');?>
</button>
                      </div>

                    <?php echo form_close();?>
             
                </div>                                        
            </div>
            
    </div>


                            
    <div class="panel panel-default">
     <a data-toggle="collapse" data-parent="#accordion" href="#tab-3">
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo lang('content_management');?>

                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-3"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            <div id="tab-3" class="panel-collapse panel-collapse collapse">
                <div class="panel-body"> 
                    <?php echo form_open_multipart('admin/configuration/content_management','role="form" class="" name= "content_form"  id="content_form"');?>

                    <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
                        <div class="form-group">
                            <label class="control-label required" for="subtitle"><?php echo lang('sub_title');?>
</label>
                              <input class="form-control"  id="subtitle"  name="subtitle" title="<?php echo lang('main_matter');?>
" value="<?php echo $_smarty_tpl->tpl_vars['subtitle']->value;?>
">
                              <?php echo form_error('subtitle');?>

                        </div>

                        <div class="form-group">
                          <label class="control-label required" for="replica_content_main"><?php echo lang('main_matter');?>
</label>
                            <textarea class="ckeditor form-control"  id="replica_content_main"  name="replica_content_main" title="<?php echo lang('main_matter');?>
"  rows="6"><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
</textarea>
                            <?php echo form_error('replica_content_main');?>

                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="replica_content" id="replica_content" type="submit" value="<?php echo lang('update');?>
" > <?php echo lang('update');?>
</button>
                        </div>
                    <?php echo form_close();?>

                </div>  
            </div>
            </a> 
    </div>
                                
  

    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-6">
            <div class="panel-heading">
                <h4 class="panel-title">  <?php echo lang('terms_and_conditions');?>

                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-6"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            <?php echo form_open_multipart('admin/configuration/content_management','role="form" class="" name= "terms_form"  id="terms_form"');?>
                                             
                <div id="tab-6" class="panel-collapse panel-collapse collapse">
                    <div class="panel-body">
                    <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea"><?php echo lang('main_matter');?>
</label>
                                <textarea class="ckeditor form-control"  id="content_terms"  name="content_terms" title="<?php echo lang('main_matter');?>
"  rows="6"><?php if (isset($_smarty_tpl->tpl_vars['content']->value['terms'])) {
echo $_smarty_tpl->tpl_vars['content']->value['terms'];
} else { ?>
                                All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more<?php }?></textarea>
                                <?php echo form_error('content_terms');?>

                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="submit_term" id="submit_term" type="submit" value="<?php echo lang('update');?>
" > <?php echo lang('update');?>
</button>
                        </div>
                    </div>   
                </div>
            <?php echo form_close();?>

            </a> 
    </div>

    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-7">
            <div class="panel-heading">
                <h4 class="panel-title"> <?php echo lang('privacy_policy');?>

                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-7"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            <?php echo form_open_multipart('admin/configuration/content_management','role="form" class="" name= "policy_form"  id="policy_form"');?>

                <div id="tab-7" class="panel-collapse panel-collapse collapse">
                    <div class="panel-body">
                        <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea"><?php echo lang('main_matter');?>
</label>
                            <textarea class="ckeditor form-control"  id="content_policy"  name="content_policy" title="<?php echo lang('main_matter');?>
" rows="6"><?php if (isset($_smarty_tpl->tpl_vars['content']->value['policy'])) {
echo $_smarty_tpl->tpl_vars['content']->value['policy'];
} else { ?>
                              All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more.
                            <?php }?>
                            </textarea>
                            <?php echo form_error('content_policy');?>

                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" name="submit_policy" id="submit_policy" type="submit" value="<?php echo lang('update');?>
" > <?php echo lang('update');?>
</button>
                        </div>
                    </div>
                </div> 
            <?php echo form_close();?>

            </a>
    </div>
                
    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-8">
            <div class="panel-heading">
                <h4 class="panel-title"> <?php echo lang('about_us');?>
 
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-8"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            <?php echo form_open_multipart('admin/configuration/content_management','role="form" class="" name= "about_form"  id="about_form"');?>

                <div id="tab-8" class="panel-collapse panel-collapse collapse">
                    <div class="panel-body">
                        <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea"><?php echo lang('main_matter');?>
</label>
                            <textarea class="ckeditor form-control"  id="content_about"  name="content_about" title="<?php echo lang('about_us');?>
" rows="6"><?php if (isset($_smarty_tpl->tpl_vars['content']->value['about_us'])) {
echo $_smarty_tpl->tpl_vars['content']->value['about_us'];
} else { ?>
                            The Infinite MLM software is an entire solution for all type of business plan like Binary,Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP™. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet, Replicating Website, E-Pin, E-Commerce Shopping Cart,Web Design<?php }?>
                            </textarea>
                            <?php echo form_error('content_about');?>

                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="submit_about" id="submit_policy" type="submit" value="<?php echo lang('update');?>
" > <?php echo lang('update');?>
</button>
                        </div>
                    </div> 
                </div>
            <?php echo form_close();?>
 
            </a>
    </div>
                
    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-9">
            <div class="panel-heading">
                <h4 class="panel-title"> <?php echo lang('contact_us');?>

                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-9"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
                <?php echo form_open_multipart('admin/configuration/content_management','role="form" class="" name= "address_form"  id="address_form"');?>

                    <div id="tab-9" class="panel-collapse panel-collapse collapse">
                        <div class="panel-body">
                            <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    
                                <div class="form-group">
                                  <label class=" control-label" for="txtDefaultHtmlArea"><?php echo lang('address');?>
</label>
                                    <textarea class="ckeditor form-control"  id="address"  name="address" title="<?php echo lang('contact_us');?>
" rows="6"><?php if (isset($_smarty_tpl->tpl_vars['content']->value['address'])) {
echo $_smarty_tpl->tpl_vars['content']->value['address'];
} else { ?>
                                    2nd Floor, TK Tower, Kettangal,NIT Campus (P.O.), Calicut - 673601, Kerala,<?php }?></textarea>
                                    <?php echo form_error('address');?>

                                </div>

                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary"  name="submit_address" id="submit_about" type="submit" value="<?php echo lang('update');?>
" > <?php echo lang('update');?>
</button>
                                </div>
                        </div>
                    </div>  
                <?php echo form_close();?>

                </a> 
    </div>
    
   


<?php $_smarty_tpl->_subTemplateRender("file:common/notes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('notes'=>lang('note_replication_configuration_page')), 0, false);
?>

                    <?php }
}
