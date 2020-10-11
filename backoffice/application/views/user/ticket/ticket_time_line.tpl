{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <a class="btn m-b-xs btn-sm btn-info btn-addon pull-right" href="{$BASE_URL}user/ticket/ticket_system"><i class="fa fa-backward"></i>Goto Support Center</a>

    <legend><span class="fieldset-legend">Ticket - {$ticket_id}</span></legend>
    <div id="timeline">
        {if $count > 0} 
            <div class="demo-card-wrapper">
                {assign var="i" value="0"}
                {assign var="j" value=$count}
                {foreach from=$activity_history item=v}
                    {if $i%2==0}
                        <div class="demo-card demo-card--step1">
                            <div class="head">
                                <div class="number-box">
                                    <span>{$j}</span>
                                </div>
                                <h4>{$v.activity}</h4>
                            </div>
                            <div class="body">
                            {if $v.message!=""} <p class="text-center">{$v.message}</p>{/if}
                                <p class="text-center">{$v.date}</p>
                                <p>{lang('done_by')} : {$v.done_by}</p>
                            </div>
                        </div>
                    {else}
                        <div class="demo-card demo-card--step2">
                            <div class="head">
                                <div class="number-box">
                                    <span>{$j}</span>
                                </div>
                                <h4>{$v.activity}</h4>
                            </div>
                            <div class="body">
                            {if $v.message!=""} <p class="text-center">{$v.message}</p>{/if}
                                <p class="text-center">{$v.date}</p>
                                <p>{lang('done_by')} : {$v.done_by}</p>
                            </div>
                        </div>
                    {/if}
                    {$i=$i+1}
                    {$j= $j-1}
                {/foreach}
            </div>
        {else}
            <h3>{lang('no_details_found')}</h3>
        {/if} 
    </div>
    {if $ticket_status!="Resolved" && $count>0}
        <div class="">
            <a href="{$BASE_URL}user/ticket/view_ticket_details/{$ticket_id}" target="_blank"><button class="btn m-b-xs w-xs btn-primary m-t-xs" type="submit" name="reply"  id="referal_details" value="">{lang('reply')}</button>
            </a>
        </div> 
    {/if}
{/block}