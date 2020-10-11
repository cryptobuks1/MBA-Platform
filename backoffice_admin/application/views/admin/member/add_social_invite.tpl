{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('you_must_enter_caption')}</span>
    <span id="validate_msg2">{lang('you_must_enter_description')}</span>  
</div>
    <div class="button_back">                          
        <a href="{BASE_URL}/admin/member/invite_wallpost_config" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</a>
    </div>
    
    <div class="panel panel-default">
        <div class="tab">
            <div class="content">
                {form_open('','role="form" class="smart-wizard" method="post" name="soial_invite_fb" id="soial_invite_fb"')}
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">
                    <input type='hidden' id='' name='social_media' value={$media}>
                    {include file="layout/error_box.tpl"}
                        <div class="form-group">
                            <label class="control-label required">{lang('caption')}</label>
                                <input class="form-control" type="text" name ="caption" id ="caption" value='' autocomplete="Off">
                                {form_error('caption')}
                        </div>
                        <div class="form-group">
                            <label class="control-label required" for="mail_content">{lang('description')}</label>
                                <textarea id="description"  name="description"   class="ckeditor form-control" rows='10'>
                                </textarea>
                                {form_error('description')}
                        </div>
                        <div class="form-group">
                            <button class="btn m-b-xs btn-sm btn-primary btn-addon" type="submit"  value="Update" name="submit_social" id="submit_fb" >{lang('submit')}</button>                                                          
                        </div>
                {form_close()}
            </div>
        </div>
    </div>

{/block}

{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/plugins/ckeditor/ckeditor.js"></script>
    <script src="{$PUBLIC_URL}/plugins/ckeditor/adapters/jquery.js"></script>
    <script src="{$PUBLIC_URL}/javascript/validate_invite_wallpost.js"></script>
{/block}

{block name=link}
  {$smarty.block.parent}
    <link href="{$PUBLIC_URL}/plugins/ckeditor/contents.css">
{/block} 