<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$title}</title>
    <link rel="shortcut icon" type="image/png" href="{$PUBLIC_URL}images/logos/{$site_info['favicon']}" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="VBThemes" />
    <link rel="stylesheet" type="text/css" href="{$PUBLIC_URL}css/lcp/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{$PUBLIC_URL}css/lcp/style.css">
    <link rel="stylesheet" type="text/css" href="{$PUBLIC_URL}css/lcp/layout.css">
    
    {block name=style}{/block}
</head>

<body>
<input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}" />
    <input type="hidden" name="current_url" id="current_url" value="{$CURRENT_URL}" />
    <input type="hidden" name="current_url_full" id="current_url_full" value="{$CURRENT_URL_FULL}" />

    {block name=content}{/block}
  
  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}javascript/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}javascript/switch_lang.js" type="text/javascript"></script>
    {foreach from = $ARR_SCRIPT item=v}
    {assign var="type" value=$v.type}
    {assign var="loc" value=$v.loc}
        {if $type == "js"}
            <script src="{$PUBLIC_URL}javascript/{$v.name}" type="text/javascript"></script>
        {elseif $type == "css"}
            <link href="{$PUBLIC_URL}css/{$v.name}" rel="stylesheet" type="text/css" />
        {elseif $type == "plugins/js"}
            <script src="{$PUBLIC_URL}plugins/{$v.name}" type="text/javascript"></script>
        {elseif $type == "plugins/css"}
            <link href="{$PUBLIC_URL}plugins/{$v.name}" rel="stylesheet" type="text/css" />
        {/if}
    {/foreach}

    {$curr_date = date('Y')}
    <p class="text-center">
    {$curr_date} © {$site_info['company_name']} 
    {if $FOOTER_DEMO_STATUS=='yes'}
    - {lang('developed_by_infinite_open_source_solution_llp')}
    {/if}
</p>
    <script>
        jQuery(document).ready(function () {
            jQuery("#close_link").click(function () {
                jQuery("#message_box").fadeOut(1000);
            });
        });
    </script>
    {block name=script}{/block}
</body>

</html>