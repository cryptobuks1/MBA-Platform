{include file="super_admin/layout/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('all_registerd_users')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>

            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover table-full-width" id=""> 
                    <thead>
                        <tr class="th">
                            <th>{lang('sl_no')}</th>
                            <th>{lang('user_names')}</th>
                            <th>{lang('phones')}</th>
                            <th>{lang('emails')}</th>
                            <th>{lang('country')}</th>
                            <th>{lang('skype_id')}</th>                               

                        </tr>
                    </thead>
                    {if $count>0} 
                        {assign var="i" value=0}
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {assign var="class" value=""}
                        <tbody>
                            {foreach from=$all_registered_users item=v}

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}

                                <tr>                             
                                    <td>{$v.page_no}</td>                                        
                                    <td>{$v.user_name}</td>
                                    <td>{$v.phone}</td>
                                    <td>{$v.email}</td>
                                    <td>{$v.country}</td>
                                    <td>{$v.skype_id}</td>
                                </tr>
                                {$i=$i+1}
                            {/foreach}
                        </tbody>
                    {else}                   
                        <tbody>
                            <tr><td colspan="12" align="center"><h4>{lang('no_user_found')}</h4></td></tr>
                        </tbody> 
                    {/if}
                </table>
                {$pagination}

            </div>

        </div>
    </div>   
</div>  

{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}  