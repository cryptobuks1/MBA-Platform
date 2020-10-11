{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">

   
    <span id="title_req">{lang('video_title_req')}</span>
    <span id="type_req">{lang('video_type_req')}</span>
    <span id="desc_req">{lang('desc_req')}</span>
    <span id="package_req">{lang('package_req')}</span>
        <span id="error_msg2">{lang('description_required')}</span> 
    <span id="error_msg3">{lang('video_title_required')}</span>
    <span id="error_msg6">{lang('sort_order_required')}</span>
      <span id="error_msg9">{lang('digit_greater_than_0')}</span>
       <span id="error_msg7">{lang('digits_only')}</span> 
</div>

<legend>
    
    <a href="{$BASE_URL}admin/add_video" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        {form_open('', 'role="form" class="" method="post" name="rank_form" id="rank_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('video_type')}</label>
               <!-- <input type="text" class="form-control" name="video_type" id="video_type"   value="{$video_type}" >-->
                
                 <select  name="video_type" id="video_type" class="form-control">
                                     <option value="{$video_type}">{lang($video_type)}</option>  
                                    <option value="normal">{lang('normal')}</option>   
                                    <option value="get_started">{lang('get_started')}</option>
                                    <option value="live_session">{lang('live_session')}</option>   
                                    <option value="grow_your_business">{lang('grow_your_business')}</option>
                                
                                </select>
                {form_error('video_type')}
            </div>
            <div class="form-group">
                <label class="required">{lang('title')}</label>
                <input type="text" class="form-control" name="title" id="title"   value="{$title}" >
                {form_error('title')}
            </div>
             <div class="form-group">
                <label class="required">{lang('video_description')}</label>
                <input type="text" class="form-control" name="video_description" id="video_description"   value="{$video_description}" >
                {form_error('video_description')}
            </div>
            
                <div class="form-group">
                <label class="required">{lang('video_link')}</label>
                <input type="text" class="form-control" name="video_link" id="video_link"   value="{$video_link}" >
                {form_error('video_link')}
            </div>
            
              <div class="form-group">
                       <label class="">{lang('package_type')}</label>
                        
                            <div class="input-group" style="width: 100% !important;">
                                <select  name="package_type[]" id="package_type" class="form-control" >
                                    
                                   {foreach from=$package item=v}                                 
                                    <option value="{$v.module_id}">{lang($v.video_module_name)}</option>                      
                                    {/foreach}
                                </select>
                            </div>
                        {form_error('package_type')}
                    </div>
                   
            <!--<div class="form-group">
                <label class="required">{lang('sort_order')}</label>
                <input type="text" class="form-control" name="sort_order" id="sort_order"   value="{$sort_order}" >
                {form_error('sort_order')}
            </div>-->
           
            <div class="form-group">
                
                    <button class="btn btn-sm btn-primary" name="video_update" type="submit" value="Update">{lang('update')}</button>
                    <input name="id" id="id" type="hidden" value="{$id}" />
              
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
            </div>
        {form_close()}
    </div>
</div>
{/block}

{block name=script}
     {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/validate_rank.js" type="text/javascript" ></script>
        <script src="{$PUBLIC_URL}javascript/add_video.js" type="text/javascript" ></script>
{/block}
