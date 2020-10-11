{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('you_must_enter_file_title')}</span>
    <span id="validate_msg2">{lang('you_must_select_a_file')}</span>
    <span id="validate_msg3">{lang('you_must_enter_file_description')}</span>
    <span id="validate_msg4">{lang('qstn_max')}</span>
    <span id="validate_msg5">{lang('max_50')}</span>
    <span id="validate_msg6">{lang('kb')}</span>
</div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/news/upload_materials" class="btn m-b-xs btn-sm btn-info btn-addon" ><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open_multipart('admin/upload_new_material','role="form" class="" name="upload_materials" id="upload_materials"')}
                {include file="layout/error_box.tpl"}
                <div class="form-group">
                <label class="control-label required" for="category">{lang('File_category')}</label>
                    <select  class="form-control" id="category" name="category">
                        {foreach from=$file_type item=v}
                        <option value="{$v.c_id}">{lang($v.type)}</option>
                    {/foreach}
                    </select>
                    {form_error('category')}
                </div>
                <div class="form-group">
                    <label class="control-label required" for="file_title">{lang('File_Title')}</label>
                    <input class="form-control" type="text" name="file_title" id="file_title" value=""/>
                    {form_error('file_title')}
                 </div>

                 <div class="form-group">
                 <label class=" control-label required" for="file_desc">{lang('file_desc')}</label>
                 <textarea class="form-control textfixed" name="file_desc" id="file_desc"></textarea>
                 {form_error('file_desc')}
                 </div>

                  
                <div class="form-group">
                <label class="control-label required" for="product_id"> {lang('Select_A_file')}</label>
                     <div class="bg_file_upload" data-provides="fileupload" >
                            <div class="user-edit-image-buttons">
                                    <input type="file" id="upload_doc" name="upload_doc" >
                                 <p id="1" style="color: #ff0000;" class="ext form-control-static m-t-xs">{lang('kb')}({lang('Allowed_types_are_pdf_ppt_docs_xls_xlsx')})</p>
                                 <p id="2" style="color: #ff0000;display:none;" class="ext form-control-static m-t-xs">{lang('kb')}({lang('Allowed_types_are_png_jpeg')})</p>
                                 <p id="3" style="color: #ff0000;display:none;" class="ext form-control-static m-t-xs">{lang('kb')}({lang('Allowed_types_are_mov_mp4')})</p>

                            </div>
                        </div>
                 </div>

                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" name="upload_submit" id="upload_submit"  value="{lang('upload')}" > {lang('upload')} </button>
                </div>
            {form_close()}
        </div>
    </div>
{/block}

{block name=script}
  {$smarty.block.parent}
<script src="{$PUBLIC_URL}/javascript/validate_news.js"></script>

{/block}