{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_news_title')}</span>
    <span id="error_msg1">{lang('you_must_enter_news')}</span>
    <span id="error_msg2">{lang('max_50')}</span>
    <span id="error_msg3">{lang('qstn_max')}</span>
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_news_there_is_no_undo')}</span>
    <span id="confirm_msg2">{lang('sure_you_want_to_delete_this_news_there_is_no_undo')}</span>
</div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/news/add_news" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('admin/add_new_news','role="form" class="" name="upload_news" id="upload_news"')}
               {include file="layout/error_box.tpl" id="err_upload_news"} 
                <div class="form-group">
                  <label class="control-label required" for="news_title">{lang('news_title')}</label>
                  <input class="form-control" name="news_title" id="news_title" type="text" {if $action == 'edit'} value="{$news_title}" {else} value="{set_value('news_title')}" {/if} />
                  {form_error('news_title')}
                    <span class="help-block" style='color:#b94a48;' for="news_title"></span>
                </div>         
                
                <div class="form-group">
                  <label class="control-label required" for="news_desc">{lang('news_description')}</label>
                  <input type="textarea" class="form-control"  id="news_desc" name="news_desc" {if $action == 'edit'} value="{$news_desc}" {else} value="{set_value('news_desc')}"{/if}>
                    {form_error('news_desc')}
                    <span class="help-block" style='color:#b94a48;' for="news_desc"></span>
                </div>
                
                <div class="form-group">
                    {if $edit_id==""}
                        <button class="btn btn-sm btn-primary" id="news_submit" name="news_submit" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
                    {else}
                        <button class="btn btn-sm btn-primary" name="news_update" id="news_update" type="submit" value="{lang('update')}" > {lang('update')}</button>
                        <input name="news_id" id="news_id" type="hidden"  value="{$news_id}"/>
                    {/if}
                </div>
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">

            {form_close()}
        </div>
    </div>

{/block}

{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/javascript/validate_news.js"></script>
{/block}