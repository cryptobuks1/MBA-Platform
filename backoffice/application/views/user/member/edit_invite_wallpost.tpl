{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;"> 
        <span id="validate_msg1">{lang('enter_subject')}</span>
        <span id="validate_msg2">{lang('enter_message')}</span>
        <span id="validate_msg3">{lang('enter_to_mail_id')}</span>
    </div>

    <div class="button_back">                          
        <a href="{BASE_URL}/user/invites" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</a>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('user/member/invites', 'name="invite" id="invite" class="" method="post"')}
            <div class="form-group">
                <label class="required">{lang('to')}</label>
                <textarea class="form-control" name='to_mail_id' id='to_mail_id' ></textarea>
                <label class="control-label" style="color: #858585;"><i>"{lang('can_enter_multiple_email')}"</i></label>
                {form_error('to_mail_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('subject')}</label>
                <input class="form-control"  type="text"  name ="subject" id ="subject" value="{$mail_details['subject']}" autocomplete="Off">{form_error('subject')}
            </div>
            <div class="form-group">
                <label class="required">{lang('message')}</label>
                <textarea class=" form-control " name='message' id='message'>{$mail_details['content']}</textarea>{form_error('message')}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary" value="invite" name="invite" id="invite">{lang('invite')}</button>
            </div>
            {form_close()}
        </div>
    </div>
{/block}
{block name=script} 
    <script src="{$PUBLIC_URL}javascript/validate_invite.js"></script>
    <script>
        jQuery(document).ready(function() {
            validate_invite.init();
        });
    </script>
{/block}