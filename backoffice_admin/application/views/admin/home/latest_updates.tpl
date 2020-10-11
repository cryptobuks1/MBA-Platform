{extends file=$BASE_TEMPLATE}
{block name="script"} {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/validate_edit_profile.js"></script>
     <script src="{$PUBLIC_URL}javascript/validate_rank_configuration.js"></script>
{/block}
{block name=$CONTENT_BLOCK}
     <div id="span_js_messages" style="display:none;">
<span id="confirm_inactivate">{lang('sure_you_want_to_inactivate')}</span>
<span id="confirm_activate">{lang('sure_you_want_to_activate')}</span>
   
</div>

    <div class="panel panel-default">
        {if $banner_count ==0}
        <div class="panel-body">
            {form_open_multipart('admin/home/upload_banner','role="form" class="" name= ""  id=""')}
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="control-label pro-label">{lang('Banner_update')}</label>
                    <div data-provides="" class=" ">
                        <input name="file3" id="file3" type="file">
                        <label>{lang('select_file')}</label>
                    </div>
                </div>
            </div>
             <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('url')}</label>
                    <input type="text" name="bannerurl" id="bannerurl" class="form-control" placeholder="https://www.google.com/">
                </div>
            </div>
                    
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button type="submit" class="btn btn-sm btn-primary">{lang('add')}</button>
                </div>
            </div>  
              
        </div>
          {/if}
            <div class="panel-body">
            {form_open_multipart('admin/home/upload_latest_updates','role="form" class="" name= "edit_profile"  id="edit_profile"')}
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="control-label pro-label">{lang('mba_update_page')}</label>
                    <div data-provides="fileupload" class="bg_file_upload pro_file_upload">
                        <input name="file1" id="file1" type="file">
                        <label>{lang('select_file')}</label>
                    </div>
                </div>
            </div>
             <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('url')}</label>
                    <input type="text" name="url" id="url" class="form-control" placeholder="https://www.google.com/">
                </div>
            </div>
                    
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button type="submit" class="btn btn-sm btn-primary">{lang('add')}</button>
                </div>
            </div>  
              
        </div>

    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend">{lang('upload_list')}</span>
                
            </legend>
            <div>
                   <div class="panel panel-default table-responsive">
                        {if $banner_count >0}
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                               
                                <th>{lang('banner')}</th>
                                <th>{lang('url')}</th>
                                <th>{lang('edit')}</th>
                                <th>{lang('action')}</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        {assign var="path" value="{$BASE_URL}admin/"}
                       
                       
                                <tr>
                                    <td><img src="{$SITE_URL}/uploads/images/latest_uploads/{$banner.image_name}" style="height: 150px; width:200px;"/></td>  
                                    <td><input type="text" name="url2" id="url2" class="form-control" placeholder="https://www.google.com/" value="{$banner.url}"></td>
                                    <td> 
                                    <input name="file2" id="file2" type="file">
                                   
                                    </td>
                                    <td> <button type="submit" class="btn btn-sm btn-primary">{lang('update')}</button></td>
                                    </tr>
               
                        </tbody>
                        
                    </table>
              
                {else}
        <h4 align="center">{lang('no_bannerrs')}</h4>
{/if}
                </div>
                    {form_close()}
                    <div class="panel panel-default table-responsive">
                    {if $count >0}
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('image')}</th>
                                  <th>{lang('url')}</th>
                              
                              <!--  <th>{lang('status')}</th>-->
                                <th>{lang('action')}</th>
                                <th>{lang('Inactive')}</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        {assign var="path" value="{$BASE_URL}admin/"}
                        
                        {foreach from=$image_details item=v}
                                <tr>
                                    <td>{counter}</td>
                                    <td><img src="{$SITE_URL}/uploads/images/latest_uploads/{$v.image_name}" style="height: 150px; width:200px;"/></td> 
                                      <td><input type="text" name="url_image" id="url_image" class="form-control" placeholder="https://www.google.com/" value="{$v.url}" readonly></td>
                                   
                                  
                                   
                                   <td>  <a href="{$PATH_TO_ROOT_DOMAIN}admin/home/update_image_update/{$v.id}" onclick="return confirm('Do u want to edit?')"  title="Enable" class="has-tooltip btn-link btn_size text-info">
                                     <i class="fa fa-edit"></i> </a></td> <!--<td>{lang($v.status)}</td>-->
                                    <td class="ipad_button_table">
                                        {if $v.status=="active"}
                                            
                                            <button class="btn-link btn_size has-tooltip text-info inactivate_membership_package" onclick="inactivate_image({$v.id}, '{$path}')" title="{lang('inactivate')}"><i class="fa fa-ban"></i></button>
                                        {else}
                                            <button class="has-tooltip btn-link btn_size text-info" onclick="activate_image({$v.id}, '{$path}')" title="{lang('activate')}"><i class="icon-check"></i></button>
                                        {/if}
                                    </td>
                                </tr>
                        {/foreach}
                       
                        </tbody>
                        
                    </table>
                     {else}
                <div class="panel-body">{lang('no_uploads')}</div>
            
                    {/if}
                </div>
            </div>
        </div>
    </div>
{/block}