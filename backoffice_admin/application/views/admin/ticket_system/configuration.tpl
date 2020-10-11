{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;">
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span> 
        <span id="error_msg1">{lang('priority_is_required')}</span>
        <span id="error_msg2">{lang('exceeded_maximum_length')}</span>
        <span id="error_msg3">{lang('status_name_is_required')}</span>
        <span id="error_msg4">{lang('tag_name_is_required')}</span>

        <span id="confirm_msg1">{lang('do_u_want_inactive_priority')}</span>
        <span id="confirm_msg2">{lang('do_u_want_active_priority')}</span>
        <span id="confirm_msg3">{lang('do_u_want_inactive_tag')}</span>
        <span id="confirm_msg4">{lang('do_u_want_inactive_status')}</span>
        <span id="confirm_msg5">{lang('do_u_want_inactive_category')}</span>
        <span id="confirm_msg6">{lang('do_u_want_active_category')}</span>
        <span id="confirm_msg7">{lang('do_u_want_active_tag')}</span>
        <span id="confirm_msg8">{lang('do_u_want_active_status')}</span>
    </div>
    <main>
        <div class="tabsy">
            <input type="radio" id="tab1" name="tab" {$tab1}>
            <label class="tabButton" for="tab1">{lang('status')}</label>
            <div class="tab">
                <div class="content">
                    {form_open('','role="form" class="" method="post" name="new_status" id="new_status" ')}
                    <div class="panel panel-default table-responsive">

                        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{lang('sl_no')}</th>
                                    <th>{lang('status')}</th>
                                    <th>{lang('action')} </th>
                                </tr>
                            </thead>
                            {if $ticketstatus}
                                <tbody>
                                    {assign var="class" value=""}
                                    {assign var="i" value=0}
                                    {foreach from=$ticketstatus item=v}
                                        {if $i%2==0}
                                            {$class='tr1'}
                                        {else}
                                            {$class='tr2'}
                                        {/if}
                                        {$i=$i+1}
                                        <tr class="{$class}">
                                            <td>{$i}</td>
                                            <td>{$v.status}</td>
                                            <td style="text-align:center;">

                                                {if $v.active == 1}
                                                    
                                                        <button class="btn-link btn_size has-tooltip text-info" title="{lang('inactivate')}" onclick="deleteStatus({$v.id});" type="button"><span class="icon-ban"></i></button>
                                                        
                                                    {else} 

                                                    
                                                        <button class="btn-link btn_size has-tooltip text-info" title="Activate" onclick="activateStatus({$v.id});" type="button"><span class="icon-check"></i></button>
                                                       
                                                    {/if}
                                            </td>
                                        </tr>                    
                                    {/foreach}
                                </tbody>
                            {/if}
                            <tfoot id='status'>

                            </tfoot>
                        </table>
                    </div>
                    {form_close()}
                    <button class="btn m-b-xs btn-sm btn-primary btn-addon" title="{lang('add_new_status')}" onclick="addNewStatus();" type="button"><i class="fa fa-plus"></i>{lang('add_new_status')}</button>

                </div>
            </div>
            <input type="radio" id="tab2" name="tab" {$tab2}>
            <label class="tabButton" for="tab2">{lang('tags')}</label>
            <div class="tab">
                <div class="content">
                    {form_open('','role="form" class="" method="post" name="new_tag" id="new_tag"')}
                    <div class="panel panel-default table-responsive">

                        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{lang('sl_no')}</th>
                                    <th>{lang('tags')}</th>
                                    <th>{lang('action')} </th>
                                </tr>
                            </thead>
                            {if $tickettags}
                                <tbody>
                                    {assign var="class" value=""}
                                    {assign var="i" value=0}
                                    {foreach from=$tickettags item=v}

                                        {if $i%2==0}
                                            {$class='tr1'}
                                        {else}
                                            {$class='tr2'}
                                        {/if}
                                        {$i=$i+1}
                                        <tr class="{$class}">
                                            <td>{$i}</td>
                                            <td>{$v.tag}</td>
                                            <td style="text-align:center;">


                                                {if $v.active == 1}
                                                   
                                                        <button class="btn-link btn_size has-tooltip text-info" title="{lang('inactivate')}" onclick="deleteTag({$v.id});" type="button"><span class="icon-ban"></i></button>
                                                         
                                                        {*<button type="button" class="btn btn-bricky" title="Inactivate" title="{lang('inactivate')} {$v.tag}" onclick="deleteTag({$v.id});">
                                                        <span class="icon-ban"></span> {lang('inactivate')}
                                                        </button>*}
                                                    {else} 
                                                  
                                                        <button class="btn-link btn_size has-tooltip text-info" title="Activate" onclick="activateTag({$v.id});" type="button"><span class="icon-check"></i></button>
                                                        
                                                        {* <button type="button" class="btn btn-info " title="Activate" title="{lang('activate')} {$v.tag}" onclick="activateTag({$v.id});">
                                                        <span class="icon-check"></span> {lang('activate')}
                                                        </button>*}
                                                    {/if}



                                            </td>
                                        </tr>                    
                                    {/foreach}
                                </tbody>
                            {/if}
                            <tfoot id='tag'>

                            </tfoot>
                        </table>
                    </div>
                    {form_close()}  
                    <button class="btn m-b-xs btn-sm btn-primary btn-addon" title="{lang('add_new_tag')}" onclick="addNewTag();"><i class="fa fa-plus"></i>{lang('add_new_tag')}</button>
                </div>

            </div>
            <input type="radio" id="tab3" name="tab" {$tab3}>
            <label class="tabButton" for="tab3">{lang('priority')}</label>
            <div class="tab">
                <div class="content">
                    {form_open('','role="form" class="" method="post" name="new_priority" id="new_priority"')}
                    <div class="panel panel-default table-responsive">
                        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{lang('sl_no')}</th>
                                    <th>{lang('priority')}</th>
                                    <th>{lang('delete')}</th>
                                </tr>
                            </thead>
                            {if $ticketpriority}
                                <tbody>
                                    {assign var="class" value=""}
                                    {assign var="i" value=0}
                                    {foreach from=$ticketpriority item=v}

                                        {if $i%2==0}
                                            {$class='tr1'}
                                        {else}
                                            {$class='tr2'}
                                        {/if}
                                        {$i=$i+1}
                                        <tr class="{$class}">
                                            <td>{$i}</td>
                                            <td>{$v.priority}</td>
                                            <td style="text-align:center;">


                                                {if $v.active == 1}
                                                     
                                                        <button class="btn-link btn_size has-tooltip text-info" title="{lang('inactivate')}" onclick="deletePriority({$v.id});" type="button"><span class="icon-ban"></i></button>
                                                        
                                                        {* <button type="button" class="btn btn-bricky" title="Inactivate" title="{lang('inactivate')} {$v.priority}" onclick="deletePriority({$v.id});">
                                                        <span class="icon-ban"></span> {lang('inactivate')}
                                                        </button>*}
                                                    {else} 
                                                     
                                                        <button class="btn-link btn_size has-tooltip text-info" onclick="activatePriority({$v.id});" type="button"><span class="icon-check"></i></button>
                                                        
                                                        {*<button type="button" class="btn btn-info" title="Activate" title="{lang('activate')} {$v.priority}" onclick="activatePriority({$v.id});">
                                                        <span class="icon-check"></span> {lang('activate')}
                                                        </button>*}
                                                    {/if}
                                            </td>
                                        </tr>                    
                                    {/foreach}
                                </tbody>
                            {/if}
                            <tfoot id='priority'>

                            </tfoot>

                        </table>
                    </div>
                    {form_close()}   
                    <button class="btn m-b-xs btn-sm btn-primary btn-addon" title="{lang('add_new_priority')}" onclick="addNewPriority();"><i class="fa fa-plus"></i>{lang('add_new_priority')}</button>
                </div>
            </div>
        </div>
    </main>
{/block}