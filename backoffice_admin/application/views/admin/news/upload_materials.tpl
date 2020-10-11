{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    
<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('title_needed')}</span>
    <span id="validate_msg2">{lang('you_must_select_a_file')}</span>  
    <span id="confrm_delete">{lang('confirm_delete')}</span>    
</div>

  <div class="m-b">
   {include file="common/notes.tpl" notes=lang('note_upload_materials')}
  </div>
    <div class="form-group">
        {form_open_multipart('admin/upload_new_material','role="form" class=""  name="upload_form" id="upload_form"')}
            <button type="submit" class="btn m-b-xs btn-sm btn-primary btn-addon" name="uploadsubmit" id="uploadsubmit"  value="{lang('upload')}"> <i class="fa fa-plus"></i> {lang('add_new_material')}</button>
        {form_close()} 
    </div>
    
        {if $arr_count!=0}
        {assign var="path" value="{$BASE_URL}admin/"}
        {assign var="i" value=0}
        {foreach from=$file_details item=v}
        {assign var="id" value="{$v.id}"}
        {assign var="date" value="{$v.uploaded_date|date_format:"%D"}"}
        {assign var="time" value="{$v.uploaded_date|date_format:"%r"}"}
        {assign var="type" value="{$v.doc_file_name|pathinfo:$smarty.const.PATHINFO_EXTENSION}"}
        {if $type == 'jpg' || $type == 'jpeg'} {assign var="type" value="png"} {/if}

        <div class="owl-item active" >
            <div class="row tm-item align-items-center">
                <figure class="col-md-2 col-lg-2">
                    <img src="{$SITE_URL}/uploads/images/logos/{$type}.png" alt="">
                </figure>
                <div class="col-md-10 b-l">
                    <h5>{$v.file_title}</h5>
                    <p>{$v.doc_desc}</p>
                    <span><i class="fa fa-calendar"></i> {$date}</span> I <span><i class="glyphicon glyphicon-time"></i> {$time}</span><br>
                    <a href="{$SITE_URL}/uploads/images/document/{$v.doc_file_name}" class="btn m-b-xs m-t-sm btn-info" title="Download" download=""><i class="glyphicon glyphicon-download-alt"></i></a>
                    {form_open('admin/news/delete_material', 'class="inline-form-button" method="post" onsubmit="return confirmAction(\'confrm_delete\')"')}
                    <input type="hidden" name="id" value="{$id}">
                    <button class="btn m-b-xs m-t-sm btn-danger" title="Delete"><i class="fa fa-trash-o"></i></button>
                    {form_close()}
                </div>
            </div>
        </div>
        <hr>

        {/foreach}   
        {else}
            <div align="center"><h4 align="center"> {lang('No_Materials_Found')}</h4></div>
        {/if}
 

{/block}