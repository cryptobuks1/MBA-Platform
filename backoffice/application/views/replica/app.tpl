<!DOCTYPE html>
<html lang="en" class="">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{$title}</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="{$PUBLIC_URL}replica/theme/css/bootstrap.min.css">
    <link rel="stylesheet" href="{$PUBLIC_URL}replica/theme/css/main.css">
    <link rel="stylesheet" href="{$PUBLIC_URL}replica/theme/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{$PUBLIC_URL}replica/theme/css/menu.css">
    <link rel="stylesheet" href="{$PUBLIC_URL}replica/theme/css/responsive.css">
    <link rel="stylesheet" href="{$PUBLIC_URL}replica/theme/css/app.css">
    <link rel="stylesheet" href="{$PUBLIC_URL}replica/plugins/zebra-datepicker/css/metallic/zebra_datepicker.min.css" />
    {block name=style}{/block}
</head>

<body data-spy="scroll" data-target="#navbar" data-offset="60">
    <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}" />
    <input type="hidden" name="current_url" id="current_url" value="{$CURRENT_URL}" />
    <input type="hidden" name="current_url_full" id="current_url_full" value="{$CURRENT_URL_FULL}" />
    <input type="hidden" name="site_url" id="site_url" value="{$SITE_URL}/" />

    {if !$MAINTENANCE_MODE }
    <div id='preloader'>
        <div class='loader'>
           <!--  <img src="{$PUBLIC_URL}replica/theme/img/three-dots.svg" width="60" alt=""> -->
        </div>
    </div><!-- Preloader -->
    <div class="bg-dark_top">
        <div class="container">
            <ul class="nav navbar-nav nav-menu">
                <li class="m-l"><i class="fa fa-user-o"></i> {$USER_DATA['user_name']}</li>
                <li class="m-l"><i class="icon-user"></i><i class="fa fa-envelope-open-o"></i> {$USER_DATA['email']}</li>
                {*<li class="m-l"><i class="icon-user"></i><i class="fa fa-phone-square"></i> {$USER_DATA['phone']}</li>*}
            </ul>
            
            {if $LANG_STATUS == 'yes'}
            <div class="pull-right">
                <a class="dropdown-toggle lang-a" data-close-others="true" data-hover="dropdown" data-toggle="dropdown"
                    href="#">

                    {foreach from=$LANG_ARR item=v}
                    {if $LANG_ID == $v.lang_id}
                    <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" />
                    {/if}
                    {/foreach}
                </a>
                <ul class="language_block dropdown-menu lang" data-hover="dropdown">
                    {foreach from=$LANG_ARR item=v}
                    <li onclick="getSwitchLanguage('{$v.lang_code}');">
                        <span class="dropdown-menu-title">
                            <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" />
                            {$v.lang_name}
                        </span>
                    </li>
                    {/foreach}
                </ul>
            </div>
            {/if}
            
        </div>
    </div>
    <header id="header" class="header_section">
        <nav id="navbar_wrap" class="navbar header_1 header">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="nav-btn navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="brand"><img alt="Infinite MLM Software" src="{$BASE_URL}../uploads/images/logos/{$site_info['logo']}"
                            style="height: 50px;"> </a> </div>
                <div id="navbar" class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav nav-menu">
                        <li {if $CURRENT_URL=='replica/home' } class="active" {/if}> <a href="{SITE_URL}/replica/home">{lang('Home')}</a></li>
                        <li {if $CURRENT_URL=='replica/about_us' } class="active" {/if}> <a href="{SITE_URL}/replica/about_us">{lang('About')}</a></li>
                        <li {if $CURRENT_URL=='replica/contact' } class="active" {/if}> <a href="{SITE_URL}/replica/contact">{lang('Contact')}</a></li>
                        <li {if $CURRENT_URL=='replica/user_register' } class="active" {/if}> <a href="{SITE_URL}/replica_register">{lang('Register')}</a></li>
                    </ul>
                </div>
                <!--/.navbar-collapse -->
            </div>
        </nav>
    </header>

    {if isset($content['top_banner'])}
    <section id="home" class="hero_section" style='background-image: url("{$SITE_URL}/uploads/images/banners/{$content["top_banner"]}");'>
        {else}
        <section id="home" class="hero_section" style='background-image: url({$BASE_URL}../backoffice/public_html/images/banners/banner_image1.png);'>
            {/if}
            <div class="container">
                <div class="display-table">
                    <div class="table-cell">
                        <div class="hero_content align-center">

                            <h1>{$site_info['company_name']}</h1>
                            {* <span>No matter what the problem is, We have infinite solutions.</span> *}
                            <br>
                            <a href="{SITE_URL}/replica_register" class="zarra_btn">Join Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- Hero Section -->

        <div class="app app-header-fixed ">
            {block name=$CONTENT_BLOCK}{/block}
        </div>

        {if $ADDON_MODULE}
        <div class="container" style="margin-top: 18px;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <p><i class="fa fa-info-circle"></i> <b>Note!</b> This is add-on module. <a href="https://infinitemlmsoftware.com/pricing.php"
                                target="_blank"><b>Click here</b></a> for more details.</p>
                    </div>
                </div>
            </div>
        </div>
        {/if}
        {block name=footer}
        <footer class="footer_section  bg-dark align-center">
            <div class="container">
                <p class="pull-left">{'Y'|date} © {if isset($site_info['company_name'])} {$site_info['company_name']} {else} Infinite MLM Software 10.0 - Developed by Infinite Open Source
                    Solutions LLP™ {/if}</p>
                <div class="pull-right">
                    <a href="{$BASE_URL}replica/policy">Privacy Policy</a> I
                    <a href="{$BASE_URL}replica/terms">Terms and Conditions</a>
                </div>
            </div>
        </footer><!-- /.footer_section -->
        {/block}
        <a data-scroll href="#header" id="scroll-to-top"><i class="fa fa-angle-up" style="font-size: 25px;"></i> </a>

        <script src="{$PUBLIC_URL}replica/theme/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="{$PUBLIC_URL}replica/theme/js/vendor/bootstrap.min.js"></script>
        <script src="{$PUBLIC_URL}replica/theme/js/main.js"></script>
        <script src="{$PUBLIC_URL}replica/js/switch_lang.js" type="text/javascript"></script>
        <script>
            $(function () {
                $.ajaxSetup({
                    data: {
                    {$CSRF_TOKEN_NAME}: "{$CSRF_TOKEN_VALUE}"
                }
            });
        });
        </script>


        {block name=script}{/block}
        {foreach from = $ARR_SCRIPT item=v}
        {assign var="type" value=$v.type}
        {assign var="loc" value=$v.loc}
        {if $type == "js"}
        <script src="{$PUBLIC_URL}replica/js/{$v.name}" type="text/javascript"></script>
        {elseif $type == "css"}
        <link href="{$PUBLIC_URL}replica/css/{$v.name}" rel="stylesheet" type="text/css" />
        {elseif $type == "plugins/js"}
        <script src="{$PUBLIC_URL}replica/plugins/{$v.name}" type="text/javascript"></script>
        {elseif $type == "plugins/css"}
        <link href="{$PUBLIC_URL}replica/plugins/{$v.name}" rel="stylesheet" type="text/css" />
        {/if}
        {/foreach}
</body>

</html>
{/if}
