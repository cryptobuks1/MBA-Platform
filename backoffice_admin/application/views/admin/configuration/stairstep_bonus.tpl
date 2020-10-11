{extends file=$BASE_TEMPLATE}

{block name=style}
     {$smarty.block.parent}
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_donation_bonus.js"></script>
{/block}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;">
        <span id="you_must_enter">{lang('you_must_enter')}</span>
    </div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <legend>
                <span class="fieldset-legend">
                    {lang('donation_commission')}
                </span>
            </legend>
            {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
                {include file="layout/error_box.tpl"}

                
            {form_close()}
        </div>
    </div>

{/block}