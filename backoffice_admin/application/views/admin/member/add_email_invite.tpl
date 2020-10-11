{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('you_must_enter_subject')}</span>
    <span id="validate_msg2">{lang('you_must_enter_message')}</span>   
</div>

    <div class="button_back">                          
        <a href="{BASE_URL}/admin/member/invite_wallpost_config" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</a>
    </div> 

        <div class="panel panel-default">
            <div class="tab">
                <div class="content">
                    {form_open('','role="form" class="smart-wizard" method="post"  name="soial_invite_email" id="soial_invite_email"')}
                        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">
                        {include file="layout/error_box.tpl"}

                        <div class="form-group">
                            <label class="control-label required" >{lang('subject')}</label>
                                <input class="form-control"  type="text"  name ="subject" id ="subject" value='' autocomplete="Off">
                            {form_error('subject')}
                        </div>

                        <div class="form-group">
                            <label class="control-label required" for="mail_content">{lang('message')}</label>
                            <textarea id="message"  name="message"   class="ckeditor form-control" rows='10'>
                                </textarea>
                                {form_error('message')}
                        </div>

                        <div class="form-group">
                            <button class="btn m-b-xs btn-sm btn-primary btn-addon" type="submit" value="Update" name="submit_email" id="submit_email">{lang('submit')}</button>                                                            
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
{/block}
                
{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/javascript/validate_invite_wallpost.js"></script>
{/block}