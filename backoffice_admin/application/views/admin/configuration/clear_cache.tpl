{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
     {include file="common/notes.tpl" notes=lang('note_clear_cache')}
    <div class="panel panel-default">
        <div class="panel-body">    
            {form_open('','role="form" class="smart-wizard" name="sms_form" id="username_config_form"')}
                <button class="btn btn-sm btn-primary btn-addon" type="submit" name="flush_cache" id="flush_cache" value="flush_cache">
                    <i class="fa fa-plus"></i>{lang('flush_cache')} <span class="badge">{$filecount}</span>
                </button>
                <span id="username_box" style="display:none;"></span>
             {form_close()}
        </div>
    </div>
   
{/block}