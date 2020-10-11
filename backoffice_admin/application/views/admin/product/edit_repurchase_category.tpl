{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_your_category_name')}</span>
</div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/repurchase_category" class="btn m-b-xs btn-sm btn-info btn-addon" ><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    
    <div class="panel panel-default">
         <div class="panel-body">
            {form_open_multipart('admin/edit_repurchase_category','class="" role="category_form" id="category_form"')}
              {include file="layout/error_box.tpl" id="err_ntfctn_add"}
              <input type="hidden" name="category_id" value="{$category_details.category_id}">
                <div class="form-group">
                    <label class="control-label required" for="category_name">{lang('category_name')}</label>
                        <input class="form-control" type="text" name="category_name" id="category_name"  value="{set_value('category_name', $category_details['category_name'])}" autocomplete="off"/>
                        <span name ='form_err'>{form_error('category_name')}</span>
               </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" name="update_cat" id="update_cat" value="update_cat" >{lang('update')}</button>
                </div> 
            {form_close()} 
        </div>
    </div>
{/block}