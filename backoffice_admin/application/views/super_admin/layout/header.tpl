<!DOCTYPE html>
<html lang="en" class="no-js">
    <!-- start: HEAD -->
    <!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
    <!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
    <head>
        <title>{$title}</title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- end: META -->    
        <link rel="shortcut icon" type="image/png" href="{$SITE_URL}/uploads/images/logos/{$site_info["favicon"]}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-1.0.0.js"></script>
        <script src="{$PUBLIC_URL}javascript/switch_lang.js" type="text/javascript" ></script>
        <!-- start: MAIN CSS -->
        <link href="{$PUBLIC_URL}plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}fonts/style.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/main.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/main-responsive.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css">
        
        <link rel="stylesheet/less" type="text/css" href="{$PUBLIC_URL}css/styles.less">
        <link rel="stylesheet/less" type="text/css" href="{$PUBLIC_URL}css/animations.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/theme_light.css" type="text/css" id="skin_color">        
        {if $CURRENT_CTRL != 'login'}
            <script src="{$PUBLIC_URL}javascript/timer.js" type="text/javascript"></script>
            <script src="{$PUBLIC_URL}javascript/auto_timeout.js" type="text/javascript"></script>
            <script src="{$PUBLIC_URL}javascript/page_loader.js" type="text/javascript"></script>
        {/if}
        
        <!-- end: MAIN CSS -->

        {*!-- start: JS/CSS REQUIRED FOR THIS PAGE ONLY --*}
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
        {*!-- end: JS/CSS REQUIRED FOR THIS PAGE ONLY --*}
        <script>
            $.ajaxSetup({
             
        data: {
            {$CSRF_TOKEN_NAME}: '{$CSRF_TOKEN_VALUE}'
                }
            });
        </script>
    </head>
    <body  class="{if $CURRENT_CTRL =='login'}login example2{/if}" >
        <input type = "hidden" name = "base_url" id = "base_url" value = "{$BASE_URL}" />
        <input type = "hidden" name = "current_url" id = "current_url" value = "{$CURRENT_URL}" />
        <input type = "hidden" name = "current_url_full" id = "current_url_full" value = "{$CURRENT_URL_FULL}" />
        <input type="hidden" name="img_src_path" id="img_src_path" value="{$PUBLIC_URL}"/>
        <input type="hidden" name="DEFAULT_CURRENCY_VALUE" id="DEFAULT_CURRENCY_VALUE" value="{$DEFAULT_CURRENCY_VALUE}"/>
        <input type="hidden" name="DEFAULT_CURRENCY_CODE" id="DEFAULT_CURRENCY_CODE" value="{$DEFAULT_CURRENCY_CODE}"/>
        <input type="hidden" name="DEFAULT_SYMBOL_LEFT" id="DEFAULT_SYMBOL_LEFT" value="{$DEFAULT_SYMBOL_LEFT}"/>
        <input type="hidden" name="DEFAULT_SYMBOL_RIGHT" id="DEFAULT_SYMBOL_RIGHT" value="{$DEFAULT_SYMBOL_RIGHT}"/>

        {if $LOG_USER_ID && $SESS_STATUS} 
            <!--site header-->	
            {include file="super_admin/layout/site_header.tpl" title="Example Smarty Page" name=""}
            <!--site header-->            
        {/if}
