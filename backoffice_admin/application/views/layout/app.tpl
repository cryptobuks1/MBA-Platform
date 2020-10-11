<!DOCTYPE html>
<html lang="en" class="">

<head>
    <title>{$title}</title>
    <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 5.0, user-scalable = yes">


    {*!-- start: THEME STYLES --*}
    <link rel="shortcut icon" type="image/png" href="{$SITE_URL}/uploads/images/logos/{$site_info["favicon"]}" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/libs/assets/animate.css/animate.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/libs/assets/font-awesome/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/libs/assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/libs/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/font.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/libs/jquery/zebra-datepicker/css/metallic/zebra_datepicker.min.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/libs/jquery/autocomplete/jquery.autocomplete.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/app.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/custom.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/libs/jquery/tooltipster/css/tooltipster.bundle.min.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/libs/jquery/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css" type="text/css" />

    {*!-- end: THEME STYLES --*}

    {*!-- start: INDIVIDUAL PAGE STYLES/SCRIPTS --*}
    {foreach from = $ARR_SCRIPT item=v}
        {assign var="type" value=$v.type}
        {assign var="loc" value=$v.loc}
        {if $loc == "header"}
            {if $type == "js"}
                <script src="{$PUBLIC_URL}javascript/{$v.name}" type="text/javascript" ></script>
            {elseif $type == "css"}
                <link href="{$PUBLIC_URL}css/{$v.name}" rel="stylesheet" type="text/css" />
            {elseif $type == "plugins/js"}
                <script src="{$PUBLIC_URL}plugins/{$v.name}" type="text/javascript" ></script>
            {elseif $type == "plugins/css"}
                <link href="{$PUBLIC_URL}plugins/{$v.name}" rel="stylesheet" type="text/css" />
            {/if}
        {/if}
    {/foreach}
    {*!-- end: INDIVIDUAL PAGE STYLES/SCRIPTS --*}

    {block name=style}{/block}

</head>

<body>

    {*!-- start: HIDDEN INPUTS --*}
    <input type = "hidden" name = "base_url" id = "base_url" value = "{$BASE_URL}" />
    <input type = "hidden" name = "img_src_path" id="img_src_path" value="{$PUBLIC_URL}"/>
    <input type = "hidden" name = "current_url" id = "current_url" value = "{$CURRENT_URL}" />
    <input type = "hidden" name = "current_url_full" id = "current_url_full" value = "{$CURRENT_URL_FULL}" />
    <input type = "hidden" name = "DEFAULT_CURRENCY_VALUE" id="DEFAULT_CURRENCY_VALUE" value="{$DEFAULT_CURRENCY_VALUE}"/>
    <input type = "hidden" name = "DEFAULT_CURRENCY_CODE" id="DEFAULT_CURRENCY_CODE" value="{$DEFAULT_CURRENCY_CODE}"/>
    <input type = "hidden" name = "DEFAULT_SYMBOL_LEFT" id="DEFAULT_SYMBOL_LEFT" value="{$DEFAULT_SYMBOL_LEFT}"/>
    <input type = "hidden" name = "DEFAULT_SYMBOL_RIGHT" id="DEFAULT_SYMBOL_RIGHT" value="{$DEFAULT_SYMBOL_RIGHT}"/>
    <input type = "hidden" name = "DEFAULT_PRECISION" id="DEFAULT_PRECISION" value="{$PRECISION}"/>
    {if $LOG_USER_ID}
    <input type = "hidden" name = "logout_time" id="logout_time" value="{$Logout_time}"/>
    {/if}

    {$left_symbol = NULL}
    {$right_symbol = NULL}
    {$input_group_hide = "input-group-hide"}
    {if $DEFAULT_SYMBOL_LEFT}
        {$input_group_hide = ""}
        {$left_symbol = "<span class='input-group-addon'>$DEFAULT_SYMBOL_LEFT</span>"}
    {/if}
    {if $DEFAULT_SYMBOL_RIGHT}
        {$input_group_hide = ""}
        {$right_symbol = "<span class='input-group-addon'>$DEFAULT_SYMBOL_RIGHT</span>"}
    {/if}
    <input type="hidden" name="input_group_hide" id="input_group_hide" value="{$input_group_hide}">

    {*!-- end: HIDDEN INPUTS --*}

    <div class="app app-header-fixed ">
        {block name=header}{/block}
        {block name=sidebar}{/block}
        {block name=content}{/block}
        {block name=footer}{/block}
        {block name=theme_setting}{/block}
    </div>

    {*!-- start: THEME SCRIPTS --*}
    <script src="{$PUBLIC_URL}theme/libs/jquery/jquery/dist/jquery.js"></script>
    <script src="{$PUBLIC_URL}theme/js/jquery.min.js"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                data: {
                    {$CSRF_TOKEN_NAME}: "{$CSRF_TOKEN_VALUE}"
                }
            });
            themeSettingData = {$THEME_SETTING};
        });
    </script>
    {if $LANG_ID == 1}  {$lang_code = ''} {else if $LANG_ID == 2} {$lang_code = '_es'} {else if $LANG_ID == 3} {$lang_code = '_ch'} {else if $LANG_ID == 4} {$lang_code = '_de'}  {else if $LANG_ID == 5} {$lang_code = '_pt'} {else if $LANG_ID == 6} {$lang_code = '_fr'} 
    {else if $LANG_ID == 7} {$lang_code = '_it'} {else if $LANG_ID == 8} {$lang_code = '_tr'} {else if $LANG_ID == 9} {$lang_code = '_po'} {else if $LANG_ID == 10} {$lang_code = '_ar'} {else if $LANG_ID == 11} {$lang_code = '_ru'}  {else} {$lang_code = ''} {/if}
    
    <script src="{$PUBLIC_URL}theme/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
    <script src="{$PUBLIC_URL}theme/js/ui-load.js"></script>
    <script src="{$PUBLIC_URL}theme/js/ui-jp.config.js"></script>
    <script src="{$PUBLIC_URL}theme/js/ui-jp.js"></script>
    <script src="{$PUBLIC_URL}theme/js/ui-nav.js"></script>
    <script src="{$PUBLIC_URL}theme/js/ui-toggle.js"></script>
    <script src="{$PUBLIC_URL}theme/js/ui-client.js"></script>
    <script src="{$PUBLIC_URL}theme/js/wizard.js"></script>
    <script src="{$PUBLIC_URL}theme/js/theme-setting.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}theme/libs/jquery/zebra-datepicker/zebra_datepicker.min{$lang_code}.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}theme/libs/jquery/autocomplete/jquery.autocomplete.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}theme/libs/jquery/ckeditor/ckeditor.js"></script>
    <script src="{$PUBLIC_URL}theme/js/custom.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}theme/libs/jquery/tooltipster/js/tooltipster.bundle.min.js" type="text/javascript"></script>
    {*!-- end: THEME SCRIPTS --*}

    <script src="{$PUBLIC_URL}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="{$PUBLIC_URL}javascript/main.js"></script>

    {* <script src="{$PUBLIC_URL}javascript/switch_lang.js" type="text/javascript" ></script> *}

    {*!-- start: INDIVIDUAL PAGE STYLES/SCRIPTS --*}
    {foreach from = $ARR_SCRIPT item=v}
        {assign var="type" value=$v.type}
        {assign var="loc" value=$v.loc}
        {if $loc == "footer"}
            {if $type == "js"}
                <script src="{$PUBLIC_URL}javascript/{$v.name}" type="text/javascript" ></script>
            {elseif $type == "css"}
                <link href="{$PUBLIC_URL}css/{$v.name}" rel="stylesheet" type="text/css" />
            {elseif $type == "plugins/js"}
                <script src="{$PUBLIC_URL}plugins/{$v.name}" type="text/javascript" ></script>
            {elseif $type == "plugins/css"}
                <link href="{$PUBLIC_URL}plugins/{$v.name}" rel="stylesheet" type="text/css" />
            {/if}
        {/if}
    {/foreach}
    {*!-- end: INDIVIDUAL PAGE STYLES/SCRIPTS --*}

    {block name=script}{/block}

</body>

</html>
