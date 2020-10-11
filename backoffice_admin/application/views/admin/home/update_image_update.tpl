{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">

   
    <span id="title_req">{lang('video_title_req')}</span>
    <span id="type_req">{lang('video_type_req')}</span>
    <span id="desc_req">{lang('desc_req')}</span>
    <span id="package_req">{lang('package_req')}</span>
</div>

<legend>
    
    <a href="{$BASE_URL}admin/latest_updates" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        {form_open_multipart('', 'role="form" class="" method="post" name="rank_form" id="rank_form"')}
            {include file="layout/error_box.tpl"}
                 <input type="hidden" name="id" id="id" class="form-control"  value="{$id}">
                   <input type="hidden" name="image_name" id="image_name" class="form-control"  value="{$image_name}">
                 
       
            
            <div class="form-group">
                <label class="required">{lang('url')}</label>
             <input type="text" name="url" id="url" class="form-control" placeholder="https://www.google.com/" value="{$url}"></td>
                {form_error('url')}
            </div>
            
             <div class="form-group">
                <label class="required">{lang('image')}</label>
                <input type="file" class="form-control" name="file" id="file"   value="" >
                {form_error('image')}
            </div>
            
           
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
{/block}
