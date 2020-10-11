{extends file="layout/app.tpl"}

{block name=script}
    <script src="{$PUBLIC_URL}javascript/timer.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}javascript/auto_timeout.js" type="text/javascript"></script>
    <script src="{$PUBLIC_URL}javascript/currency.js" type="text/javascript" ></script>
{/block}

{block name=header}
    {include file="layout/user_header.tpl"}
{/block}

{block name=sidebar}
    {include file="layout/sidebar.tpl"}
{/block}

{block name=content}
    <!-- content -->
    <div id="content" class="app-content" role="main">
        <div class="app-content-body ">
            <div class="hbox hbox-auto-xs hbox-auto-sm">
                
                    {block name=page_header}
                        <!-- main header -->
                        {if $HEADER_LANG['page_top_header']}
                            <div class="bg-light lter b-b wrapper-md">
                                <h1 class="m-n font-thin h3">{$HEADER_LANG['page_top_header']}</h1>
                                {if $HEADER_LANG['page_top_small_header']}
                                    <small class="text-muted">{$HEADER_LANG['page_top_small_header']}</small>
                                {/if}
                            </div>
                        {/if}
                        <!-- / main header -->
                    {/block}
                    <div class="wrapper-md">
                    {if $CURRENT_URL != 'mail/mail_management'&& $CURRENT_URL != 'mail/mail_sent' && $CURRENT_URL != 'mail/compose_mail'}
                        {include file="layout/alert_box.tpl"}
                    {/if}
                    {block name=main}{/block}
                
            </div>
        {block name=right_content}{/block}
    </div>
    {if $CURRENT_URL !="home/index" && $CURRENT_URL !="mail/mail_management"&& $CURRENT_URL !="mail/compose_mail" && $CURRENT_URL !="mail/read_mail" && $CURRENT_URL !="mail/reply_mail" && $CURRENT_URL !="ewallet/fund_transfer" && $CURRENT_URL !="mail/mail_sent"}
        {include file="layout/demo_footer.tpl"}
    {/if}     
</div>

</div>
<!-- /content -->
{/block}

{block name=footer}
    {block name=home_wrapper_out}{/block}
    {include file="layout/footer.tpl"}
{/block}

