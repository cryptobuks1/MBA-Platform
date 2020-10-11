{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
   
<div id="span_js_messages" style="display: none;"> 
    
    <span id="confirm_msg_edit_video">{lang('confirm_msg_edit_video')}</span>
    <span id="error_msg2">{lang('description_required')}</span> 
    <span id="error_msg3">{lang('video_title_required')}</span>
    <span id="error_msg6">{lang('sort_order_required')}</span>
    <span id="error_msg9">{lang('digit_greater_than_0')}</span>
    <span id="error_msg7">{lang('digits_only')}</span> 
    <span id="validate_msg28">{lang('sort_order_not_available')}</span>
    <span id="validate_msg5">{lang('sort_order_available')}</span>
    <span id="validate_msg27">{lang('checking_sort_order')}</span>
    
</div>
    
        <div class="panel panel-default">
            <div class="tab">
                <div class="content">
                    {form_open_multipart('admin/member/vimeo_upload','role="form" class="smart-wizard form-horizontal"  name="video" id="video"')}
                    
<input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
<input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"/>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="video_title">
                            {lang('video_title')}<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input  type="text"  class="form-control" name="video_title" id="video_title"  autocomplete="Off" tabindex="4" value=""  >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="video">
                            {lang('video_file')}
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input class="" type="file" name="video" id="video"  value=""  tabindex="3" > </input>
                            </div>
                        </div>
                          <span class="symbol required" >Note: Please select Video File or Video link to Upload videos</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="video_link">
                            {lang('video_link')}
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input  class="form-control" type="text" name="video_link" id="video_link"  value=""  tabindex="3" > </input>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!--<div class="form-group">
                        <label class="col-sm-2 control-label" for="from_date">
                            {lang('poster')}<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input class="" type="file" name="poster" id="poster"  value=""  tabindex="3" required> </input>
                            </div>
                        </div>
                        <p class="help-block">
                                   {lang('files')}<span class="symbol required"></span> 
                                </p>
                    </div>-->

              

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="type">
                            {lang('package_type')}
                        </label>
                        <div class="col-sm-3"> 
                            <div class="input-group" style="width: 100% !important;">
                                <select  name="package_type[]" id="package_type" class="form-control" >
                                   {foreach from=$package item=v}                                 
                                    <option value="{$v.module_id}">{lang($v.video_module_name)}</option>                      
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="type">
                            {lang('video_type')}
                        </label>
                        <div class="col-sm-3"> 
                            <div class="input-group" style="width: 100% !important;">
                                <select  name="video_type" id="video_type" class="form-control">
                                    
                                       <option value="normal">{lang('normal')}</option>   
                                    <option value="get_started">{lang('get_started')}</option>
                                    <option value="live_session">{lang('live_session')}</option>   
                                    <option value="grow_your_business">{lang('grow_your_business')}</option>
                                
                                </select>
                            </div>
                        </div>
                    </div>
                    
                                          <div class="form-group">
                        <label class="col-sm-2 control-label" for="sort_order">
                            {lang('sort_order')}<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input  type="text"  class="form-control" name="sort_order" id="sort_order"  autocomplete="Off" tabindex="4" value=""  >
                                 <span id="checkmsg" class="error-img"></span>
                                   {form_error('sort_order')}
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="video_description">
                            {lang('video_description')}<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                            <textarea rows="4" cols="50" name="video_description" id="video_description">
                            </textarea>
                            
                            </div>
                        </div>
                    </div>


                          <div class="form-group">
                        <label class="col-sm-2 control-label" for="from_date">                            
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <button class="btn btn-bricky" type="submit" name="submit" id="submit"  value=""  tabindex="3"> {lang('add_video_details')} </button>
                            </div>
                        </div>
                    </div>
            

                    
                    
                 
                    
                    {form_close()}
            </div>
        </div>
    </div>
            <div class="panel panel-default">
            <div class="tab" style="overflow-x:auto;">
                   {if count($videos) > 0}
                   
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('video_type')}</th>
                                <th>{lang('title')}</th>
                                 <th>{lang('description')}</th>
                                   <th>{lang('sort_order')}</th>
                                 
                                <th>{lang('package')}</th>
                                <th>{lang('action')}</th>
                                
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {assign var="i" value=1}
                       {foreach from=$videos item=v}
                        
                                <tr>
                                    <td>{$i+$start}</td>
                                    <td>{lang($v.video_type)}</td>
                                    <td>{$v.title}</td>
                                    <td>{$v.video_description}</td>
                                    <td>{$v.sort_order}</td>
                                     <td>{$v.package_name}</td>
                                     {if $v.delete_status=='no'}
                                    <td> 
                                    <button class="btn-link btn_size has-tooltip text-info" onclick="edit_video({$v.id}, '{$path}')" title="{lang('edit')}"> <i class="fa fa-edit"></i></button>
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/member/disable_enable_video/{$v.id}/disable" title="Disable" class="btn-link btn_size has-tooltip text-info">
                                      {* <b class="badge label-primary-1">Disable</b>*}<i class="fa fa-ban"></i> </a>
                                    <!-- <a href="{$PATH_TO_ROOT_DOMAIN}admin/member/disable_enable_video/{$v.id}/delete" onclick="return confirm('Do u want to Delete the Video?')" title="Delete" class="btn-link btn_size has-tooltip text-info">
                                      {* <b class="badge label-primary-1">Disable</b>*}<i class="fa fa-trash"></i> </a> -->
                                    </td>
                                    {else}
                                    <td>
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/member/disable_enable_video/{$v.id}/enable" onclick="return confirm('Do u want to Disable or Enable the Video?')"  title="Enable" class="has-tooltip btn-link btn_size text-info">
                                      <i class="icon-check"></i> </a>
                                       <!--<a href="{$PATH_TO_ROOT_DOMAIN}admin/member/disable_enable_video/{$v.id}/delete" onclick="return confirm('Do u want to Delete the Video?')" title="Delete" class="btn-link btn_size has-tooltip text-info">
                                      {* <b class="badge label-primary-1">Disable</b>*}<i class="fa fa-trash"></i> </a> -->
                                    </td>
                                    {/if}
                                    
                                </tr>
                               {$i=$i+1}
                        {/foreach}
                        </tbody>
                         {else}
                <h4 align="center">
                    <font>{lang('no_data')}</font>
                </h4>
            {/if}
                    </table>
                    
     
          </div>
        </div>
      
    
    

 {/block}
 
 {block name=script}
  {$smarty.block.parent}
   
      <script src="{$PUBLIC_URL}javascript/validate_rank_configuration.js" type="text/javascript" ></script>
          <script src="{$PUBLIC_URL}javascript/add_video.js" type="text/javascript" ></script>

 {/block}