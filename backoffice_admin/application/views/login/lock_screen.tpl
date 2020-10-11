{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('please_enter_password')}</span>
</div>
<div class="app app-header-fixed ">

    {form_open('login/validate_lock_screen', 'role="form" class="" method="POST" name="form" id="form"')}
    <div class="modal-over bg-black">
        <div class="modal-center lock_screen animated fadeInUp text-center">
            {include file="layout/alert_box.tpl"}
            <div class="thumb-lg">
                <img src="{$SITE_URL}/uploads/images/profile_picture/{$user_photo}" class="img-circle">
            </div>
            <p class="h4 m-t m-b">{$user_user_name}</p>
            <div class="input-group">
                <input type="password" class="form-control text-sm btn-rounded no-border" placeholder="{lang('please_enter_password')}" id='password' name='user_password'>
                <span class="input-group-btn">
        <button type="submit" class="btn btn-success btn-rounded no-border"><i class="fa fa-arrow-right"></i></button>
      </span>
            </div>
        </div>
    </div>
    <input type="hidden" value="{$user_user_name}" name="user_username" /> {form_close()}

</div>

{/block}

{block name=script}
    {$smarty.block.parent}
    <script>
        $("#form").submit(function(){
            var pass = $("#password").val();
            pass = encodeURIComponent(window.btoa(pass));
            $("#password").val(pass);
        }); 
    </script>
{/block}