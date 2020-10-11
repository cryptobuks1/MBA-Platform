{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <legend><span class="fieldset-legend">{lang('ticket')} - {$ticket_id}</span></legend> 

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
            <div style="text-align: center">  <h3>{lang('no_details_found')}</h3></div>
        {/if} 
    </div>
    {if $ticket_status!="Resolved"}
        <div class="">
            <a href="{$BASE_URL}admin/ticket_system/ticket/{$ticket_id}" target="_blank"><button class="btn m-b-xs w-xs btn-primary m-t-xs" type="submit" name="reply" id="referal_details">{lang('reply')}</button>
            </a>
        </div>
    {/if}
{/block}