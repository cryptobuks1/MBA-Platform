<!-- footer -->
<footer id="footer" class="app-footer" role="footer">
    <div class="wrapper b-t bg-light">
        <span class="pull-right"><a href="javascript:scrollTop();" ui-scroll="app" class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span>
        {date('Y')} &copy; {$site_info['company_name']}
        {if $DEMO_STATUS=='yes' && $is_app}
            - <a href="https://ioss.in" target="_blank" style="text-decoration: none; color: #169ac3;">{lang('developed_by_infinite_open_source_solution_llp')}</a>
        {/if}
    </div>
    {if $is_app}
    {include file="common/chat.tpl" title="" name=""}
    {/if}
</footer>
<!-- / footer -->
